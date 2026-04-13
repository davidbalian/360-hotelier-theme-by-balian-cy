/**
 * Tree-shaken Lucide icons for the theme (built to lucide-icons.bundle.js).
 */
import { createIcons } from 'lucide';
import {
	Briefcase,
	Check,
	ChevronDown,
	ChevronLeft,
	ChevronRight,
	Clock,
	Euro,
	Facebook,
	Globe,
	Instagram,
	Linkedin,
	Mail,
	MapPin,
	Monitor,
	Phone,
	Quote,
	Users,
} from 'lucide';

const HOTELIER_LUCIDE_OPTIONS = {
	icons: {
		Briefcase,
		Check,
		ChevronDown,
		ChevronLeft,
		ChevronRight,
		Clock,
		Euro,
		Facebook,
		Globe,
		Instagram,
		Linkedin,
		Mail,
		MapPin,
		Monitor,
		Phone,
		Quote,
		Users,
	},
	attrs: {
		'stroke-width': '1.75',
		'stroke-linecap': 'round',
		'stroke-linejoin': 'round',
	},
};

function initLucideIcons() {
	createIcons( HOTELIER_LUCIDE_OPTIONS );
}

/**
 * Replace [data-lucide] under a subtree (e.g. after cloning carousel slides).
 *
 * @param {ParentNode} root
 */
function hotelierLucideHydrate( root ) {
	createIcons( {
		...HOTELIER_LUCIDE_OPTIONS,
		root: root || document,
	} );
}

window.hotelierLucideHydrate = hotelierLucideHydrate;

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initLucideIcons );
} else {
	initLucideIcons();
}
