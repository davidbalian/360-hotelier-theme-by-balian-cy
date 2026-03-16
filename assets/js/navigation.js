/**
 * Mobile navigation toggle.
 *
 * Toggles the .is-open class on the primary nav menu
 * and updates aria-expanded on the toggle button.
 */
( function () {
    'use strict';

    var toggle = document.querySelector( '.menu-toggle' );
    var menu   = document.querySelector( '#primary-menu' );

    if ( ! toggle || ! menu ) {
        return;
    }

    toggle.addEventListener( 'click', function () {
        var isExpanded = this.getAttribute( 'aria-expanded' ) === 'true';

        this.setAttribute( 'aria-expanded', String( ! isExpanded ) );
        menu.classList.toggle( 'is-open' );
    } );

    // Handle scroll for logo shrink
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
    handleScroll(); // Initial check

    // Close menu when clicking outside of it
    document.addEventListener( 'click', function ( event ) {
        if ( ! event.target.closest( '#primary-navigation' ) ) {
            toggle.setAttribute( 'aria-expanded', 'false' );
            menu.classList.remove( 'is-open' );
        }
    } );
} )();
