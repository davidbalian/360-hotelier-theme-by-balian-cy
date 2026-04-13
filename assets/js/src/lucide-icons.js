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

function initLucideIcons() {
	createIcons( {
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
	} );
}

if ( document.readyState === 'loading' ) {
	document.addEventListener( 'DOMContentLoaded', initLucideIcons );
} else {
	initLucideIcons();
}
