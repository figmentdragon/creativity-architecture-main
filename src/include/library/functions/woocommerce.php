<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package THEMENAE
 */


/**
 * Adds custom overlay for Promotion Headline Background Image
 */
function promo_head_bg_image_overlay_css() {
	$overlay = get_theme_mod( 'promo_head_background_image_opacity', '0' );
	$css = '';
	$overlay_bg = $overlay / 100;
	if ( $overlay ) {
		$css = '.promotion-section .post-thumbnail-background:before {
					background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
			    } '; // Dividing by 100 as the option is shown as % for user
	}
	wp_add_inline_style( 'style', $css );
}
add_action( 'wp_enqueue_scripts', 'promo_head_bg_image_overlay_css', 11 );


function header_media_image_overlay_css() {
	$overlay = get_theme_mod( 'header_media_image_opacity' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
	$css = '.custom-header-overlay {
		background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
    } '; // Dividing by 100 as the option is shown as % for user
}
	wp_add_inline_style( 'style', $css );
}
add_action( 'wp_enqueue_scripts', 'header_media_image_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

	}
}
add_action( 'pre_get_posts', 'alter_home' );

function sections( $selector = 'header' ) {
	get_template_part( 'template-parts/header/header-media' );
	get_template_part( 'template-parts/display/display-slider' );
	get_template_part( 'template-parts/display/display-portfolio' );
	get_template_part( 'template-parts/content/content-hero' );
	get_template_part( 'template-parts/display/display-testimonial' );
	get_template_part( 'template-parts/display/display-services' );
	get_template_part( 'template-parts/display/display-featured' );
}




if (( ! function_exists ( 'woo_dequeue_styles' )) && class_exists( 'WooCommerce' ) ) {
	// Remove each woocomerce style one by one
	add_filter( 'woocommerce_enqueue_styles', 'woo_dequeue_styles' );
	function woo_dequeue_styles( $enqueue_styles ) {
		unset( $enqueue_styles['woocommerce-general'] );	// Remove the gloss
		//unset( $enqueue_styles['woocommerce-layout'] );		// Remove the layout
		//unset( $enqueue_styles['woocommerce-smallscreen'] );	// Remove the smallscreen optimisation
		return $enqueue_styles;
	}
}
?>
