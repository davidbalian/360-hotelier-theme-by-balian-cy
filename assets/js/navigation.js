/**
 * Mobile navigation toggle.
 *
 * Full-screen overlay triggered by .mobile-nav-toggle.
 * Adds .is-open to #mobile-nav and .is-active to the toggle button.
 */
( function () {
    'use strict';

    var toggle    = document.querySelector( '.mobile-nav-toggle' );
    var mobileNav = document.getElementById( 'mobile-nav' );

    /**
     * Mobile overlay: accordion submenus (e.g. Services), collapsed by default.
     */
    var MobileNavSubmenuToggle = {
        mq: window.matchMedia( '(max-width: 768px)' ),

        isMobileLayout: function () {
            return this.mq.matches;
        },

        closeAll: function () {
            if ( !mobileNav ) {
                return;
            }
            mobileNav.querySelectorAll( '.mobile-nav__links > .menu-item-has-children.is-submenu-open' ).forEach( function ( li ) {
                li.classList.remove( 'is-submenu-open' );
                var t = li.querySelector( ':scope > a' );
                if ( t ) {
                    t.setAttribute( 'aria-expanded', 'false' );
                }
            } );
        },

        init: function () {
            if ( !mobileNav ) {
                return;
            }
            var self = this;
            mobileNav.querySelectorAll( '.mobile-nav__links > .menu-item-has-children' ).forEach( function ( li ) {
                var trigger = li.querySelector( ':scope > a' );
                if ( !trigger ) {
                    return;
                }
                trigger.setAttribute( 'aria-haspopup', 'true' );
                trigger.setAttribute( 'aria-expanded', 'false' );

                trigger.addEventListener( 'click', function ( e ) {
                    if ( !self.isMobileLayout() ) {
                        return;
                    }
                    e.preventDefault();
                    e.stopPropagation();
                    var wasOpen = li.classList.contains( 'is-submenu-open' );
                    self.closeAll();
                    if ( !wasOpen ) {
                        li.classList.add( 'is-submenu-open' );
                        trigger.setAttribute( 'aria-expanded', 'true' );
                    }
                } );

                trigger.addEventListener( 'keydown', function ( e ) {
                    if ( !self.isMobileLayout() ) {
                        return;
                    }
                    if ( e.key === 'Enter' || e.key === ' ' ) {
                        e.preventDefault();
                        trigger.click();
                    }
                } );
            } );

            function onMqChange() {
                if ( !self.isMobileLayout() ) {
                    self.closeAll();
                }
            }
            if ( this.mq.addEventListener ) {
                this.mq.addEventListener( 'change', onMqChange );
            } else if ( this.mq.addListener ) {
                this.mq.addListener( onMqChange );
            }
        }
    };
    MobileNavSubmenuToggle.init();

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
            MobileNavSubmenuToggle.closeAll();
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
     * Desktop primary nav: click parent link to toggle submenu (Services).
     */
    var PrimarySubmenuToggle = {
        mq: window.matchMedia( '(min-width: 769px)' ),
        nav: null,

        isDesktop: function () {
            return this.mq.matches;
        },

        closeAllSubmenus: function () {
            if ( !this.nav ) {
                return;
            }
            this.nav.querySelectorAll( '.nav-menu > .menu-item-has-children.is-submenu-open' ).forEach( function ( li ) {
                li.classList.remove( 'is-submenu-open' );
                var t = li.querySelector( ':scope > a' );
                if ( t ) {
                    t.setAttribute( 'aria-expanded', 'false' );
                }
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

            trigger.addEventListener( 'click', function ( e ) {
                if ( !self.isDesktop() ) {
                    return;
                }
                e.preventDefault();
                e.stopPropagation();
                var wasOpen = li.classList.contains( 'is-submenu-open' );
                self.closeAllSubmenus();
                if ( !wasOpen ) {
                    li.classList.add( 'is-submenu-open' );
                    trigger.setAttribute( 'aria-expanded', 'true' );
                }
            } );

            trigger.addEventListener( 'keydown', function ( e ) {
                if ( !self.isDesktop() ) {
                    return;
                }
                if ( e.key === 'Enter' || e.key === ' ' ) {
                    e.preventDefault();
                    trigger.click();
                }
            } );

            li.addEventListener( 'focusout', function ( e ) {
                if ( !self.isDesktop() ) {
                    return;
                }
                if ( li.contains( e.relatedTarget ) ) {
                    return;
                }
                li.classList.remove( 'is-submenu-open' );
                trigger.setAttribute( 'aria-expanded', 'false' );
            } );
        },

        init: function () {
            this.nav = document.querySelector( '.primary-navigation' );
            if ( !this.nav ) {
                return;
            }
            var self = this;
            this.nav.querySelectorAll( '.nav-menu > .menu-item-has-children' ).forEach( function ( li ) {
                self.bindItem( li );
            } );

            document.addEventListener( 'click', function ( e ) {
                if ( !self.isDesktop() ) {
                    return;
                }
                var openLi = self.nav.querySelector( '.nav-menu > .menu-item-has-children.is-submenu-open' );
                if ( !openLi || openLi.contains( e.target ) ) {
                    return;
                }
                self.closeAllSubmenus();
            } );

            document.addEventListener( 'keydown', function ( e ) {
                if ( e.key !== 'Escape' ) {
                    return;
                }
                if ( !self.isDesktop() ) {
                    return;
                }
                self.closeAllSubmenus();
            } );

            function onMqChange() {
                if ( !self.isDesktop() ) {
                    self.closeAllSubmenus();
                }
            }
            if ( this.mq.addEventListener ) {
                this.mq.addEventListener( 'change', onMqChange );
            } else if ( this.mq.addListener ) {
                this.mq.addListener( onMqChange );
            }
        }
    };
    PrimarySubmenuToggle.init();

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
