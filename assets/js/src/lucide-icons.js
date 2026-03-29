/**
 * Tree-shaken Lucide icons for the theme (built to lucide-icons.bundle.js).
 */
import { createIcons } from 'lucide';
import {
	Briefcase,
	Check,
	CircleDollarSign,
	Clock,
	Globe,
	Mail,
	MapPin,
	Monitor,
	Phone,
	TrendingUp,
	Users,
} from 'lucide';

function initLucideIcons() {
	createIcons( {
		icons: {
			Briefcase,
			Check,
			CircleDollarSign,
			Clock,
			Globe,
			Mail,
			MapPin,
			Monitor,
			Phone,
			TrendingUp,
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
