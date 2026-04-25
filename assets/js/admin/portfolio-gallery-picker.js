/**
 * Portfolio gallery admin picker.
 *
 * Wraps wp.media for multi-image selection, renders thumbnails with
 * HTML5 drag-to-reorder + per-thumb remove, and keeps a hidden CSV input
 * (of attachment IDs) in sync for postmeta save.
 *
 * No external libraries.
 */
( function ( $ ) {
    'use strict';

    var L10n = window.hotelierPortfolioGalleryL10n || {};

    function formatCount( n ) {
        var template = n === 1
            ? ( L10n.countSingle || '%d image selected' )
            : ( L10n.countPlural || '%d images selected' );
        return template.replace( '%d', String( n ) );
    }

    function PortfolioGalleryPicker( root ) {
        this.root = root;
        this.input = root.querySelector( '[data-hotelier-pg-input]' );
        this.grid = root.querySelector( '[data-hotelier-pg-grid]' );
        this.openBtn = root.querySelector( '[data-hotelier-pg-open]' );
        this.clearBtn = root.querySelector( '[data-hotelier-pg-clear]' );
        this.countEl = root.querySelector( '[data-hotelier-pg-count]' );
        this.frame = null;
        this.dragSourceId = null;
    }

    PortfolioGalleryPicker.prototype.init = function () {
        if ( !this.input || !this.grid || !this.openBtn ) {
            return;
        }
        this.bindOpen();
        this.bindClear();
        this.bindGridDelegation();
        this.bindDragOnExisting();
        this.refreshCount();
    };

    PortfolioGalleryPicker.prototype.getIds = function () {
        var raw = ( this.input.value || '' ).trim();
        if ( raw === '' ) {
            return [];
        }
        return raw.split( ',' )
            .map( function ( s ) { return s.trim(); } )
            .filter( function ( s ) { return /^\d+$/.test( s ); } )
            .map( function ( s ) { return parseInt( s, 10 ); } );
    };

    PortfolioGalleryPicker.prototype.setIds = function ( ids ) {
        var seen = {};
        var clean = [];
        ids.forEach( function ( id ) {
            var n = parseInt( id, 10 );
            if ( !n || n <= 0 || seen[ n ] ) {
                return;
            }
            seen[ n ] = true;
            clean.push( n );
        } );
        this.input.value = clean.join( ',' );
        this.refreshCount();
        this.toggleClearVisibility();
    };

    PortfolioGalleryPicker.prototype.refreshCount = function () {
        if ( !this.countEl ) {
            return;
        }
        this.countEl.textContent = formatCount( this.getIds().length );
    };

    PortfolioGalleryPicker.prototype.toggleClearVisibility = function () {
        if ( !this.clearBtn ) {
            return;
        }
        if ( this.getIds().length === 0 ) {
            this.clearBtn.setAttribute( 'hidden', '' );
        } else {
            this.clearBtn.removeAttribute( 'hidden' );
        }
    };

    PortfolioGalleryPicker.prototype.bindOpen = function () {
        var self = this;
        this.openBtn.addEventListener( 'click', function ( e ) {
            e.preventDefault();
            self.openFrame();
        } );
    };

    PortfolioGalleryPicker.prototype.bindClear = function () {
        if ( !this.clearBtn ) {
            return;
        }
        var self = this;
        this.clearBtn.addEventListener( 'click', function ( e ) {
            e.preventDefault();
            var msg = L10n.confirmClear || 'Remove all selected images?';
            if ( !window.confirm( msg ) ) {
                return;
            }
            self.setIds( [] );
            self.grid.innerHTML = '';
        } );
    };

    PortfolioGalleryPicker.prototype.openFrame = function () {
        var self = this;
        if ( this.frame ) {
            this.preselectInFrame();
            this.frame.open();
            return;
        }

        this.frame = window.wp.media( {
            title: L10n.frameTitle || 'Select portfolio gallery images',
            button: { text: L10n.frameButton || 'Use these images' },
            library: { type: 'image' },
            multiple: 'add'
        } );

        this.frame.on( 'open', function () {
            self.preselectInFrame();
        } );

        this.frame.on( 'select', function () {
            var selection = self.frame.state().get( 'selection' );
            var picked = [];
            selection.each( function ( attachment ) {
                picked.push( attachment.toJSON() );
            } );
            self.mergeSelection( picked );
        } );
    };

    PortfolioGalleryPicker.prototype.preselectInFrame = function () {
        if ( !this.frame ) {
            return;
        }
        var selection = this.frame.state().get( 'selection' );
        selection.reset( [] );
        var ids = this.getIds();
        ids.forEach( function ( id ) {
            var attachment = window.wp.media.attachment( id );
            attachment.fetch();
            selection.add( attachment );
        } );
    };

    PortfolioGalleryPicker.prototype.mergeSelection = function ( attachments ) {
        var self = this;
        var existingIds = this.getIds();
        var existingSet = {};
        existingIds.forEach( function ( id ) { existingSet[ id ] = true; } );

        var nextIds = existingIds.slice();

        attachments.forEach( function ( att ) {
            if ( !att || !att.id ) {
                return;
            }
            if ( existingSet[ att.id ] ) {
                return;
            }
            existingSet[ att.id ] = true;
            nextIds.push( att.id );
            self.appendThumb( att );
        } );

        this.setIds( nextIds );
        this.syncOrderFromDom();
    };

    PortfolioGalleryPicker.prototype.appendThumb = function ( att ) {
        var url = '';
        if ( att.sizes && att.sizes.thumbnail && att.sizes.thumbnail.url ) {
            url = att.sizes.thumbnail.url;
        } else if ( att.sizes && att.sizes.medium && att.sizes.medium.url ) {
            url = att.sizes.medium.url;
        } else if ( att.url ) {
            url = att.url;
        }
        if ( !url ) {
            return;
        }

        var alt = att.alt || att.title || '';
        var li = document.createElement( 'li' );
        li.className = 'hotelier-pg-picker__thumb';
        li.setAttribute( 'data-hotelier-pg-thumb', '' );
        li.setAttribute( 'data-id', String( att.id ) );
        li.setAttribute( 'draggable', 'true' );

        var img = document.createElement( 'img' );
        img.src = url;
        img.alt = alt;

        var btn = document.createElement( 'button' );
        btn.type = 'button';
        btn.className = 'hotelier-pg-picker__remove';
        btn.setAttribute( 'data-hotelier-pg-remove', '' );
        btn.setAttribute( 'aria-label', L10n.removeLabel || 'Remove image' );
        btn.innerHTML = '&times;';

        li.appendChild( img );
        li.appendChild( btn );
        this.grid.appendChild( li );
        this.attachDragHandlers( li );
    };

    PortfolioGalleryPicker.prototype.bindGridDelegation = function () {
        var self = this;
        this.grid.addEventListener( 'click', function ( e ) {
            var btn = e.target.closest( '[data-hotelier-pg-remove]' );
            if ( !btn ) {
                return;
            }
            var li = btn.closest( '[data-hotelier-pg-thumb]' );
            if ( !li ) {
                return;
            }
            li.parentNode.removeChild( li );
            self.syncOrderFromDom();
        } );
    };

    PortfolioGalleryPicker.prototype.bindDragOnExisting = function () {
        var thumbs = this.grid.querySelectorAll( '[data-hotelier-pg-thumb]' );
        var self = this;
        thumbs.forEach( function ( li ) {
            self.attachDragHandlers( li );
        } );
    };

    PortfolioGalleryPicker.prototype.attachDragHandlers = function ( li ) {
        var self = this;

        li.addEventListener( 'dragstart', function ( e ) {
            self.dragSourceId = li.getAttribute( 'data-id' );
            li.classList.add( 'is-dragging' );
            if ( e.dataTransfer ) {
                e.dataTransfer.effectAllowed = 'move';
                try {
                    e.dataTransfer.setData( 'text/plain', self.dragSourceId );
                } catch ( err ) {
                    /* IE swallow */
                }
            }
        } );

        li.addEventListener( 'dragend', function () {
            li.classList.remove( 'is-dragging' );
            self.clearDropTargets();
            self.dragSourceId = null;
        } );

        li.addEventListener( 'dragover', function ( e ) {
            e.preventDefault();
            if ( e.dataTransfer ) {
                e.dataTransfer.dropEffect = 'move';
            }
            self.markDropTarget( li, e );
        } );

        li.addEventListener( 'dragleave', function () {
            li.classList.remove( 'is-drop-before', 'is-drop-after' );
        } );

        li.addEventListener( 'drop', function ( e ) {
            e.preventDefault();
            self.handleDrop( li );
        } );
    };

    PortfolioGalleryPicker.prototype.markDropTarget = function ( li, e ) {
        this.clearDropTargets();
        var rect = li.getBoundingClientRect();
        var beforeHalf = ( e.clientX - rect.left ) < ( rect.width / 2 );
        li.classList.add( beforeHalf ? 'is-drop-before' : 'is-drop-after' );
    };

    PortfolioGalleryPicker.prototype.clearDropTargets = function () {
        var els = this.grid.querySelectorAll( '.is-drop-before, .is-drop-after' );
        els.forEach( function ( el ) {
            el.classList.remove( 'is-drop-before', 'is-drop-after' );
        } );
    };

    PortfolioGalleryPicker.prototype.handleDrop = function ( target ) {
        var sourceId = this.dragSourceId;
        if ( !sourceId ) {
            return;
        }
        var source = this.grid.querySelector( '[data-hotelier-pg-thumb][data-id="' + sourceId + '"]' );
        if ( !source || source === target ) {
            this.clearDropTargets();
            return;
        }
        var insertBefore = target.classList.contains( 'is-drop-before' );
        this.clearDropTargets();
        if ( insertBefore ) {
            target.parentNode.insertBefore( source, target );
        } else if ( target.nextSibling ) {
            target.parentNode.insertBefore( source, target.nextSibling );
        } else {
            target.parentNode.appendChild( source );
        }
        this.syncOrderFromDom();
    };

    PortfolioGalleryPicker.prototype.syncOrderFromDom = function () {
        var thumbs = this.grid.querySelectorAll( '[data-hotelier-pg-thumb]' );
        var ids = [];
        thumbs.forEach( function ( el ) {
            var id = el.getAttribute( 'data-id' );
            if ( id ) {
                ids.push( id );
            }
        } );
        this.setIds( ids );
    };

    function init() {
        var roots = document.querySelectorAll( '[data-hotelier-portfolio-gallery]' );
        roots.forEach( function ( root ) {
            var picker = new PortfolioGalleryPicker( root );
            picker.init();
        } );
    }

    if ( document.readyState === 'loading' ) {
        document.addEventListener( 'DOMContentLoaded', init );
    } else {
        init();
    }
}( window.jQuery ) );
