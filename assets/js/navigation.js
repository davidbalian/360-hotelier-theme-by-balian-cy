/**
 * Mobile navigation toggle.
 *
 * Full-screen overlay triggered by .mobile-nav-toggle.
 * Adds .is-open to #mobile-nav and .is-active to the toggle button.
 */
( function () {
    'use strict';

    var toggle  = document.querySelector( '.mobile-nav-toggle' );
    var mobileNav = document.getElementById( 'mobile-nav' );

    if ( toggle && mobileNav ) {
        var isToggling = false;

        function openMobileNav() {
            mobileNav.classList.add( 'is-open' );
            mobileNav.setAttribute( 'aria-hidden', 'false' );
            toggle.classList.add( 'is-active' );
            toggle.setAttribute( 'aria-expanded', 'true' );
            toggle.setAttribute( 'aria-label', 'Close menu' );
            document.body.style.overflow = 'hidden';
        }

        function closeMobileNav() {
            mobileNav.classList.remove( 'is-open' );
            mobileNav.setAttribute( 'aria-hidden', 'true' );
            toggle.classList.remove( 'is-active' );
            toggle.setAttribute( 'aria-expanded', 'false' );
            toggle.setAttribute( 'aria-label', 'Open menu' );
            document.body.style.overflow = '';
        }

        toggle.addEventListener( 'click', function () {
            if ( isToggling ) return;
            isToggling = true;

            if ( mobileNav.classList.contains( 'is-open' ) ) {
                closeMobileNav();
            } else {
                openMobileNav();
            }

            setTimeout( function () {
                isToggling = false;
            }, 280 );
        } );

        document.addEventListener( 'keydown', function ( e ) {
            if ( e.key === 'Escape' && mobileNav.classList.contains( 'is-open' ) ) {
                closeMobileNav();
            }
        } );
    }

    // Handle scroll for logo shrink and header state
    var header = document.querySelector( '.site-header' );
    var scrollThreshold = 10;

    function handleScroll() {
        if ( window.scrollY > scrollThreshold ) {
            header.classList.add( 'is-scrolled' );
        } else {
            header.classList.remove( 'is-scrolled' );
        }
    }

    window.addEventListener( 'scroll', handleScroll );
    handleScroll();

    // Scroll-triggered fade-in animations
    var fadeEls = document.querySelectorAll( '.fade-in' );
    if ( fadeEls.length ) {
        var observer = new IntersectionObserver( function ( entries ) {
            entries.forEach( function ( entry ) {
                if ( entry.isIntersecting ) {
                    var el = entry.target;
                    el.classList.add( 'visible' );
                    el.addEventListener( 'transitionend', function clearDelay() {
                        el.style.transitionDelay = '0s';
                        el.removeEventListener( 'transitionend', clearDelay );
                    } );
                    observer.unobserve( el );
                }
            } );
        }, { root: null, rootMargin: '0px', threshold: 0.25 } );

        fadeEls.forEach( function ( el ) {
            observer.observe( el );
        } );
    }

} )();
