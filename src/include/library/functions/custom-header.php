<?php
/**
 * Sample implementation of the Custom header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * You can add an optional custom header image to header.php like so ...
 *
 *	<?php the_header_image_tag();
 *	if ( ! empty( $header_image ) ) { ?>
 *		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home">
 *			<img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="" />
 *		</a>
 *	<?php } // if ( ! empty( $header_image ) ); ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 *
 * @package TheCreativityArchitect
 *
 *
 * Setup the WordPress core custom header feature.
 *
 * Use add_theme_support to register support for WordPress 3.4+
 * as well as provide backward compatibility for previous versions.
 * Use feature detection of wp_get_theme() which was introduced
 * in WordPress 3.4.
 *
 * @uses header_style()
 * @uses admin_header_style()
 * @uses admin_header_image()
 *
 * @package TheCreativityArchitect
 */

/**
 * Setup the WordPress core custom header feature.
 */
function custom_header_setup() {
	add_theme_support(
		'custom-header',
		apply_filters(
			'custom_header_args',
			array(
				'width'              => 700,
				'height'             => 832,
				'flex-height'        => true,
				'uploads'            => true,
				'default-text-color' => 'cccccc',
				'wp-head-callback'   => 'header_style',
			)
		)
	);
}
add_action( 'after_setup_theme', 'custom_header_setup' );

function header_style() {
	$header_image 		= featured_overall_image();
	if ( 'disable' !== $header_image ) :
	$image_position_mobile  = get_theme_mod(
		'header_media_image_position_mobile', 'center center' );
	$image_position_desktop = get_theme_mod( 'header_media_image_position_desktop' , 'center center' );

	?>
	<?php if ( get_header_image() ) : ?>
		<style type="text/css" rel="header-image">
			 .custom-header .wrapper:before,
			 .site-header {
				 background-image: url( <?php echo esc_url( $header_image ); ?>);
				 <?php if ( 'center center' !== $image_position_mobile ) : ?>
					 background-position: <?php echo esc_attr( $image_position_mobile ); ?>;
				 <?php endif; ?>
				 background-repeat: no-repeat;
				 <?php if ( 'center center' !== $image_position_desktop ) : ?>
					 @media only screen and (min-width: 64em) {
					 .custom-header .wrapper:before {
						 background-position: <?php echo esc_attr( $image_position_desktop ); ?>;
					 }
				 }
			 }
		 <?php endif; ?>
		</style>
	<?php endif; ?>
	<?php
		$header_text_color = get_header_textcolor();
	if ( display_header_text() && $header_text_color === get_theme_support( 'custom-header', 'default-text-color' ) ) {
		return;
	}
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( ! display_header_text() ) :
	?>
		.site-title,
		.site-description {
			clip: rect(1px, 1px, 1px, 1px);
			position: absolute;
		}
	<?php
	else :
		?>
		.site-title a,
		.site-title a:visited {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
		.site-title a:hover,
		.site-title a:focus,
		.site-title a:active {
			opacity: 0.7;
		}
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
			opacity: 0.7;
		}
	<?php endif; ?>
</style>
<?php
endif;
}
function featured_image() {
	$thumbnail = 'post-thumbnail';

	if ( is_post_type_archive( 'jetpack-testimonial' ) ) {
		$jetpack_options = get_theme_mod( 'jetpack_testimonials' );
		$option = 'jetpack_testimonial_featured_image';
		$featured_image = get_option( 'jetpack_testimonial_featured_image' );
		if ( isset( $jetpack_options['featured-image'] ) && '' !== $jetpack_options['featured-image'] ) {
			$image = wp_get_attachment_image_src( (int) $jetpack_options['featured-image'], $thumbnail );
			return $image['0'];
		} elseif ( ! isset( $jetpack_options['featured-image'] ) && isset( $featured_image ) && '' !== $featured_image ) {
			$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
			return $image['0'];
		} else {
			return false;
		}
	} elseif ( is_post_type_archive( 'jetpack-portfolio' ) || is_post_type_archive( 'featured-content' ) || is_post_type_archive( 'ect-service' ) || is_post_type_archive( 'ect-team' ) || is_post_type_archive( 'ect-event' ) ) {
		$option = '';

	if ( is_post_type_archive( 'jetpack-portfolio' ) ) {
		$option = 'jetpack_portfolio_featured_image';
	} elseif ( is_post_type_archive( 'featured-content' ) ) {
		$option = 'featured_content_featured_image';
	} elseif ( is_post_type_archive( 'ect-service' ) ) {
		$option = 'ect_service_featured_image';
	} elseif ( is_post_type_archive( 'ect-team' ) ) {
		$option = 'ect_team_featured_image';
	} elseif ( is_post_type_archive( 'ect-event' ) ) {
		$option = 'ect_event_featured_image';
	}

	$featured_image = get_option( $option );
	if ( '' !== $featured_image ) {
		$image = wp_get_attachment_image_src( (int) $featured_image, $thumbnail );
		return isset( $image[0] ) ? $image[0] : false;
	} else {
		return get_header_image();
	}
} else {
	return get_header_image();
}
}

function featured_page_post_image() {
	$thumbnail = 'single-post-page';
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		if ( ! has_post_thumbnail( absint( get_option( 'woocommerce_shop_page_id' ) ) ) ) {
			return featured_image();
		}
	} elseif ( is_home() && $blog_id = get_option('page_for_posts') ) {
		if ( has_post_thumbnail( $blog_id  ) ) {
				return get_the_post_thumbnail_url( $blog_id, $thumbnail );
		} else {
			return  featured_image();
		}
	} elseif ( ! has_post_thumbnail() ) {
		return  featured_image();
	} elseif ( is_home() && is_front_page() ) {
		return  featured_image();
	}

	$shop_header = get_theme_mod( 'shop_page_header_image' );
	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		return get_the_post_thumbnail_url( absint( get_option( 'woocommerce_shop_page_id' ) ), $thumbnail );
	}elseif ( class_exists( 'WooCommerce' ) && is_product () ) {
		if (  $shop_header ){
			return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
		} else {
			return featured_image();
		}
	}else {
		return get_the_post_thumbnail_url( get_the_id(), $thumbnail );
	}
} // featured_page_post_image


function featured_overall_image() {
	global $post;
	$enable = get_theme_mod( 'header_media_option', 'entire-site' );

	// Check Enable/Disable header image in Page/Post Meta box
	if ( is_singular() ) {
		//Individual Page/Post Image Setting
		$individual_featured_image = get_post_meta( $post->ID, 'single-post-page', true );
		if ( 'disable' === $individual_featured_image || ( 'default' === $individual_featured_image && 'disable' === $enable ) ) {
			return 'disable' ;
		} elseif ( 'enable' == $individual_featured_image && 'disable' === $enable ) {
			return featured_page_post_image();
		}
	}

	// Check Homepage
	if ( 'homepage' === $enable ) {
		if ( is_front_page() ) {
			return featured_image();
		}
	} elseif ( 'exclude-home' === $enable ) {
		// Check Excluding Homepage
		if ( ! is_front_page() ) {
			return featured_image();
		}
	} elseif ( 'exclude-home-page-post' === $enable ) {
		if ( is_front_page() ) {
			return 'disable';
		} elseif ( is_singular() || ( class_exists( 'WooCommerce' ) && is_shop() ) || ( is_home() && ! is_front_page() ) ) {
			return featured_page_post_image();
		} else {
			return featured_image();
		}
	} elseif ( 'entire-site' === $enable ) {
		// Check Entire Site
		return featured_image();
	} elseif ( 'entire-site-page-post' === $enable ) {
		// Check Entire Site (Post/Page)
		if ( is_singular() || ( class_exists( 'WooCommerce' ) && is_shop() ) || ( is_home() && ! is_front_page() ) ) {
			return featured_page_post_image();
		} else {
			return featured_image();
		}
	} elseif ( 'pages-posts' === $enable ) {
		// Check Page/Post
		if ( is_singular() ) {
			return featured_page_post_image();
		}
	}

	return 'disable';
} // featured_overall_image

function header_media_text() {
	if ( ! has_header_media_text() ) {
		return get_header_image();
	}

	$content_alignment = get_theme_mod( 'header_media_content_alignment', 'content-align-right' );
	$text_alignment = get_theme_mod( 'header_media_text_alignment', 'text-align-left' );

	$header_media_logo = get_theme_mod( 'header_media_logo' );

	$classes = array();
	if( is_front_page() ) {
		$classes[] = $content_alignment;
		$classes[] = $text_alignment;
	}

	?>
	<div class="custom-header-content sections header-media-section <?php echo esc_attr( implode( ' ', $classes ) ); ?>">
		<div class="custom-header-content-wrapper">
			<?php
			$header_media_subtitle = get_theme_mod( 'header_media_sub_title' );
			$enable_homepage_logo = get_theme_mod( 'header_media_logo_option', 'homepage' );

			if( is_front_page() ) : ?>
				<div class="section-subtitle"> <?php echo esc_html( $header_media_subtitle ); ?> </div>
			<?php endif;

			if ( check_section( $enable_homepage_logo ) && $header_media_logo ) {  ?>
				<div class="site-header-logo">
					<img src="<?php echo esc_url( $header_media_logo ); ?>" title="<?php echo esc_url( home_url( '/' ) ); ?>" />
				</div><!-- .site-header-logo -->
			<?php } ?>

			<?php
			$tag = 'h2';

			if ( is_singular() || is_404() ) {
				$tag = 'h1';
			}

			header_title( '<div class="section-title-wrapper"><' . $tag . ' class="section-title entry-title">', '</' . $tag . '></div>' );
			?>

			<?php header_description( '<div class="site-header-text">', '</div>' ); ?>

			<?php if ( is_front_page() ) :
				$header_media_url_text = get_theme_mod( 'header_media_url_text' );

				if ( $header_media_url_text ) :
					$header_media_url = get_theme_mod( 'header_media_url', '#' );
					?>
					<span class="more-link">
						<a href="<?php echo esc_url( $header_media_url ); ?>" target="<?php echo esc_attr( get_theme_mod( 'header_url_target' ) ? '_blank' : '_self' ); ?>" class="readmore"><?php echo esc_html( $header_media_url_text ); ?></a>
					</span>
				<?php endif;
			endif; ?>
		</div><!-- .custom-header-content-wrapper -->
	</div><!-- .custom-header-content -->
	<?php
} // header_media_text.

function has_header_media_text() {
	$header_image = featured_overall_image();

	if ( is_front_page() ) {
		$header_media_subtitle = get_theme_mod( 'header_media_sub_title' );
		$header_media_logo     = get_theme_mod( 'header_media_logo' );
		$header_media_title    = get_theme_mod( 'header_media_title' );
		$header_media_text     = get_theme_mod( 'header_media_text' );
		$header_media_url      = get_theme_mod( 'header_media_url', '#' );
		$header_media_url_text = get_theme_mod( 'header_media_url_text' );

		if ( ! $header_media_logo && ! $header_media_subtitle && ! $header_media_title && ! $header_media_text && ! $header_media_url && ! $header_media_url_text ) {
			// Bail early if header media text is disabled
			return false;
		}
	} elseif ( 'disable' === $header_image ) {
		return false;
	}

	return true;
} // has_header_media_text.

function header_title( $before = '', $after = '' ) {
	if ( is_front_page() ) {
		$header_media_title = get_theme_mod( 'header_media_title' );
		if ( $header_media_title ) {
			echo $before . wp_kses_post( $header_media_title ) . $after;
		}
	} else if ( is_home() ) {
		$header_media_title = get_theme_mod( 'static_page_heading','Archives' );
		if ( $header_media_title ) {
			echo $before . wp_kses_post( $header_media_title ) . $after;
		}
	} elseif ( is_singular() ) {
		if ( is_page() ) {
			the_title( $before, $after );
		} else {
			the_title( $before, $after );
		}
	} elseif ( is_404() ) {
		echo $before . esc_html__( 'Nothing Found', 'darcie' ) . $after;
	} elseif ( is_search() ) {
		/* translators: %s: search query. */
		echo $before . sprintf( esc_html__( 'Search Results for: %s', 'darcie' ), '<span>' . get_search_query() . '</span>' ) . $after;
	} elseif( class_exists( 'WooCommerce' ) && is_woocommerce() ) {
		echo $before . esc_html( woocommerce_page_title( false ) ) . $after;
	}
	else {
		the_archive_title( $before, $after );
	}
}


function header_description( $before = '', $after = '' ) {
	if ( is_front_page() ) {
		echo $before . '<p>' . wp_kses_post( get_theme_mod( 'header_media_text' ) ) . '</p>' . $after;
	} elseif ( is_singular() && ! is_page() ) {
		echo $before . '<div class="entry-header"><div class="entry-meta">';
			posted_on();
		echo '</div><!-- .entry-meta --></div>' . $after;
	} elseif ( is_404() ) {
		echo $before . '<p>' . esc_html__( 'Oops! That page can&rsquo;t be found', 'darcie' ) . '</p>' . $after;
	} else {
		the_archive_description( $before, $after );
	}
}
