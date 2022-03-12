<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package creativityarchitect
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @since 1.0
 *
 * @param array $classes Classes for the body element.
 * @return array (Maybe) filtered body classes.
 */
function creativityarchitect_body_classes( $classes ) {
  // Adds a class with respect to layout selected.
  $layout  = creativityarchitect_get_theme_layout();
  $sidebar = creativityarchitect_get_sidebar_id();
  // Get the navigation location
  $navigation_location = creativityarchitect_get_navigation_location();

  $layout_class = "no-sidebar content-width-layout";
  if ( 'right-sidebar' === $layout ) {
    if ( '' !== $sidebar ) {
      $layout_class = 'two-columns-layout content-left';
    }
  }
  if ( 'left-sidebar' === $layout ) {
    if ( '' !== $sidebar ) {
      $layout_class = 'two-columns-layout content-right';
    }
  }
	$classes[] = $layout_class;

  // Layout classes
  $classes[] = ( $layout ) ? $layout : 'right-sidebar';

  $classes[] = ( $navigation_location ) ? $navigation_location : 'nav-below-header';

  $classes[] = ( $creativityarchitect_settings['header_layout_setting'] ) ? $creativityarchitect_settings['header_layout_setting'] : 'fluid-header';

  $classes[] = ( $creativityarchitect_settings['content_layout_setting'] ) ? $creativityarchitect_settings['content_layout_setting'] : 'separate-containers';

  $classes[] = ( '' !== $widgets ) ? 'active-footer-widgets-' . $widgets : 'active-footer-widgets-3';






  // Adds a class of (full-width) to blogs.
	$classes[] = 'fluid-layout';

	$classes[] = 'navigation-default';
  $classes[] = ( 'enable' == $creativityarchitect_settings['nav_search'] ) ? 'nav-search-enabled' : '';



	// Adds a class of custom-background-image to sites with a custom background image.
	if ( get_background_image() ) { $classes[] = 'custom-background-image'; }
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) { $classes[] = 'hfeed'; }

	// Always add a front-page class to the front page.
	if ( is_front_page() && ! is_home() ) { $classes[] = 'page-template-front-page'; }
	if( is_front_page() && ! is_home() ) { $classes[] = 'blog'; }
  $classes[] = 'excerpt';

	$classes['color-scheme'] = esc_attr( 'color-scheme-' . get_theme_mod( 'color_scheme', 'default' ) );

	$enable_slider = creativityarchitect_check_section( get_theme_mod( 'creativityarchitect_slider_option', 'disabled' ) );

	$header_image = creativityarchitect_featured_overall_image();

	if ( 'disable' !== $header_image || $enable_slider ) {
    if ( 'disable' !== $header_image ) {
      $classes[] = 'has-header-media'; }
      $classes[] = 'absolute-header';
    }

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add a class if there is header media text.
	if ( creativityarchitect_has_header_media_text() ) {
		$classes[] = 'has-header-text';
	}

	return $classes;
}
add_filter( 'body_class', 'creativityarchitect_body_classes' );

add_filter( 'creativityarchitect_right_sidebar_class', 'creativityarchitect_right_sidebar_classes');

function creativityarchitect_right_sidebar_classes( $classes ) {
  $right_sidebar_width = apply_filters( 'creativityarchitect_right_sidebar_width', '25' );
  $left_sidebar_width = apply_filters( 'creativityarchitect_left_sidebar_width', '25' );

  $right_sidebar_tablet_width = apply_filters( 'creativityarchitect_right_sidebar_tablet_width', $right_sidebar_width );
  $left_sidebar_tablet_width = apply_filters( 'creativityarchitect_left_sidebar_tablet_width', $left_sidebar_width );

  $classes[] = 'widget-area';
  $classes[] = 'grid-' . $right_sidebar_width;
  $classes[] = 'tablet-grid-' . $right_sidebar_tablet_width;
  $classes[] = 'grid-parent';
  $classes[] = 'sidebar';

  // Get the layout
  $layout = creativityarchitect_get_layout();

  if ( '' !== $layout ) {
    switch ( $layout ) {
      case 'both-left' :
        $total_sidebar_width = $left_sidebar_width + $right_sidebar_width;
        $classes[] = 'pull-' . ( 100 - $total_sidebar_width );

        $total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;
        $classes[] = 'tablet-pull-' . ( 100 - $total_sidebar_tablet_width );
      break;
    }
  }
  return $classes;
}

add_filter( 'creativityarchitect_left_sidebar_class', 'creativityarchitect_left_sidebar_classes' );
/**
 * Adds custom classes to the left sidebar.
 *
 */
function creativityarchitect_left_sidebar_classes( $classes ) {
  $right_sidebar_width = apply_filters( 'creativityarchitect_right_sidebar_width', '25' );
  $left_sidebar_width = apply_filters( 'creativityarchitect_left_sidebar_width', '25' );
	$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;

	$right_sidebar_tablet_width = apply_filters( 'creativityarchitect_right_sidebar_tablet_width', $right_sidebar_width );
	$left_sidebar_tablet_width = apply_filters( 'creativityarchitect_left_sidebar_tablet_width', $left_sidebar_width );
	$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;

	$classes[] = 'widget-area';
	$classes[] = 'grid-' . $left_sidebar_width;
	$classes[] = 'tablet-grid-' . $left_sidebar_tablet_width;
	$classes[] = 'mobile-grid-100';
	$classes[] = 'grid-parent';
	$classes[] = 'sidebar';

	// Get the layout
	$layout = creativityarchitect_get_layout();

	if ( '' !== $layout ) {
		switch ( $layout ) {
			case 'left-sidebar' :
				$classes[] = 'pull-' . ( 100 - $left_sidebar_width );
				$classes[] = 'tablet-pull-' . ( 100 - $left_sidebar_tablet_width );
			break;

			case 'both-sidebars' :
			case 'both-left' :
				$classes[] = 'pull-' . ( 100 - $total_sidebar_width );
				$classes[] = 'tablet-pull-' . ( 100 - $total_sidebar_tablet_width );
			break;
		}
	}
	return $classes;
}

add_filter( 'creativityarchitect_content_class', 'creativityarchitect_content_classes' );
/**
 * Adds custom classes to the content container.
 *
 */
function creativityarchitect_content_classes( $classes ) {
	$right_sidebar_width = apply_filters( 'creativityarchitect_right_sidebar_width', '25' );
	$left_sidebar_width = apply_filters( 'creativityarchitect_left_sidebar_width', '25' );
	$total_sidebar_width = $left_sidebar_width + $right_sidebar_width;

	$right_sidebar_tablet_width = apply_filters( 'creativityarchitect_right_sidebar_tablet_width', $right_sidebar_width );
	$left_sidebar_tablet_width = apply_filters( 'creativityarchitect_left_sidebar_tablet_width', $left_sidebar_width );
	$total_sidebar_tablet_width = $left_sidebar_tablet_width + $right_sidebar_tablet_width;

	$classes[] = 'content-area';
	$classes[] = 'grid-parent';
	$classes[] = 'mobile-grid-100';

	// Get the layout
	$layout = creativityarchitect_get_layout();

	if ( '' !== $layout ) {
		switch ( $layout ) {
      case 'right-sidebar' :
      $classes[] = 'grid-' . ( 100 - $right_sidebar_width );
      $classes[] = 'tablet-grid-' . ( 100 - $right_sidebar_tablet_width );
      break;
      case 'left-sidebar' :
      $classes[] = 'push-' . $left_sidebar_width;
      $classes[] = 'grid-' . ( 100 - $left_sidebar_width );
      $classes[] = 'tablet-push-' . $left_sidebar_tablet_width;
      $classes[] = 'tablet-grid-' . ( 100 - $left_sidebar_tablet_width );
      break;
      case 'no-sidebar' :
      $classes[] = 'grid-100';
      $classes[] = 'tablet-grid-100';
      break;

      case 'both-sidebars' :
      $classes[] = 'push-' . $left_sidebar_width;
      $classes[] = 'grid-' . ( 100 - $total_sidebar_width );
      $classes[] = 'tablet-push-' . $left_sidebar_tablet_width;
      $classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
      break;
      case 'both-right' :
      $classes[] = 'grid-' . ( 100 - $total_sidebar_width );
      $classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
      break;
      case 'both-left' :
      $classes[] = 'push-' . $total_sidebar_width;
      $classes[] = 'grid-' . ( 100 - $total_sidebar_width );
			$classes[] = 'tablet-push-' . $total_sidebar_tablet_width;
			$classes[] = 'tablet-grid-' . ( 100 - $total_sidebar_tablet_width );
			break;
		}
	}
  return $classes;
}

add_filter( 'creativityarchitect_header_class', 'creativityarchitect_header_classes' );
/**
 * Adds custom classes to the header.
 */
function creativityarchitect_header_classes( $classes ) {
	$classes[] = 'site-header';

	// Get theme options
	$creativityarchitect_settings = wp_parse_args(
		get_option( 'creativityarchitect_settings', array() ),
		creativityarchitect_get_defaults()
	);
	$header_layout = $creativityarchitect_settings['header_layout_setting'];

	if ( $header_layout == 'contained-header' ) {
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	}
	return $classes;
}

add_filter( 'creativityarchitect_inside_header_class', 'creativityarchitect_inside_header_classes' );
/**
 * Adds custom classes to inside the header.
 *
 */
function creativityarchitect_inside_header_classes( $classes ) {
	$classes[] = 'inside-header';
	$inner_header_width = creativityarchitect_get_setting( 'header_inner_width' );

	if ( $inner_header_width !== 'full-width' ) {
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	}
	return $classes;
}

add_filter( 'creativityarchitect_navigation_class', 'creativityarchitect_navigation_classes' );
	/**
	 * Adds custom classes to the navigation.
	 *
	 */
function creativityarchitect_navigation_classes( $classes ) {
	$classes[] = 'main-navigation';

	// Get theme options
	$creativityarchitect_settings = wp_parse_args(
		get_option( 'creativityarchitect_settings', array() ),
		creativityarchitect_get_defaults()
	);
	$nav_layout = $creativityarchitect_settings['nav_layout_setting'];

	if ( $nav_layout == 'contained-nav' ) {
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	}
	return $classes;
}

add_filter( 'creativityarchitect_inside_navigation_class', 'creativityarchitect_inside_navigation_classes' );
/**
 * Adds custom classes to the inner navigation.
 */
function creativityarchitect_inside_navigation_classes( $classes ) {
	$classes[] = 'inside-navigation';
	$inner_nav_width = creativityarchitect_get_setting( 'nav_inner_width' );
	if ( $inner_nav_width !== 'full-width' ) {
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	}
	return $classes;
}

add_filter( 'creativityarchitect_menu_class', 'creativityarchitect_menu_classes' );
	/**
	 * Adds custom classes to the menu.
	 *
	 */
function creativityarchitect_menu_classes( $classes ) {
  $classes[] = 'menu';
	$classes[] = 'sf-menu';
	return $classes;
}


add_filter( 'creativityarchitect_footer_class', 'creativityarchitect_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 */
	function creativityarchitect_footer_classes( $classes ) {
	$classes[] = 'site-footer';

	// Get theme options
	$creativityarchitect_settings = wp_parse_args(
		get_option( 'creativityarchitect_settings', array() ),
		creativityarchitect_get_defaults()
	);
	$footer_layout = $creativityarchitect_settings['footer_layout_setting'];

	if ( $footer_layout == 'contained-footer' ) {
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	}

	// Footer bar
	$classes[] = ( is_active_sidebar( 'footer-bar' ) ) ? 'footer-bar-active' : '';
	$classes[] = ( is_active_sidebar( 'footer-bar' ) ) ? 'footer-bar-align-' . $creativityarchitect_settings[ 'footer_bar_alignment' ] : '';

	return $classes;
}

add_filter( 'creativityarchitect_inside_footer_class', 'creativityarchitect_inside_footer_classes' );
	/**
	 * Adds custom classes to the footer.
	 *
	 */
function creativityarchitect_inside_footer_classes( $classes ) {
	$classes[] = 'footer-widgets-container';
	$inside_footer_width = creativityarchitect_get_setting( 'footer_widgets_inner_width' );

	if ( $inside_footer_width !== 'full-width' ) {
		$classes[] = 'grid-container';
		$classes[] = 'grid-parent';
	}
	return $classes;
}

add_filter( 'creativityarchitect_main_class', 'creativityarchitect_main_classes' );
	/**
	 * Adds custom classes to the <main> element
	 *
	 */
function creativityarchitect_main_classes( $classes ) {
	$classes[] = 'site-main';
	return $classes;
}

add_filter( 'post_class', 'creativityarchitect_post_classes' );
	/**
	 * Adds custom classes to the <article> element.
	 * Remove .hentry class from pages to comply with structural data guidelines.
	 *
	 */
function creativityarchitect_post_classes( $classes ) {
	if ( 'page' == get_post_type() ) {
		$classes = array_diff( $classes, array( 'hentry' ) );
	}
	return $classes;
}

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function creativityarchitect_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'creativityarchitect_pingback_header' );

/**
 * Adds custom overlay for Promotion Headline Background Image
 */
function creativityarchitect_promo_head_bg_image_overlay_css() {
	$overlay = get_theme_mod( 'creativityarchitect_promo_head_background_image_opacity', '0' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
		$css = '.promotion-section .post-thumbnail-background:before {
					background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
			    } '; // Dividing by 100 as the option is shown as % for user
	}

	wp_add_inline_style( 'creativityarchitect-style', $css );
}
add_action( 'wp_enqueue_scripts', 'creativityarchitect_promo_head_bg_image_overlay_css', 11 );

/**
 * Adds custom overlay for Header Media
 */
function creativityarchitect_header_media_image_overlay_css() {
	$overlay = get_theme_mod( 'creativityarchitect_header_media_image_opacity' );

	$css = '';

	$overlay_bg = $overlay / 100;

	if ( $overlay ) {
	$css = '.custom-header-overlay {
		background-color: rgba(0, 0, 0, ' . esc_attr( $overlay_bg ) . ' );
    } '; // Dividing by 100 as the option is shown as % for user
  }
  wp_add_inline_style( 'creativityarchitect-style', $css );
}
add_action( 'wp_enqueue_scripts', 'creativityarchitect_header_media_image_overlay_css', 11 );

/**
 * Remove first post from blog as it is already show via recent post template
 */
function creativityarchitect_alter_home( $query ) {
	if ( $query->is_home() && $query->is_main_query() ) {
		$cats = get_theme_mod( 'creativityarchitect_front_page_category' );

		if ( is_array( $cats ) && ! in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] = $cats;
		}

	}
}
add_action( 'pre_get_posts', 'creativityarchitect_alter_home' );

if ( ! function_exists( 'creativityarchitect_content_nav' ) ) :
	/**
	 * Display navigation/pagination when applicable
	 *
	 * @since 1.0
	 */
	function creativityarchitect_content_nav() {
		global $wp_query;

		// Don't print empty markup in archives if there's only one page.
		if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
			return;
		}

		$pagination_type = get_theme_mod( 'creativityarchitect_pagination_type', 'default' );

		if ( ( class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) || class_exists( 'Catch_Infinite_Scroll' ) ) {
			// Support infinite scroll plugins.
			the_posts_navigation();
		} elseif ( 'numeric' === $pagination_type && function_exists( 'the_posts_pagination' ) ) {
			the_posts_pagination( array(
				'prev_text'          => '<span>' . esc_html__( 'Prev', 'creativityarchitect' ) . '</span>',
				'next_text'          => '<span>' . esc_html__( 'Next', 'creativityarchitect' ) . '</span>',
				'screen_reader_text' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'creativityarchitect' ) . ' </span>',
			) );
		} else {
			the_posts_navigation();
		}
	}
endif; // creativityarchitect_content_nav

/**
 * Check if a section is enabled or not based on the $value parameter
 * @param  string $value Value of the section that is to be checked
 * @return boolean return true if section is enabled otherwise false
 */
function creativityarchitect_check_section( $value ) {
	return ( 'entire-site' == $value  || ( is_front_page() && 'homepage' === $value ) );
}

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since 1.0
 */
function creativityarchitect_get_first_image( $postID, $size, $attr, $src = false ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if ( isset( $matches[1][0] ) ) {
		// Get first image.
		$first_img = $matches[1][0];

		if ( $src ) {
			//Return url of src is true
			return $first_img;
		}

		return '<img class="wp-post-image" src="'. esc_url( $first_img ) .'">';
	}

	return false;
}

function creativityarchitect_get_theme_layout() {
	$layout = '';

	if ( is_page_template( 'templates/no-sidebar.php' ) ) {
		$layout = 'no-sidebar';
	} elseif ( is_page_template( 'templates/right-sidebar.php' ) ) {
		$layout = 'right-sidebar';
	} else {
		$layout = get_theme_mod( 'creativityarchitect_default_layout', 'right-sidebar' );

		if ( is_home() || is_archive() ) {
			$layout = get_theme_mod( 'creativityarchitect_homepage_archive_layout', 'right-sidebar' );
		}
	}

	return $layout;
}

function creativityarchitect_get_sidebar_id() {
	$sidebar = $id = '';

	$layout = creativityarchitect_get_theme_layout();

	if ( 'no-sidebar' === $layout ) {
		return $sidebar;
	}

	if ( is_active_sidebar( 'sidebar-1' ) ) {
		$sidebar = 'sidebar-1'; // Primary Sidebar.
	}

	return $sidebar;
}

/**
 * Return a phrase shortened in length to a maximum number of characters.
 *
 * Result will be truncated at the last white space in the original string. In this function the word separator is a
 * single space. Other white space characters (like newlines and tabs) are ignored.
 *
 * If the first `$max_characters` of the string does not contain a space character, an empty string will be returned.
 *
 * @since 1.0
 *
 * @param string $text            A string to be shortened.
 * @param integer $max_characters The maximum number of characters to return.
 *
 * @return string Truncated string
 */
function creativityarchitect_truncate_phrase( $text, $max_characters ) {
  $text = trim( $text );

	if ( mb_strlen( $text ) > $max_characters ) {
		//* Truncate $text to $max_characters + 1
		$text = mb_substr( $text, 0, $max_characters + 1 );

		//* Truncate to the last space in the truncated string
		$text = trim( mb_substr( $text, 0, mb_strrpos( $text, ' ' ) ) );
	}

	return $text;
}

/**
 * Return content stripped down and limited content.
 *
 * Strips out tags and shortcodes, limits the output to `$max_char` characters, and appends an ellipsis and more link to the end.
 *
 * @since 1.0
 *
 * @param integer $max_characters The maximum number of characters to return.
 * @param string  $more_link_text Optional. Text of the more link. Default is "(more...)".
 * @param bool    $stripteaser    Optional. Strip teaser content before the more text. Default is false.
 *
 * @return string Limited content.
 */
function creativityarchitect_get_the_content_limit( $max_characters, $more_link_text = '(more...)', $stripteaser = false ) {
  $content = get_the_content( '', $stripteaser );
  // Strip tags and shortcodes so the content truncation count is done correctly.
  $content = strip_tags( strip_shortcodes( $content ), apply_filters( 'get_the_content_limit_allowedtags', '<script>,<style>' ) );
  // Remove inline styles / .
  $content = trim( preg_replace( '#<(s(cript|tyle)).*?</\1>#si', '', $content ) );
  // Truncate $content to $max_char
  $content = creativityarchitect_truncate_phrase( $content, $max_characters );
  // More link?
	if ( $more_link_text ) {
		$link   = apply_filters( 'get_the_content_more_link', sprintf( '<span class="readmore"><a href="%s" class="more-link">%s</a></span>', esc_url( get_permalink() ), $more_link_text ), $more_link_text );
		$output = sprintf( '<p>%s %s</p>', $content, $link );
	} else {
		$output = sprintf( '<p>%s</p>', $content );
		$link = '';
	}

	return apply_filters( 'creativityarchitect_get_the_content_limit', $output, $content, $link, $max_characters );
}

/**
 * Template for Featured Image in Archive Content
 *
 * To override this in a child theme
 * simply fabulous-fluid your own creativityarchitect_content_image(), and that function will be used instead.
 *
 * @since 1.0
 */
function creativityarchitect_content_image() {
	if ( has_post_thumbnail() && creativityarchitect_jetpack_featured_image_display() && is_singular() ) {
    global $post, $wp_query;

    // Get Page ID outside Loop.
    $page_id = $wp_query->get_queried_object_id();
    if ( $post ) {
      if ( is_attachment() ) {
        $parent = $post->post_parent;
        $individual_featured_image = get_post_meta( $parent, 'creativityarchitect-featured-image', true );
      } else {
        $individual_featured_image = get_post_meta( $page_id, 'creativityarchitect-featured-image', true );
      }
    }
    if ( empty( $individual_featured_image ) ) {
      $individual_featured_image = 'default';
    }
    if ( 'disable' === $individual_featured_image ) {
      echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
      return false;
    } else {
      $class = array();
      $image_size = 'post-thumbnail';
      if ( 'default' !== $individual_featured_image ) {
        $image_size = $individual_featured_image;
        $class[]    = 'from-metabox';
      } else {
        $layout = creativityarchitect_get_theme_layout();
        if ( 'no-sidebar-full-width' === $layout ) {
          $image_size = 'post-thumbnail';
        }
      }
      $class[] = $individual_featured_image;
      ?>
      <div class="post-thumbnail <?php echo esc_attr( implode( ' ', $class ) ); ?>">
        <a href="<?php the_permalink(); ?>">
          <?php the_post_thumbnail( $image_size ); ?>
        </a>
      </div>
      <?php
    }
  } // End if ().
}

/**
 * Display Sections on header and footer with respect to the section option set in creativityarchitect_sections_sort
 */
function creativityarchitect_sections( $selector = 'header' ) {
		get_template_part( 'template-parts/header/header-media' );
		get_template_part( 'template-parts/slider/display-slider' );
		get_template_part( 'template-parts/portfolio/display-portfolio' );
		get_template_part( 'template-parts/hero-content/content-hero' );
		get_template_part( 'template-parts/testimonial/display-testimonial' );
		get_template_part( 'template-parts/services/display-services' );
		get_template_part( 'template-parts/featured-content/display-featured' );
	}

/**
 * $image_size post thumbnail size
 * $type html, html-with-bg, url
 * $echo echo true/false
 * $no_thumb display no-thumb image or not
 */
function creativityarchitect_post_thumbnail( $image_size = 'post-thumbnail', $type = 'html', $echo = true, $no_thumb = false ) {
  $image = $image_url = '';
  if ( has_post_thumbnail() ) {
    $image_url = get_the_post_thumbnail_url( get_the_ID(), $image_size );
    $image     = get_the_post_thumbnail( get_the_ID(), $image_size );
  } else {
    if ( is_array( $image_size ) && $no_thumb ) {
      $image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-' . $image_size[0] . 'x' . $image_size[1] . '.jpg';
      $image      = '<img src="' . esc_url( $image_url ) . '" alt="" />';
    } elseif ( $no_thumb ) {
      global $_wp_additional_image_sizes;

      $image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-1920x822.jpg';
      if ( array_key_exists( $image_size, $_wp_additional_image_sizes ) ) {
        $image_url  = trailingslashit( get_template_directory_uri() ) . 'assets/images/no-thumb-' . $_wp_additional_image_sizes[ $image_size ]['width'] . 'x' . $_wp_additional_image_sizes[ $image_size ]['height'] . '.jpg';
      }

      $image      = '<img src="' . esc_url( $image_url ) . '" alt="" />';
    }

    // Get the first image in page, returns false if there is no image.
    $first_image_url = creativityarchitect_get_first_image( get_the_ID(), $image_size, '', true );

    // Set value of image as first image if there is an image present in the page.
    if ( $first_image_url ) {
      $image_url = $first_image_url;
      $image = '<img class="wp-post-image" src="'. esc_url( $image_url ) .'">';
    }
  }
  if ( ! $image_url ) {
    // Bail if there is no image url at this stage.
    return;
  }
  if ( 'url' === $type ) {
    return $image_url;
  }
  $output = '<div';
  if ( 'html-with-bg' === $type ) {
    $output .= ' class="post-thumbnail-background" style="background-image: url( ' . esc_url( $image_url ) . ' )"';
  } else {
    $output .= ' class="post-thumbnail"';
  }
  $output .= '>';
  if ( 'html-with-bg' !== $type ) {
    $output .= '<a href="' . esc_url( get_the_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '">' . $image;
  } else {
    $output .= '<a class="cover-link" href="' . esc_url( get_the_permalink() ) . '" title="' . the_title_attribute( 'echo=0' ) . '">';
  }
  $output .= '</a></div><!-- .post-thumbnail -->';
  if ( ! $echo ) {
    return $output;
  }
  echo $output;
}
