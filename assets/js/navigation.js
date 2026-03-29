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
    var topBar = document.querySelector( '.top-bar' );
    var scrollThreshold = 10;

    function handleScroll() {
        if ( window.scrollY > scrollThreshold ) {
            header.classList.add( 'is-scrolled' );
            if ( topBar ) { topBar.classList.add( 'is-scrolled' ); }
        } else {
            header.classList.remove( 'is-scrolled' );
            if ( topBar ) { topBar.classList.remove( 'is-scrolled' ); }
        }
    }

    window.addEventListener( 'scroll', handleScroll );
    handleScroll();

    /**
     * Desktop primary nav: aria-expanded on parent items with submenus.
     */
    var PrimarySubmenuAria = {
        mq: window.matchMedia( '(min-width: 769px)' ),

        isDesktop: function () {
            return this.mq.matches;
        },

        resetAllExpanded: function ( nav ) {
            var triggers = nav.querySelectorAll( '.nav-menu > .menu-item-has-children > a' );
            triggers.forEach( function ( t ) {
                t.setAttribute( 'aria-expanded', 'false' );
            } );
        },

        bindItem: function ( li ) {
            var trigger = li.querySelector( ':scope > a' );
            if ( !trigger ) {
                return;
            }
            trigger.setAttribute( 'aria-haspopup', 'true' );
            trigger.setAttribute( 'aria-expanded', 'false' );

            var self = this;
            function setExpanded( open ) {
                if ( !self.isDesktop() ) {
                    trigger.setAttribute( 'aria-expanded', 'false' );
                    return;
                }
                trigger.setAttribute( 'aria-expanded', open ? 'true' : 'false' );
            }

            li.addEventListener( 'mouseenter', function () {
                setExpanded( true );
            } );
            li.addEventListener( 'mouseleave', function () {
                setExpanded( false );
            } );
            li.addEventListener( 'focusin', function () {
                setExpanded( true );
            } );
            li.addEventListener( 'focusout', function ( e ) {
                if ( !li.contains( e.relatedTarget ) ) {
                    setExpanded( false );
                }
            } );
        },

        init: function () {
            var nav = document.querySelector( '.primary-navigation' );
            if ( !nav ) {
                return;
            }
            var parents = nav.querySelectorAll( '.nav-menu > .menu-item-has-children' );
            var self = this;
            parents.forEach( function ( li ) {
                self.bindItem( li );
            } );
            function onMqChange() {
                if ( !self.isDesktop() ) {
                    self.resetAllExpanded( nav );
                }
            }
            if ( this.mq.addEventListener ) {
                this.mq.addEventListener( 'change', onMqChange );
            } else if ( this.mq.addListener ) {
                this.mq.addListener( onMqChange );
            }
        }
    };
    PrimarySubmenuAria.init();

    // Scroll-triggered fade-in animations
    var fadeEls = document.querySelectorAll( '.fade-in' );
    if ( fadeEls.length ) {
        var observer = new IntersectionObserver( function ( entries ) {
            entries.forEach( function ( entry ) {
                if ( entry.isIntersecting ) {
                    var el = entry.target;
                    el.classList.add( 'visible' );
                    el.addEventListener( 'animationend', function onDone( e ) {
                        if ( e.target !== el ) { return; }
                        el.classList.remove( 'visible', 'fade-in' );
                        for ( var i = 0; i <= 10; i++ ) {
                            el.classList.remove( 'fade-in-delay-' + i );
                        }
                        el.removeEventListener( 'animationend', onDone );
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
