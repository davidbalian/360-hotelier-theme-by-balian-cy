/**
 * Portfolio testimonials: horizontal snap carousel with auto-advance.
 */
( function () {
    'use strict';

    var INTERVAL_MS = 5500;

    function initCarousel( root ) {
        var viewport = root.querySelector( '[data-testimonial-viewport]' );
        var track = root.querySelector( '[data-testimonial-track]' );
        var slides = track ? track.querySelectorAll( '[data-testimonial-slide]' ) : [];
        var dots = root.querySelectorAll( '[data-testimonial-dot]' );
        var btnPrev = root.querySelector( '[data-testimonial-prev]' );
        var btnNext = root.querySelector( '[data-testimonial-next]' );

        if ( !viewport || !track || slides.length === 0 ) {
            return;
        }

        var reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
        var paused = false;
        var timer = null;
        var scrollSyncScheduled = false;

        function slideWidth() {
            return viewport.clientWidth || 0;
        }

        function nearestIndex() {
            var w = slideWidth();
            if ( !w ) {
                return 0;
            }
            return Math.round( viewport.scrollLeft / w );
        }

        function updateDots( activeIndex ) {
            dots.forEach( function ( dot, i ) {
                var on = i === activeIndex;
                dot.setAttribute( 'aria-selected', on ? 'true' : 'false' );
            } );
        }

        function goTo( index, smooth ) {
            var n = slides.length;
            if ( n === 0 ) {
                return;
            }
            var idx = ( ( index % n ) + n ) % n;
            var w = slideWidth();
            if ( !w ) {
                return;
            }
            var behavior = reducedMotion || !smooth ? 'auto' : 'smooth';
            viewport.scrollTo( { left: idx * w, behavior: behavior } );
            updateDots( idx );
        }

        function advance() {
            var i = nearestIndex();
            if ( i >= slides.length - 1 ) {
                viewport.scrollTo( { left: 0, behavior: 'auto' } );
                updateDots( 0 );
            } else {
                goTo( i + 1, true );
            }
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
                updateDots( nearestIndex() );
            } );
        }

        if ( btnPrev ) {
            btnPrev.addEventListener( 'click', function () {
                goTo( nearestIndex() - 1, true );
            } );
        }
        if ( btnNext ) {
            btnNext.addEventListener( 'click', function () {
                goTo( nearestIndex() + 1, true );
            } );
        }

        dots.forEach( function ( dot ) {
            dot.addEventListener( 'click', function () {
                var raw = dot.getAttribute( 'data-testimonial-dot' );
                var idx = raw ? parseInt( raw, 10 ) : 0;
                goTo( idx, true );
            } );
        } );

        viewport.addEventListener( 'scroll', onScroll, { passive: true } );

        viewport.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'ArrowLeft' ) {
                e.preventDefault();
                goTo( nearestIndex() - 1, true );
            } else if ( e.key === 'ArrowRight' ) {
                e.preventDefault();
                goTo( nearestIndex() + 1, true );
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

        if ( typeof ResizeObserver !== 'undefined' ) {
            var ro = new ResizeObserver( function () {
                goTo( nearestIndex(), false );
            } );
            ro.observe( viewport );
        } else {
            window.addEventListener( 'resize', function () {
                goTo( nearestIndex(), false );
            } );
        }

        updateDots( 0 );
        startTimer();
    }

    document.querySelectorAll( '[data-testimonial-carousel]' ).forEach( initCarousel );
} )();
