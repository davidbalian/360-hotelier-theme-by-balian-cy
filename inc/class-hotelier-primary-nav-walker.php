<?php
/**
 * Primary nav walker: appends “All Services” to the Services submenu.
 *
 * @package 360-hotelier
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Walker for the header primary menu.
 */
class Hotelier_Primary_Nav_Walker extends Walker_Nav_Menu {

    /**
     * True after the Services parent <li> starts; cleared when its sub-menu closes.
     *
     * @var bool
     */
    private $services_submenu_pending = false;

    /**
     * @param stdClass $item Menu item.
     * @return bool
     */
    private function item_is_services_hub( $item ) {
        if ( isset( $item->object ) && 'page' === $item->object && ! empty( $item->object_id ) ) {
            return 'services' === get_post_field( 'post_name', (int) $item->object_id );
        }

        if ( isset( $item->object ) && 'custom' === $item->object && ! empty( $item->url ) ) {
            $path = wp_parse_url( $item->url, PHP_URL_PATH );
            if ( is_string( $path ) ) {
                $tail = basename( untrailingslashit( $path ) );
                return 'services' === $tail;
            }
        }

        return false;
    }

    /**
     * @param string   $output Output.
     * @param WP_Post  $item   Menu item.
     * @param int      $depth  Depth.
     * @param stdClass $args   Args.
     * @param int      $id     ID.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        if ( 0 === (int) $depth && in_array( 'menu-item-has-children', (array) $item->classes, true ) && $this->item_is_services_hub( $item ) ) {
            $this->services_submenu_pending = true;
        }
        parent::start_el( $output, $item, $depth, $args, $id );
    }

    /**
     * @param string   $output Output.
     * @param int      $depth  Depth.
     * @param stdClass $args   Args.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        if ( 0 === (int) $depth && $this->services_submenu_pending ) {
            $t = ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) ? '' : "\t";
            $n = ( isset( $args->item_spacing ) && 'discard' === $args->item_spacing ) ? '' : "\n";
            $indent = str_repeat( $t, (int) $depth + 2 );
            $url      = hotelier_get_page_url_by_slug( 'services' );
            $label    = esc_html__( 'All Services', '360-hotelier' );
            $output  .= $indent . '<li class="menu-item menu-item-all-services"><a href="' . esc_url( $url ) . '">' . $label . '</a></li>' . $n;
            $this->services_submenu_pending = false;
        }
        parent::end_lvl( $output, $depth, $args );
    }
}
