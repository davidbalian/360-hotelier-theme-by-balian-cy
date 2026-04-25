/**
 * Portfolio gallery marquee — JS-driven scroll with smooth ease in/out of pause.
 *
 * Pure CSS can only toggle `animation-play-state` abruptly. To get a soft
 * deceleration into pause on hover/focus (and a soft acceleration back to full
 * speed on leave/blur), this module takes over from the CSS keyframe animation
 * and drives the rows via requestAnimationFrame, tweening a 0..1 speed factor
 * with a cubic ease.
 *
 * Single-responsibility split:
 *   - SpeedFactorTween : owns the 0..1 speed value and its eased transitions.
 *   - MarqueeRow       : owns one row's position, direction, and base px/ms.
 *   - MarqueeController: coordinates rows + hover/focus state for one marquee.
 *
 * @package 360-hotelier
 */

( function () {
	'use strict';

	var SETTINGS = {
		rootSelector:    '[data-portfolio-gallery-marquee]',
		rowSelector:     '.portfolio-gallery-marquee__row',
		imageSelector:   'img.portfolio-gallery-marquee__image',
		bottomRowClass:  'portfolio-gallery-marquee__row--bottom',
		jsDrivenClass:   'is-js-driven',
		pauseTweenMs:    350
	};

	/**
	 * Promotes lazy marquee images to eager loading on the user's first scroll
	 * intent. Initial HTML keeps loading="lazy" so page-load cost is zero; the
	 * moment the user shows intent to scroll (wheel, touch, arrow keys, or any
	 * scroll), images start downloading in parallel — so by the time the
	 * marquee scrolls into view the bytes are already on the wire.
	 *
	 * One-shot, idempotent, per marquee root.
	 */
	class MarqueeImagePreloader {
		constructor( rootEl ) {
			this.root  = rootEl;
			this.armed = true;
			this.fire  = this.promote.bind( this );
		}

		start() {
			var opts = { once: true, passive: true };
			window.addEventListener( 'scroll',     this.fire, opts );
			window.addEventListener( 'wheel',      this.fire, opts );
			window.addEventListener( 'touchstart', this.fire, opts );
			window.addEventListener( 'keydown',    this.fire, opts );
		}

		promote() {
			if ( ! this.armed ) {
				return;
			}
			this.armed = false;
			var imgs = this.root.querySelectorAll( SETTINGS.imageSelector );
			Array.prototype.forEach.call( imgs, function ( img ) {
				img.loading = 'eager';
				if ( 'fetchPriority' in img ) {
					img.fetchPriority = 'high';
				}
				if ( typeof img.decode === 'function' ) {
					img.decode().catch( function () {} );
				}
			} );
		}
	}

	/**
	 * Cubic ease in/out — softens both the entry to pause and the exit from it.
	 * @param {number} t Normalized progress in [0, 1].
	 * @returns {number}
	 */
	function easeInOut( t ) {
		return t < 0.5 ? 2 * t * t : 1 - Math.pow( -2 * t + 2, 2 ) / 2;
	}

	/**
	 * Reads the current translateX from a computed transform string. Returns 0
	 * for "none" or anything we can't parse (e.g. very old browsers w/o
	 * DOMMatrix support — we fall back gracefully).
	 *
	 * @param {string} transformStr
	 * @returns {number}
	 */
	function readTranslateX( transformStr ) {
		if ( ! transformStr || transformStr === 'none' ) {
			return 0;
		}
		try {
			return new DOMMatrixReadOnly( transformStr ).m41;
		} catch ( e ) {
			return 0;
		}
	}

	/**
	 * Owns a 0..1 speed factor and tweens it between values with a cubic ease.
	 * Stateless w.r.t. the marquee — just a small numeric controller.
	 */
	class SpeedFactorTween {
		constructor( durationMs ) {
			this.durationMs = durationMs;
			this.value      = 1;
			this.from       = 1;
			this.to         = 1;
			this.startedAt  = 0;
		}

		/**
		 * Begin tweening towards a new target. No-op if already heading there.
		 * @param {number} target 0..1
		 * @param {number} now performance.now()
		 */
		retarget( target, now ) {
			if ( target === this.to ) {
				return;
			}
			this.from      = this.value;
			this.to        = target;
			this.startedAt = now;
		}

		/**
		 * Advance the eased value to the current timestamp.
		 * @param {number} now performance.now()
		 */
		sample( now ) {
			if ( this.value === this.to ) {
				return;
			}
			var t = Math.min( 1, ( now - this.startedAt ) / this.durationMs );
			this.value = this.from + ( this.to - this.from ) * easeInOut( t );
			if ( t >= 1 ) {
				this.value = this.to;
			}
		}
	}

	/**
	 * Owns one marquee row's geometry and current scroll position. Position is
	 * a non-negative magnitude in [0, halfWidth); direction maps it to either a
	 * leftward (top row) or rightward (bottom row) translateX.
	 */
	class MarqueeRow {
		constructor( rowEl ) {
			this.el        = rowEl;
			this.direction = rowEl.classList.contains( SETTINGS.bottomRowClass ) ? 1 : -1;

			var computed   = window.getComputedStyle( rowEl );
			var durationS  = parseFloat( computed.animationDuration ) || 60;
			this.halfWidth = rowEl.scrollWidth / 2;
			this.pxPerMs   = this.halfWidth > 0 ? this.halfWidth / ( durationS * 1000 ) : 0;
			this.position  = this.computeStartPosition( computed.transform );
		}

		/**
		 * Convert the row's current animated translateX into our position
		 * magnitude so that disabling the CSS animation looks seamless.
		 *
		 * @param {string} transformStr
		 * @returns {number}
		 */
		computeStartPosition( transformStr ) {
			if ( this.halfWidth <= 0 ) {
				return 0;
			}
			var x   = readTranslateX( transformStr );
			var pos = this.direction === -1 ? -x : x + this.halfWidth;
			pos     = ( ( pos % this.halfWidth ) + this.halfWidth ) % this.halfWidth;
			return pos;
		}

		/**
		 * Pin the row to its current position via inline style (call once
		 * before disabling the CSS animation to avoid a single-frame jump).
		 */
		freeze() {
			this.advance( 0, 0 );
		}

		/**
		 * Advance the row by dt * speedFactor * baseSpeed and apply transform.
		 * @param {number} dtMs
		 * @param {number} speedFactor 0..1
		 */
		advance( dtMs, speedFactor ) {
			if ( this.halfWidth <= 0 ) {
				return;
			}
			var delta     = this.pxPerMs * speedFactor * dtMs;
			this.position = ( ( ( this.position + delta ) % this.halfWidth ) + this.halfWidth ) % this.halfWidth;
			var x         = this.direction === -1 ? -this.position : this.position - this.halfWidth;
			this.el.style.transform = 'translate3d(' + x + 'px, 0, 0)';
		}
	}

	/**
	 * Coordinates the rows and hover/focus state for a single marquee instance.
	 */
	class MarqueeController {
		constructor( rootEl ) {
			this.root  = rootEl;
			this.rows  = Array.prototype.slice
				.call( rootEl.querySelectorAll( SETTINGS.rowSelector ) )
				.map( function ( r ) { return new MarqueeRow( r ); } );
			this.tween = new SpeedFactorTween( SETTINGS.pauseTweenMs );
			this.lastTickMs    = 0;
			this.isHover       = false;
			this.hasFocusInside = false;
			this.tick = this.tick.bind( this );
		}

		start() {
			if ( this.rows.length === 0 ) {
				return;
			}
			this.rows.forEach( function ( row ) { row.freeze(); } );
			this.root.classList.add( SETTINGS.jsDrivenClass );
			this.bindEvents();
			window.requestAnimationFrame( this.tick );
		}

		bindEvents() {
			var self = this;
			this.root.addEventListener( 'mouseenter', function () { self.setHover( true ); } );
			this.root.addEventListener( 'mouseleave', function () { self.setHover( false ); } );
			this.root.addEventListener( 'focusin',    function () { self.setFocus( true ); } );
			this.root.addEventListener( 'focusout',   function ( e ) {
				if ( ! self.root.contains( e.relatedTarget ) ) {
					self.setFocus( false );
				}
			} );
		}

		setHover( value ) {
			this.isHover = value;
			this.refreshTarget();
		}

		setFocus( value ) {
			this.hasFocusInside = value;
			this.refreshTarget();
		}

		/** Re-evaluate the desired speed factor based on current hover/focus. */
		refreshTarget() {
			var target = ( this.isHover || this.hasFocusInside ) ? 0 : 1;
			this.tween.retarget( target, window.performance.now() );
		}

		tick( now ) {
			var dt = this.lastTickMs ? ( now - this.lastTickMs ) : 0;
			this.lastTickMs = now;
			this.tween.sample( now );
			var speed = this.tween.value;
			this.rows.forEach( function ( row ) { row.advance( dt, speed ); } );
			window.requestAnimationFrame( this.tick );
		}
	}

	/**
	 * Bootstrap: per marquee on the page, instantiate the image preloader
	 * (always — image loading is independent of motion preferences) and the
	 * animation controller (only when reduced-motion isn't requested; CSS
	 * disables the keyframe animation in that case).
	 */
	function init() {
		var prefersReducedMotion = window.matchMedia &&
			window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

		var roots = document.querySelectorAll( SETTINGS.rootSelector );
		Array.prototype.forEach.call( roots, function ( root ) {
			new MarqueeImagePreloader( root ).start();
			if ( ! prefersReducedMotion ) {
				new MarqueeController( root ).start();
			}
		} );
	}

	if ( document.readyState === 'loading' ) {
		document.addEventListener( 'DOMContentLoaded', init );
	} else {
		init();
	}
} )();
