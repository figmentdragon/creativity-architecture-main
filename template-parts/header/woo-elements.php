<?php
/**
 * Add WooCommerce Elements in header
 *
 * @package TheCreativityArchitect
 */

if ( ! class_exists( 'WooCommerce' ) ) {
    // Bail if WooCommerce is not installed
    return;
}

if ( get_theme_mod( 'TheCreativityArchitect_header_cart_enable', 0 ) && function_exists( 'TheCreativityArchitect_header_cart' ) ) {
	TheCreativityArchitect_header_cart();
}
