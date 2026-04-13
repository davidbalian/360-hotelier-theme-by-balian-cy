/**
 * Portfolio testimonials: infinite horizontal snap carousel (tripled track).
 */
( function () {
    'use strict';

    var INTERVAL_MS = 5500;

    /**
     * @param {HTMLElement} track
     * @returns {number} Original slide count n (before clone).
     */
    function buildInfiniteTrack( track ) {
        var originals = Array.from( track.querySelectorAll( '[data-testimonial-slide]:not([data-testimonial-clone])' ) );
        var n = originals.length;
        if ( n === 0 ) {
            return 0;
        }

        var fragPre = document.createDocumentFragment();
        var fragPost = document.createDocumentFragment();
        var i;
        for ( i = 0; i < n; i++ ) {
            var cPre = originals[ i ].cloneNode( true );
            cPre.removeAttribute( 'id' );
            cPre.setAttribute( 'data-testimonial-clone', '1' );
            cPre.setAttribute( 'aria-hidden', 'true' );
            fragPre.appendChild( cPre );

            var cPost = originals[ i ].cloneNode( true );
            cPost.removeAttribute( 'id' );
            cPost.setAttribute( 'data-testimonial-clone', '1' );
            cPost.setAttribute( 'aria-hidden', 'true' );
            fragPost.appendChild( cPost );
        }
        track.insertBefore( fragPre, track.firstChild );
        track.appendChild( fragPost );

        if ( typeof window.hotelierLucideHydrate === 'function' ) {
            window.hotelierLucideHydrate( track );
        }

        return n;
    }

    function initCarousel( root ) {
        var viewport = root.querySelector( '[data-testimonial-viewport]' );
        var track = root.querySelector( '[data-testimonial-track]' );

        if ( !viewport || !track ) {
            return;
        }

        var n = buildInfiniteTrack( track );
        var slides = track.querySelectorAll( '[data-testimonial-slide]' );
        if ( n === 0 || slides.length === 0 ) {
            return;
        }

        var dots = root.querySelectorAll( '[data-testimonial-dot]' );
        var btnPrev = root.querySelector( '[data-testimonial-prev]' );
        var btnNext = root.querySelector( '[data-testimonial-next]' );

        var reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
        var paused = false;
        var timer = null;
        var scrollSyncScheduled = false;
        var applyingInfiniteJump = false;
        var activeLogical = 0;

        function slideScrollLeft( domIdx ) {
            return Math.round( slides[ domIdx ].offsetLeft );
        }

        function nearestDomIndex() {
            var left = Math.round( viewport.scrollLeft );
            var best = 0;
            var bestDelta = Infinity;
            var i;
            for ( i = 0; i < slides.length; i++ ) {
                var d = Math.abs( slideScrollLeft( i ) - left );
                if ( d < bestDelta ) {
                    bestDelta = d;
                    best = i;
                }
            }
            return best;
        }

        function logicalFromDom( domIdx ) {
            var raw = slides[ domIdx ].getAttribute( 'data-testimonial-index' );
            return raw ? parseInt( raw, 10 ) : 0;
        }

        function nearestLogicalIndex() {
            return logicalFromDom( nearestDomIndex() );
        }

        function checkInfiniteJump() {
            if ( applyingInfiniteJump ) {
                return;
            }
            var midStart = slideScrollLeft( n );
            var thirdStart = slideScrollLeft( 2 * n );
            var shift = midStart - slideScrollLeft( 0 );
            var left = Math.round( viewport.scrollLeft );
            if ( left < midStart - 1 ) {
                applyingInfiniteJump = true;
                viewport.scrollLeft = left + shift;
                window.requestAnimationFrame( function () {
                    applyingInfiniteJump = false;
                } );
            } else if ( left >= thirdStart - 1 ) {
                applyingInfiniteJump = true;
                viewport.scrollLeft = left - shift;
                window.requestAnimationFrame( function () {
                    applyingInfiniteJump = false;
                } );
            }
        }

        function updateDots( logicalIdx ) {
            dots.forEach( function ( dot, i ) {
                dot.setAttribute( 'aria-selected', i === logicalIdx ? 'true' : 'false' );
            } );
        }

        function scrollToDom( domIdx, smooth ) {
            var el = slides[ domIdx ];
            if ( !el ) {
                return;
            }
            activeLogical = logicalFromDom( domIdx );
            var behavior = reducedMotion || !smooth ? 'auto' : 'smooth';
            var left = slideScrollLeft( domIdx );
            viewport.scrollTo( { left: left, behavior: behavior } );
            updateDots( activeLogical );
        }

        function goToLogical( logicalIdx, smooth ) {
            var idx = ( ( logicalIdx % n ) + n ) % n;
            scrollToDom( n + idx, smooth );
        }

        function goRelative( delta, smooth ) {
            var D = nearestDomIndex();
            if ( delta > 0 ) {
                if ( D >= slides.length - 1 ) {
                    scrollToDom( n, false );
                } else {
                    scrollToDom( D + 1, smooth );
                }
            } else {
                if ( D <= 0 ) {
                    scrollToDom( 3 * n - 1, smooth );
                } else {
                    scrollToDom( D - 1, smooth );
                }
            }
        }

        function advance() {
            goRelative( 1, !reducedMotion );
        }

        function startTimer() {
            if ( reducedMotion || paused || timer ) {
                return;
            }
            timer = window.setInterval( advance, INTERVAL_MS );
        }

        function stopTimer() {
            if ( timer ) {
                window.clearInterval( timer );
                timer = null;
            }
        }

        function onScroll() {
            if ( scrollSyncScheduled ) {
                return;
            }
            scrollSyncScheduled = true;
            window.requestAnimationFrame( function () {
                scrollSyncScheduled = false;
                checkInfiniteJump();
                activeLogical = nearestLogicalIndex();
                updateDots( activeLogical );
            } );
        }

        if ( btnPrev ) {
            btnPrev.addEventListener( 'click', function () {
                goRelative( -1, !reducedMotion );
            } );
        }
        if ( btnNext ) {
            btnNext.addEventListener( 'click', function () {
                goRelative( 1, !reducedMotion );
            } );
        }

        dots.forEach( function ( dot ) {
            dot.addEventListener( 'click', function () {
                var raw = dot.getAttribute( 'data-testimonial-dot' );
                var idx = raw ? parseInt( raw, 10 ) : 0;
                goToLogical( idx, true );
            } );
        } );

        viewport.addEventListener( 'scroll', onScroll, { passive: true } );

        viewport.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'ArrowLeft' ) {
                e.preventDefault();
                goRelative( -1, !reducedMotion );
            } else if ( e.key === 'ArrowRight' ) {
                e.preventDefault();
                goRelative( 1, !reducedMotion );
            }
        } );

        function setPaused( v ) {
            paused = v;
            if ( paused ) {
                stopTimer();
            } else {
                startTimer();
            }
        }

        root.addEventListener( 'mouseenter', function () { setPaused( true ); } );
        root.addEventListener( 'mouseleave', function () { setPaused( false ); } );
        root.addEventListener( 'focusin', function () { setPaused( true ); } );
        root.addEventListener( 'focusout', function ( e ) {
            if ( !root.contains( e.relatedTarget ) ) {
                setPaused( false );
            }
        } );

        function syncScrollAfterResize() {
            scrollToDom( n + activeLogical, false );
        }

        if ( typeof ResizeObserver !== 'undefined' ) {
            var ro = new ResizeObserver( function () {
                syncScrollAfterResize();
            } );
            ro.observe( viewport );
        } else {
            window.addEventListener( 'resize', syncScrollAfterResize );
        }

        requestAnimationFrame( function () {
            viewport.scrollLeft = slideScrollLeft( n );
            activeLogical = 0;
            updateDots( 0 );
            startTimer();
        } );
    }

    document.querySelectorAll( '[data-testimonial-carousel]' ).forEach( initCarousel );
} )();
