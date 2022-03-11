<?php
/**
 * THEMENAE back compat functionality
 *
 * Prevents THEMENAE from running on WordPress versions prior to 5,
 * since this theme is not meant to be backward compatible beyond that and
 * relies on many newer functions and markup changes introduced in 5.
 *
 * @package THEMENAE
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Add message for unsuccessful theme switch.
 * Prints an update nag after an unsuccessful attempt to switch to THEMENAE on WordPress versions prior to 5.
 */
function upgrade_notice() {
	/* translators: %s: version number */
	$message = sprintf( esc_html__( 'THEMENAE requires at least WordPress version 5. You are running version %s. Please upgrade and try again.', 'TheCreativityArchitect' ), esc_attr($GLOBALS['wp_version'] ) );
	printf( '<div class="error"><p>%s</p></div>', esc_html($message ));
}

/**
 * Prevent the Customizer from being loaded on WordPress versions prior to 5.
 */
function customize() {
	wp_die(
	/* translators: %s: version number */
		sprintf( esc_html__( 'THEMENAE requires at least WordPress version 5. You are running version %s. Please upgrade and try again.', 'TheCreativityArchitect' ), esc_attr($GLOBALS['wp_version'] )), '', array(
			'back_link' => true,
		)
	);
}
add_action( 'load-customize.php', 'customize' );

/**
 * Prevent the Theme Preview from being loaded on WordPress versions prior to 5.
 */
function preview() {
	if ( isset( $_GET['preview'] ) ) {
		/* translators: %s: version number */
		wp_die( sprintf( esc_html__( 'THEMENAE requires at least WordPress version 5. You are running version %s. Please upgrade and try again.', 'TheCreativityArchitect' ), esc_attr($GLOBALS['wp_version'] ) ) );
	}
}
add_action( 'template_redirect', 'preview' );

$menu_mobile_logo_size = get_theme_mod( 'menu_mobile_logo_size' );

if ( $menu_mobile_logo_size ) {
	remove_theme_mod( 'menu_mobile_logo_size' );
}

$sidebar_widget_padding_top    = get_theme_mod( 'sidebar_widget_padding_top' );
$sidebar_widget_padding_right  = get_theme_mod( 'sidebar_widget_padding_right' );
$sidebar_widget_padding_bottom = get_theme_mod( 'sidebar_widget_padding_bottom' );
$sidebar_widget_padding_left   = get_theme_mod( 'sidebar_widget_padding_left' );

if ( $sidebar_widget_padding_top ) {
	remove_theme_mod( 'sidebar_widget_padding_top' );
}

if ( $sidebar_widget_padding_right ) {
	remove_theme_mod( 'sidebar_widget_padding_right' );
}

if ( $sidebar_widget_padding_bottom ) {
	remove_theme_mod( 'sidebar_widget_padding_bottom' );
}

if ( $sidebar_widget_padding_left ) {
	remove_theme_mod( 'sidebar_widget_padding_left' );
}

$article_meta  = get_theme_mod( 'blog_sortable_meta', array( 'author', 'date' ) );
$blog_author   = get_theme_mod( 'blog_author' );
$single_author = get_theme_mod( 'single_author' );
$blog_comments = get_theme_mod( 'blog_comments' );

if ( 'hide' === $blog_author || 'hide' === $single_author ) {

	$article_meta = array_diff( $article_meta, array( 'author' ) );
	$article_meta = array_values( $article_meta );

	set_theme_mod( 'blog_sortable_meta', $article_meta );
	remove_theme_mod( 'blog_author' );
	remove_theme_mod( 'single_author' );

}

if ( 'show' === $blog_comments ) {

	$article_meta[] = 'comments';

	set_theme_mod( 'blog_sortable_meta', $article_meta );
	remove_theme_mod( 'blog_comments' );

}

/**
 * Convert custom controls.
 *
 * From here downwards we convert previous custom/responsive customizer controls to be saved in a single theme_mod.
 * This and the entire backwards compatibility might be removed after 1 year.
 */

// This theme mod existed a long time ago and is now causing issues with the new JSON below.
// If it exists, we will have to update & convert it first, before checking for the new, responsive settings.
$menu_logo_size = get_theme_mod( 'menu_logo_size' );

if ( is_numeric( $menu_logo_size ) ) {

	$theme_mod_array = array(
		'desktop' => $menu_logo_size,
		'tablet'  => false,
		'mobile'  => false,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'menu_logo_size', $theme_mod_array );

}

// Logo size.
$menu_logo_size_desktop = get_theme_mod( 'menu_logo_size_desktop' );
$menu_logo_size_tablet  = get_theme_mod( 'menu_logo_size_tablet' );
$menu_logo_size_mobile  = get_theme_mod( 'menu_logo_size_mobile' );

if ( $menu_logo_size_desktop || $menu_logo_size_tablet || $menu_logo_size_mobile ) {

	$theme_mod_array = array(
		'desktop' => $menu_logo_size_desktop,
		'tablet'  => $menu_logo_size_tablet,
		'mobile'  => $menu_logo_size_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'menu_logo_size', $theme_mod_array );

	remove_theme_mod( 'menu_logo_size_desktop' );
	remove_theme_mod( 'menu_logo_size_tablet' );
	remove_theme_mod( 'menu_logo_size_mobile' );

}

// Logo font size.
$menu_logo_font_size_desktop = get_theme_mod( 'menu_logo_font_size_desktop' );
$menu_logo_font_size_tablet  = get_theme_mod( 'menu_logo_font_size_tablet' );
$menu_logo_font_size_mobile  = get_theme_mod( 'menu_logo_font_size_mobile' );

if ( $menu_logo_font_size_desktop || $menu_logo_font_size_tablet || $menu_logo_font_size_mobile ) {

	$theme_mod_array = array(
		'desktop' => $menu_logo_font_size_desktop,
		'tablet'  => $menu_logo_font_size_tablet,
		'mobile'  => $menu_logo_font_size_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'menu_logo_font_size', $theme_mod_array );

	remove_theme_mod( 'menu_logo_font_size_desktop' );
	remove_theme_mod( 'menu_logo_font_size_tablet' );
	remove_theme_mod( 'menu_logo_font_size_mobile' );

}

// Tagline font size.
$menu_logo_description_font_size_desktop = get_theme_mod( 'menu_logo_description_font_size_desktop' );
$menu_logo_description_font_size_tablet  = get_theme_mod( 'menu_logo_description_font_size_tablet' );
$menu_logo_description_font_size_mobile  = get_theme_mod( 'menu_logo_description_font_size_mobile' );

if ( $menu_logo_description_font_size_desktop || $menu_logo_description_font_size_tablet || $menu_logo_description_font_size_mobile ) {

	$theme_mod_array = array(
		'desktop' => $menu_logo_description_font_size_desktop,
		'tablet'  => $menu_logo_description_font_size_tablet,
		'mobile'  => $menu_logo_description_font_size_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'menu_logo_description_font_size', $theme_mod_array );

	remove_theme_mod( 'menu_logo_description_font_size_desktop' );
	remove_theme_mod( 'menu_logo_description_font_size_tablet' );
	remove_theme_mod( 'menu_logo_description_font_size_mobile' );

}

// Sub menu padding.
$sub_menu_padding_top    = get_theme_mod( 'sub_menu_padding_top' );
$sub_menu_padding_right  = get_theme_mod( 'sub_menu_padding_right' );
$sub_menu_padding_bottom = get_theme_mod( 'sub_menu_padding_bottom' );
$sub_menu_padding_left   = get_theme_mod( 'sub_menu_padding_left' );

if ( $sub_menu_padding_top || $sub_menu_padding_right || $sub_menu_padding_bottom || $sub_menu_padding_left ) {

	$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
		'top'    => $sub_menu_padding_top,
		'right'  => $sub_menu_padding_right,
		'bottom' => $sub_menu_padding_bottom,
		'left'   => $sub_menu_padding_left,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'sub_menu_padding', $theme_mod_array );

	remove_theme_mod( 'sub_menu_padding_top' );
	remove_theme_mod( 'sub_menu_padding_right' );
	remove_theme_mod( 'sub_menu_padding_bottom' );
	remove_theme_mod( 'sub_menu_padding_left' );

}

// Mobile menu padding.
$mobile_menu_padding_top    = get_theme_mod( 'mobile_menu_padding_top' );
$mobile_menu_padding_right  = get_theme_mod( 'mobile_menu_padding_right' );
$mobile_menu_padding_bottom = get_theme_mod( 'mobile_menu_padding_bottom' );
$mobile_menu_padding_left   = get_theme_mod( 'mobile_menu_padding_left' );

if ( $mobile_menu_padding_top || $mobile_menu_padding_right || $mobile_menu_padding_bottom || $mobile_menu_padding_left ) {

	$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
		'top'    => $mobile_menu_padding_top,
		'right'  => $mobile_menu_padding_right,
		'bottom' => $mobile_menu_padding_bottom,
		'left'   => $mobile_menu_padding_left,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'mobile_menu_padding', $theme_mod_array );

	remove_theme_mod( 'mobile_menu_padding_top' );
	remove_theme_mod( 'mobile_menu_padding_right' );
	remove_theme_mod( 'mobile_menu_padding_bottom' );
	remove_theme_mod( 'mobile_menu_padding_left' );

}

// WooCommerce products per row.
$woocommerce_loop_products_per_row_desktop = get_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
$woocommerce_loop_products_per_row_tablet  = get_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
$woocommerce_loop_products_per_row_mobile  = get_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

if ( $woocommerce_loop_products_per_row_desktop || $woocommerce_loop_products_per_row_tablet || $woocommerce_loop_products_per_row_mobile ) {

	$theme_mod_array = array(
		'desktop' => $woocommerce_loop_products_per_row_desktop ? $woocommerce_loop_products_per_row_desktop : '4',
		'tablet'  => $woocommerce_loop_products_per_row_tablet ? $woocommerce_loop_products_per_row_tablet : '2',
		'mobile'  => $woocommerce_loop_products_per_row_mobile ? $woocommerce_loop_products_per_row_mobile : '1',
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'woocommerce_loop_products_per_row', $theme_mod_array );

	remove_theme_mod( 'woocommerce_loop_products_per_row_desktop' );
	remove_theme_mod( 'woocommerce_loop_products_per_row_tablet' );
	remove_theme_mod( 'woocommerce_loop_products_per_row_mobile' );

}

$archives = apply_filters( 'archives', array( 'archive' ) );

foreach ( $archives as $archive ) {

	// Archive boxed padding.
	$boxed_padding_top_desktop    = get_theme_mod( $archive . '_boxed_padding_top_desktop' );
	$boxed_padding_right_desktop  = get_theme_mod( $archive . '_boxed_padding_right_desktop' );
	$boxed_padding_bottom_desktop = get_theme_mod( $archive . '_boxed_padding_bottom_desktop' );
	$boxed_padding_left_desktop   = get_theme_mod( $archive . '_boxed_padding_left_desktop' );

	$boxed_padding_top_tablet     = get_theme_mod( $archive . '_boxed_padding_top_tablet' );
	$boxed_padding_right_tablet   = get_theme_mod( $archive . '_boxed_padding_right_tablet' );
	$boxed_padding_bottom_tablet  = get_theme_mod( $archive . '_boxed_padding_bottom_tablet' );
	$boxed_padding_left_tablet    = get_theme_mod( $archive . '_boxed_padding_left_tablet' );

	$boxed_padding_top_mobile     = get_theme_mod( $archive . '_boxed_padding_top_mobile' );
	$boxed_padding_right_mobile   = get_theme_mod( $archive . '_boxed_padding_right_mobile' );
	$boxed_padding_bottom_mobile  = get_theme_mod( $archive . '_boxed_padding_bottom_mobile' );
	$boxed_padding_left_mobile    = get_theme_mod( $archive . '_boxed_padding_left_mobile' );

	if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet || $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

		$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
			'desktop_top'    => $boxed_padding_top_desktop,
			'desktop_right'  => $boxed_padding_right_desktop,
			'desktop_bottom' => $boxed_padding_bottom_desktop,
			'desktop_left'   => $boxed_padding_left_desktop,
			'tablet_top'     => $boxed_padding_top_tablet,
			'tablet_right'   => $boxed_padding_right_tablet,
			'tablet_bottom'  => $boxed_padding_bottom_tablet,
			'tablet_left'    => $boxed_padding_left_tablet,
			'mobile_top'     => $boxed_padding_top_mobile,
			'mobile_right'   => $boxed_padding_right_mobile,
			'mobile_bottom'  => $boxed_padding_bottom_mobile,
			'mobile_left'    => $boxed_padding_left_mobile,
		);

		$theme_mod_array = json_encode( $theme_mod_array, true );

		set_theme_mod( $archive . '_boxed_padding', $theme_mod_array );

		remove_theme_mod( $archive . '_boxed_padding_top_desktop' );
		remove_theme_mod( $archive . '_boxed_padding_right_desktop' );
		remove_theme_mod( $archive . '_boxed_padding_bottom_desktop' );
		remove_theme_mod( $archive . '_boxed_padding_left_desktop' );

		remove_theme_mod( $archive . '_boxed_padding_top_tablet' );
		remove_theme_mod( $archive . '_boxed_padding_right_tablet' );
		remove_theme_mod( $archive . '_boxed_padding_bottom_tablet' );
		remove_theme_mod( $archive . '_boxed_padding_left_tablet' );

		remove_theme_mod( $archive . '_boxed_padding_top_mobile' );
		remove_theme_mod( $archive . '_boxed_padding_right_mobile' );
		remove_theme_mod( $archive . '_boxed_padding_bottom_mobile' );
		remove_theme_mod( $archive . '_boxed_padding_left_mobile' );

	}

}

// Single boxed padding.
$boxed_padding_top_desktop    = get_theme_mod( 'single_boxed_padding_top_desktop' );
$boxed_padding_right_desktop  = get_theme_mod( 'single_boxed_padding_right_desktop' );
$boxed_padding_bottom_desktop = get_theme_mod( 'single_boxed_padding_bottom_desktop' );
$boxed_padding_left_desktop   = get_theme_mod( 'single_boxed_padding_left_desktop' );

$boxed_padding_top_tablet     = get_theme_mod( 'single_boxed_padding_top_tablet' );
$boxed_padding_right_tablet   = get_theme_mod( 'single_boxed_padding_right_tablet' );
$boxed_padding_bottom_tablet  = get_theme_mod( 'single_boxed_padding_bottom_tablet' );
$boxed_padding_left_tablet    = get_theme_mod( 'single_boxed_padding_left_tablet' );

$boxed_padding_top_mobile     = get_theme_mod( 'single_boxed_padding_top_mobile' );
$boxed_padding_right_mobile   = get_theme_mod( 'single_boxed_padding_right_mobile' );
$boxed_padding_bottom_mobile  = get_theme_mod( 'single_boxed_padding_bottom_mobile' );
$boxed_padding_left_mobile    = get_theme_mod( 'single_boxed_padding_left_mobile' );

if ( $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_tablet || $boxed_padding_right_tablet || $boxed_padding_bottom_tablet || $boxed_padding_left_tablet || $boxed_padding_top_desktop || $boxed_padding_right_desktop || $boxed_padding_bottom_desktop || $boxed_padding_left_desktop || $boxed_padding_top_mobile || $boxed_padding_right_mobile || $boxed_padding_bottom_mobile || $boxed_padding_left_mobile ) {

	$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
		'desktop_top'    => $boxed_padding_top_desktop,
		'desktop_right'  => $boxed_padding_right_desktop,
		'desktop_bottom' => $boxed_padding_bottom_desktop,
		'desktop_left'   => $boxed_padding_left_desktop,
		'tablet_top'     => $boxed_padding_top_tablet,
		'tablet_right'   => $boxed_padding_right_tablet,
		'tablet_bottom'  => $boxed_padding_bottom_tablet,
		'tablet_left'    => $boxed_padding_left_tablet,
		'mobile_top'     => $boxed_padding_top_mobile,
		'mobile_right'   => $boxed_padding_right_mobile,
		'mobile_bottom'  => $boxed_padding_bottom_mobile,
		'mobile_left'    => $boxed_padding_left_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'single_boxed_padding', $theme_mod_array );

	remove_theme_mod( 'single_boxed_padding_top_desktop' );
	remove_theme_mod( 'single_boxed_padding_right_desktop' );
	remove_theme_mod( 'single_boxed_padding_bottom_desktop' );
	remove_theme_mod( 'single_boxed_padding_left_desktop' );

	remove_theme_mod( 'single_boxed_padding_top_tablet' );
	remove_theme_mod( 'single_boxed_padding_right_tablet' );
	remove_theme_mod( 'single_boxed_padding_bottom_tablet' );
	remove_theme_mod( 'single_boxed_padding_left_tablet' );

	remove_theme_mod( 'single_boxed_padding_top_mobile' );
	remove_theme_mod( 'single_boxed_padding_right_mobile' );
	remove_theme_mod( 'single_boxed_padding_bottom_mobile' );
	remove_theme_mod( 'single_boxed_padding_left_mobile' );

}

// Page padding.
$page_padding_top_desktop    = get_theme_mod( 'page_padding_top_desktop' );
$page_padding_right_desktop  = get_theme_mod( 'page_padding_right_desktop' );
$page_padding_bottom_desktop = get_theme_mod( 'page_padding_bottom_desktop' );
$page_padding_left_desktop   = get_theme_mod( 'page_padding_left_desktop' );

$page_padding_top_tablet     = get_theme_mod( 'page_padding_top_tablet' );
$page_padding_right_tablet   = get_theme_mod( 'page_padding_right_tablet' );
$page_padding_bottom_tablet  = get_theme_mod( 'page_padding_bottom_tablet' );
$page_padding_left_tablet    = get_theme_mod( 'page_padding_left_tablet' );

$page_padding_top_mobile     = get_theme_mod( 'page_padding_top_mobile' );
$page_padding_right_mobile   = get_theme_mod( 'page_padding_right_mobile' );
$page_padding_bottom_mobile  = get_theme_mod( 'page_padding_bottom_mobile' );
$page_padding_left_mobile    = get_theme_mod( 'page_padding_left_mobile' );

if ( $page_padding_top_desktop || $page_padding_right_desktop || $page_padding_bottom_desktop || $page_padding_left_desktop || $page_padding_top_tablet || $page_padding_right_tablet || $page_padding_bottom_tablet || $page_padding_left_tablet || $page_padding_top_desktop || $page_padding_right_desktop || $page_padding_bottom_desktop || $page_padding_left_desktop || $page_padding_top_mobile || $page_padding_right_mobile || $page_padding_bottom_mobile || $page_padding_left_mobile ) {

	$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
		'desktop_top'    => $page_padding_top_desktop,
		'desktop_right'  => $page_padding_right_desktop,
		'desktop_bottom' => $page_padding_bottom_desktop,
		'desktop_left'   => $page_padding_left_desktop,
		'tablet_top'     => $page_padding_top_tablet,
		'tablet_right'   => $page_padding_right_tablet,
		'tablet_bottom'  => $page_padding_bottom_tablet,
		'tablet_left'    => $page_padding_left_tablet,
		'mobile_top'     => $page_padding_top_mobile,
		'mobile_right'   => $page_padding_right_mobile,
		'mobile_bottom'  => $page_padding_bottom_mobile,
		'mobile_left'    => $page_padding_left_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'page_padding', $theme_mod_array );

	remove_theme_mod( 'page_padding_top_desktop' );
	remove_theme_mod( 'page_padding_right_desktop' );
	remove_theme_mod( 'page_padding_bottom_desktop' );
	remove_theme_mod( 'page_padding_left_desktop' );

	remove_theme_mod( 'page_padding_top_tablet' );
	remove_theme_mod( 'page_padding_right_tablet' );
	remove_theme_mod( 'page_padding_bottom_tablet' );
	remove_theme_mod( 'page_padding_left_tablet' );

	remove_theme_mod( 'page_padding_top_mobile' );
	remove_theme_mod( 'page_padding_right_mobile' );
	remove_theme_mod( 'page_padding_bottom_mobile' );
	remove_theme_mod( 'page_padding_left_mobile' );

}

// Sidebar widget padding.
$sidebar_widget_padding_top_desktop    = get_theme_mod( 'sidebar_widget_padding_top_desktop' );
$sidebar_widget_padding_right_desktop  = get_theme_mod( 'sidebar_widget_padding_right_desktop' );
$sidebar_widget_padding_bottom_desktop = get_theme_mod( 'sidebar_widget_padding_bottom_desktop' );
$sidebar_widget_padding_left_desktop   = get_theme_mod( 'sidebar_widget_padding_left_desktop' );

$sidebar_widget_padding_top_tablet     = get_theme_mod( 'sidebar_widget_padding_top_tablet' );
$sidebar_widget_padding_right_tablet   = get_theme_mod( 'sidebar_widget_padding_right_tablet' );
$sidebar_widget_padding_bottom_tablet  = get_theme_mod( 'sidebar_widget_padding_bottom_tablet' );
$sidebar_widget_padding_left_tablet    = get_theme_mod( 'sidebar_widget_padding_left_tablet' );

$sidebar_widget_padding_top_mobile     = get_theme_mod( 'sidebar_widget_padding_top_mobile' );
$sidebar_widget_padding_right_mobile   = get_theme_mod( 'sidebar_widget_padding_right_mobile' );
$sidebar_widget_padding_bottom_mobile  = get_theme_mod( 'sidebar_widget_padding_bottom_mobile' );
$sidebar_widget_padding_left_mobile    = get_theme_mod( 'sidebar_widget_padding_left_mobile' );

if ( $sidebar_widget_padding_top_desktop || $sidebar_widget_padding_right_desktop || $sidebar_widget_padding_bottom_desktop || $sidebar_widget_padding_left_desktop || $sidebar_widget_padding_top_tablet || $sidebar_widget_padding_right_tablet || $sidebar_widget_padding_bottom_tablet || $sidebar_widget_padding_left_tablet || $sidebar_widget_padding_top_desktop || $sidebar_widget_padding_right_desktop || $sidebar_widget_padding_bottom_desktop || $sidebar_widget_padding_left_desktop || $sidebar_widget_padding_top_mobile || $sidebar_widget_padding_right_mobile || $sidebar_widget_padding_bottom_mobile || $sidebar_widget_padding_left_mobile ) {

	$theme_mod_array = array( // Because on the booleon check on the output, it's okay to save "false" here if no value exists.
		'desktop_top'    => $sidebar_widget_padding_top_desktop,
		'desktop_right'  => $sidebar_widget_padding_right_desktop,
		'desktop_bottom' => $sidebar_widget_padding_bottom_desktop,
		'desktop_left'   => $sidebar_widget_padding_left_desktop,
		'tablet_top'     => $sidebar_widget_padding_top_tablet,
		'tablet_right'   => $sidebar_widget_padding_right_tablet,
		'tablet_bottom'  => $sidebar_widget_padding_bottom_tablet,
		'tablet_left'    => $sidebar_widget_padding_left_tablet,
		'mobile_top'     => $sidebar_widget_padding_top_mobile,
		'mobile_right'   => $sidebar_widget_padding_right_mobile,
		'mobile_bottom'  => $sidebar_widget_padding_bottom_mobile,
		'mobile_left'    => $sidebar_widget_padding_left_mobile,
	);

	$theme_mod_array = json_encode( $theme_mod_array, true );

	set_theme_mod( 'sidebar_widget_padding', $theme_mod_array );

	remove_theme_mod( 'sidebar_widget_padding_top_desktop' );
	remove_theme_mod( 'sidebar_widget_padding_right_desktop' );
	remove_theme_mod( 'sidebar_widget_padding_bottom_desktop' );
	remove_theme_mod( 'sidebar_widget_padding_left_desktop' );

	remove_theme_mod( 'sidebar_widget_padding_top_tablet' );
	remove_theme_mod( 'sidebar_widget_padding_right_tablet' );
	remove_theme_mod( 'sidebar_widget_padding_bottom_tablet' );
	remove_theme_mod( 'sidebar_widget_padding_left_tablet' );

	remove_theme_mod( 'sidebar_widget_padding_top_mobile' );
	remove_theme_mod( 'sidebar_widget_padding_right_mobile' );
	remove_theme_mod( 'sidebar_widget_padding_bottom_mobile' );
	remove_theme_mod( 'sidebar_widget_padding_left_mobile' );

}