<?php
/**
 * The template for displaying featured content items
 *
 * @package creativityarchitect
 */

$number = get_theme_mod( 'creativityarchitect_service_number', 4 );

if ( ! $number ) {
	// If number is 0, then this section is disabled
	return;
}

$args = array(
	'orderby'             => 'post__in',
	'ignore_sticky_posts' => 1 // ignore sticky posts
);

$post_list  = array();// list of valid post/page ids

$no_of_post = 0; // for number of posts

$args['post_type'] = 'ect-service';

for ( $i = 1; $i <= $number; $i++ ) {
	$creativityarchitect_post_id = '';

	$creativityarchitect_post_id =  get_theme_mod( 'creativityarchitect_service_cpt_' . $i );

	if ( $creativityarchitect_post_id && '' !== $creativityarchitect_post_id ) {
		// Polylang Support.
		if ( class_exists( 'Polylang' ) ) {
			$creativityarchitect_post_id = pll_get_post( $creativityarchitect_post_id, pll_current_language() );
		}

		$post_list = array_merge( $post_list, array( $creativityarchitect_post_id ) );

		$no_of_post++;
	}
}

$args['post__in'] = $post_list;

if ( 0 === $no_of_post ) {
	return;
}

$args['posts_per_page'] = $no_of_post;
$loop     = new WP_Query( $args );

if ( $loop -> have_posts() ) :
	while ( $loop -> have_posts() ) :
		$loop -> the_post();

		get_template_part( 'template-parts/services/content-services' );

	endwhile;
	wp_reset_postdata();
endif;
