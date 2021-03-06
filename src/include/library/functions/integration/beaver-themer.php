<?php
/**
 * Beaver Themer integration.
 *
 * @package THEMENAME
 * @subpackage Integration
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Add Beaver Themer header/footer/parts support.
 */
function beaver_themer_support() {

	add_theme_support( 'fl-theme-builder-headers' );
	add_theme_support( 'fl-theme-builder-footers' );
	add_theme_support( 'fl-theme-builder-parts' );

}
add_action( 'after_setup_theme', 'beaver_themer_support' );

/**
 * Render header & footer.
 */
function bt_do_header_footer() {

	// Get the header ID.
	$header_ids = FLThemeBuilderLayoutData::get_current_page_header_ids();

	// If we have a header, remove the theme header and hook in Beaver Themer's.
	if ( ! empty( $header_ids ) ) {
		remove_action( 'header', 'do_header' );
		add_action( 'header', 'FLThemeBuilderLayoutRenderer::render_header' );
	}

	// Get the footer ID.
	$footer_ids = FLThemeBuilderLayoutData::get_current_page_footer_ids();

	// If we have a footer, remove the theme footer and hook in Beaver Themer's.
	if ( ! empty( $footer_ids ) ) {
		remove_action( 'footer', 'do_footer' );
		add_action( 'footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
	}

}
add_action( 'wp', 'bt_do_header_footer' );

/**
 * Parts integration.
 */
function bt_register_parts() {

	return array(
		array(
			'label' => 'Page',
			'hooks' => array(
				'body_open'  => 'Page Open',
				'body_close' => 'Page Close',
			),
		),
		array(
			'label' => 'Header',
			'hooks' => array(
				'before_header' => 'Before Header',
				'after_header'  => 'After Header',
				'header_open'   => 'Header Open',
				'header_close'  => 'Header Close',
			),
		),
		array(
			'label' => 'Footer',
			'hooks' => array(
				'before_footer' => 'Before Footer',
				'after_footer'  => 'After Footer',
				'footer_open'   => 'Footer Open',
				'footer_close'  => 'Footer Close',
			),
		),
	);

}
add_filter( 'fl_theme_builder_part_hooks', 'bt_register_parts' );

/**
 * Remove header if selected in the theme.
 */
function bt_remove_header() {

	// Don't take it further if we're on archives.
	if ( ! is_singular() ) {
		return;
	}

	$options       = get_post_meta( get_the_ID(), 'options', true );
	$remove_header = $options ? in_array( 'remove-header', $options ) : false;

	if ( $remove_header ) {
		remove_action( 'header', 'FLThemeBuilderLayoutRenderer::render_header' );
	}

}
add_action( 'wp', 'bt_remove_header' );

/**
 * Remove footer if selected in the theme.
 */
function bt_remove_footer() {

	// Don't take it further if we're on archives.
	if ( ! is_singular() ) {
		return;
	}

	$options       = get_post_meta( get_the_ID(), 'options', true );
	$remove_footer = $options ? in_array( 'remove-footer', $options ) : false;

	if ( $remove_footer ) {
		remove_action( 'footer', 'FLThemeBuilderLayoutRenderer::render_footer' );
	}

}
add_action( 'wp', 'bt_remove_footer' );
