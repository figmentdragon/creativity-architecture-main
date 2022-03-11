<?php
/**
 * The template used for displaying hero content
 *
 * @package TheCreativityArchitect
 */

$enable_section = get_theme_mod( 'TheCreativityArchitect_hero_content_visibility', 'disabled' );

if ( ! TheCreativityArchitect_check_section( $enable_section ) ) {
	// Bail if hero content is not enabled
	return;
}

get_template_part( 'template-parts/hero-content/post-type-hero' );

