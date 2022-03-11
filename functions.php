<?php
	/*-----------------------------------------------------------------------------------*/
	/* This file will be referenced every time a template/page loads on your Wordpress site
	/* This is the place to define custom fxns and specialty code
	/*-----------------------------------------------------------------------------------*/

// Define the version so we can easily replace it throughout the theme
define( 'CREATIVITYARCHITECT_VERSION', 1.0 );

require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/icon-functions.php';
require get_template_directory() . '/inc/widget-social-icons.php';
require get_template_directory() . '/inc/class-tgm-plugin-activation.php';
require get_template_directory() . '/inc/custom-header.php';
require get_template_directory() . '/inc/customizer/customizer.php';

function setup() {
	global $content_width;
	if ( ! isset( $content_width ) ) {
			$content_width = 1600;
	}

	load_theme_textdomain( '', get_template_directory() . '/languages' );

	add_editor_style( 'style-editor.css' );

	add_image_size( 'blogthumb', 1300, 9999 );
  add_image_size( 'blogthumb', 1300, 9999 );
  add_image_size( 'creativityarchitect-slider', 1920, 1080, true ); // Ratio 16:9
  add_image_size( 'creativityarchitect-portfolio', 1920, 9999, true ); // Flexible Height

	add_post_type_support( 'page', 'excerpt' );

  add_theme_support( 'align-wide' );
	add_theme_support( 'automatic-feed-links' );
  add_theme_support( 'custom-background',
    apply_filters(
      'creativityarchitect_custom_background_args',
      array(
        'default-color' => 'ffffff',
        'default-image' => '',
      )
    )
  );
  $logo_height = 400;
  $logo_width = 400;
  add_theme_support( 'custom-logo',
      array(
        'height'               => $logo_height,
        'width'                => $logo_width,
        'flex-width'           => true,
        'flex-height'          => true,
        'unlink-homepage-logo' => true,
      )
    );
  add_theme_support( 'custom-spacing' );
  add_theme_support( 'customize-selective-refresh-widgets' );
  add_theme_support( 'editor-font-sizes',
    array(
      array(
				'name' => esc_html__( 'Small', 'creativityarchitect' ),
				'size' => 13,
				'slug' => 'small',
			),
			array(
				'name' => esc_html__( 'Regular', 'creativityarchitect' ),
				'size' => 17,
				'slug' => 'regular',
			),
			array(
				'name' => esc_html__( 'Medium', 'creativityarchitect' ),
				'size' => 26,
				'slug' => 'medium',
			),
			array(
				'name' => esc_html__( 'Large', 'creativityarchitect' ),
				'size' => 36,
				'slug' => 'large',
			),
			array(
				'name' => esc_html__( 'Huge', 'creativityarchitect' ),
				'size' => 50,
				'slug' => 'huge',
			),
		)
	);
	add_theme_support( 'editor-styles' );
  add_theme_support( 'html5',
    array(
      'search-form',
      'comment-form',
      'comment-list',
      'gallery',
      'caption',
      'style',
      'script',
			'navigation-widgets',
    )
  );
  add_theme_support( 'post-formats',
    array(
      'link',
      'aside',
      'gallery',
      'image',
      'quote',
      'status',
      'video',
      'audio',
      'chat',
    )
  );
  add_theme_support( 'post-thumbnails' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'title-tag' );

  register_nav_menus(
    array(
      'main-menu' => esc_html__( 'Primary Menu', 'creativityarchitect' ),
      'social'    => esc_html__( 'Social Menu', 'creativityarchitect' ),
    ) );

}
add_action( 'after_setup_theme', 'setup' );

function creativityarchitect_register_sidebars() {
	register_sidebar(array(				// Start a series of sidebars to register
		'id' => 'sidebar', 					// Make an ID
		'name' => 'Sidebar',				// Name it
		'description' => 'Take it on the side...', // Dumb description for the admin side
		'before_widget' => '<div>',	// What to display before each widget
		'after_widget' => '</div>',	// What to display following each widget
		'before_title' => '<h3 class="side-title">',	// What to display before each widget's title
		'after_title' => '</h3>',		// What to display following each widget's title
		'empty_title'=> '',					// What to display in the case of no title defined for a widget
		// Copy and paste the lines above right here if you want to make another sidebar,
		// just change the values of id and name to another word/name
	));
}
add_action( 'widgets_init', 'creativityarchitect_register_sidebars' );

/**
 * Handles JavaScript detection.
 *
 * Adds a `js` class to the root `<html>` element when JavaScript is detected.
 *
 * @since 1.0
 */
function creativityarchitect_javascript_detection() {
	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}
add_action( 'wp_head', 'creativityarchitect_javascript_detection', 0 );

/*-----------------------------------------------------------------------------------*/
/* Enqueue Styles and Scripts
/*-----------------------------------------------------------------------------------*/

function creativityarchitect_scripts()  {
	$min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
  $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'src/js/' : 'js/';
  // get the theme directory style.css and link to it in the header
  wp_enqueue_style( 'creativity-style', get_template_directory_uri() . '/style.css' );

  // add fitvid
  wp_enqueue_script( 'creativityarchitect-fitvid', get_template_directory_uri() . '/js/jquery.fitvids.js', array( 'jquery' ), 'CREATIVITYARCHITECT_VERSION', true );

  // add theme scripts
  wp_enqueue_script( 'creativityarchitect', get_template_directory_uri() . '/js/theme.min.js', array(), 'CREATIVITYARCHITECT_VERSION', true );
  wp_enqueue_script( 'creativityarchitect-skip-link-focus-fix', get_theme_file_uri( $path . 'skip-link-focus-fix' . $min . '.js' ), array(), '201800703', true );

  $deps[] = 'jquery';
  $enable_portfolio = get_theme_mod( 'creativityarchitect_portfolio_option', 'disabled' );
  if ( creativityarchitect_check_section( $enable_portfolio ) ) {
    $deps[] = 'jquery-masonry';
  }
  $enable_featured_content = get_theme_mod( 'creativityarchitect_featured_content_option', 'disabled' );
  //Slider Scripts
	$enable_slider      = creativityarchitect_check_section( get_theme_mod( 'creativityarchitect_slider_option', 'disabled' ) );
  $enable_testimonial_slider      = creativityarchitect_check_section( get_theme_mod( 'creativityarchitect_testimonial_option', 'disabled' ) ) && get_theme_mod( 'creativityarchitect_testimonial_slider', 1 );
  if ( $enable_slider || $enable_testimonial_slider ) {
    // Enqueue owl carousel css. Must load CSS before JS.
    wp_enqueue_style( 'owl-carousel-core', get_theme_file_uri( 'css/owl-carousel/owl.carousel.min.css' ), null, '2.3.4' );
    wp_enqueue_style( 'owl-carousel-default', get_theme_file_uri( 'css/owl-carousel/owl.theme.default.min.css' ), null, '2.3.4' );
    // Enqueue script
    wp_enqueue_script( 'owl-carousel', get_theme_file_uri( $path . 'owl.carousel' . $min . '.js' ), array( 'jquery' ), '2.3.4', true );
    $deps[] = 'owl-carousel';
  }
  wp_enqueue_script( 'creativityarchitect-script', get_theme_file_uri( $path . 'functions' . $min . '.js' ), $deps, '201800703', true );
  wp_localize_script( 'creativityarchitect-script', 'creativityarchitectOptions', array(
    'screenReaderText' => array(
      'expand'   => esc_html__( 'expand child menu', 'creativityarchitect' ),
      'collapse' => esc_html__( 'collapse child menu', 'creativityarchitect' ),
      'icon'     => creativityarchitect_get_svg( array(
        'icon'     => 'angle-down',
        'fallback' => true,
      )
    ),
  ),
  'iconNavPrev'     => creativityarchitect_get_svg( array(
    'icon'     => 'angle-left',
    'fallback' => true, ) ),
  'iconNavNext'     => creativityarchitect_get_svg( array(
    'icon'     => 'angle-right',
    'fallback' => true, ) ),
  'iconTestimonialNavPrev'     => '<span>' . esc_html__( 'PREV', 'creativityarchitect' ) . '</span>',
  'iconTestimonialNavNext'     => '<span>' . esc_html__( 'NEXT', 'creativityarchitect' ) . '</span>',
  'rtl' => is_rtl(),
  'dropdownIcon'     => creativityarchitect_get_svg( array( 'icon' => 'angle-down', 'fallback' => true ) ),));

  if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
    wp_enqueue_script( 'comment-reply' );
  }
}
add_action( 'wp_enqueue_scripts', 'creativityarchitect_scripts' ); // Register this fxn and allow Wordpress to call it automatcally in the header

function creativityarchitect_get_font_face_styles() {
  return "
  @font-face { font-family: 'Avdira';
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.woff' ) . "') format('woff');
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.svg' ) . "') format('svg');
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.ttf' ) . "') format('ttf');
    src: url('" . get_theme_file_uri( 'fonts/avdira/Avdira_R.eot' ) . "') format('eot');
    font-weight: normal;
    font-style: normal;
  }
  @font-face { font-family: 'Enjoy Writing';
    font-style: normal;
    font-weight: 400;
    src: url('" . get_theme_file_uri( 'fonts/enjoy-writing/enjoywrting.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Glass Antiqua';
    font-weight: 400;
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/glass-antiqua/glassantiqua.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Hand TypeWriter';
    font-weight: 400;
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/hand-typewriter/handtypewriter.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Life Savers';
    font-style: normal;
    font-weight: 700;
    font-display: swap;
    src: url('fonts.gstatic.com/s/lifesavers/v13/ZXu_e1UftKKabUQMgxAal8HXOR5amcb4pA.woff2') format('woff2');
    unicode-range: U+0100-024F, U+0259, U+1E00-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
  }
  @font-face { font-family: 'Life Savers';
    font-style: normal;
    font-weight: 700;
    font-display: swap;
    src: url('fonts.gstatic.com/s/lifesavers/v13/ZXu_e1UftKKabUQMgxAal8HXOR5UmcY.woff2') format('woff2');
    unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
  }
  @font-face { font-family: 'Pompiere';
    font-style: normal;
    font-weight: 400;
    src: url('fonts.cdnfonts.com/s/12351/Pompiere-Regular.woff') format('woff');
  }
  @font-face { font-family: 'Raleway';
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Thin.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-ExtraLight';
    font-style: normal;
    font-weight: 275;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-ExtraLight.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Light';
    font-style: normal;
    font-weight: 300;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Light.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Italic';
    font-style: italic;
    font-weight: 400;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Italic.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway';
    font-style: normal;
    font-weight: 500;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Medium.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway';
    font-style: normal;
    font-weight: 600;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-SemiBold.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Bold';
    font-style: normal;
    font-weight: 700;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Bold.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-ExtraBold';
    font-style: normal;
    font-weight: 800;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-ExtraBold.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raleway-Black';
    font-style: normal;
    font-weight: 900;
    src: url('" . get_theme_file_uri( 'fonts/raleway/Raleway-Black.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'raleway-blackitalic';
    font-style: italic;
    font-weight: 900;
    src: url('" . get_theme_file_uri( 'fonts/raleway/raleway-blackitalic.woff' ) . "') format('woff');
  }
  @font-face { font-family: 'Raylig';
    font-style: normal;
    font-weight: 600;
    src: url('fonts.cdnfonts.com/s/70312/RayligSemibold-Wy9mE.woff') format('woff');
  }
  @font-face { font-family: 'TELETYPE 1945-1985';
    src: url('" . get_theme_file_uri( '/fonts/teletype_1945_1985/TELETYPE1945-1985.woff' ) . "') format('woff');
      font-weight: normal;
      font-style: normal;
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.eot?#iefix') format('embedded-opentype');
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.woff2') format('woff2');
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.ttf') format('truetype');
    src: url('//db.onlinewebfonts.com/t/83dc401685732778308fc7cdfe8af34e.svg#TELETYPE 1945-1985') format('svg');
  }
  @font-face { font-family: 'Wanda';
    font-weight: 700;
    font-style: normal;
    src: url('" . get_theme_file_uri( 'fonts/fonts/wanda/wanda.woff' ) . "') format('woff');
  }
";}
add_action( 'wp_enqueue_scripts', 'creativityarchitect_get_font_face_styles');

function creativityarchitect_preload_webfonts() {
  ?>
  <link rel="preload" href="<?php echo esc_url( get_theme_file_uri( 'fonts/avdira/Avdira_R.woff' ) ); ?>" as="font" type="font/woff" crossorigin>
  <?php
}
add_action( 'wp_head', 'creativityarchitect_preload_webfonts' );

if ( ! function_exists( 'creativityarchitect_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since 1.0
	 */
	function creativityarchitect_excerpt_length( $length ) {
		if ( is_admin() ) {
			return $length;
		}

		// Getting data from Customizer Options
		$length	= get_theme_mod( 'creativityarchitect_excerpt_length', 30 );

		return absint( $length );
	}
endif; //creativityarchitect_excerpt_length
add_filter( 'excerpt_length', 'creativityarchitect_excerpt_length', 999 );

if ( ! function_exists( 'creativityarchitect_excerpt_more' ) ) :
	/**
	 * Replaces "[...]" (appended to automatically generated excerpts) with ... and a option from customizer
	 *
	 * @return string option from customizer prepended with an ellipsis.
	 */
	function creativityarchitect_excerpt_more( $more ) {
		if ( is_admin() ) {
			return $more;
		}

		$more_tag_text = get_theme_mod( 'creativityarchitect_excerpt_more_text',  esc_html__( 'Continue reading', 'creativityarchitect' ) );

		$link = sprintf( '<p class="more-link"><a class="button" href="%1$s" class="readmore">%2$s</a></p>',
			esc_url( get_permalink() ),
			/* translators: %s: Name of current post */
			wp_kses_data( $more_tag_text ) . '<span class="screen-reader-text">' . get_the_title( get_the_ID() ) . '</span>'
			);

		return $link;
	}
endif;
add_filter( 'excerpt_more', 'creativityarchitect_excerpt_more' );

if ( ! function_exists( 'creativityarchitect_more_link' ) ) :
	/**
	 * Replacing Continue reading link to the_content more.
	 *
	 * function tied to the the_content_more_link filter hook.
	 *
	 * @since 1.0
	 */
	function creativityarchitect_more_link( $more_link, $more_link_text ) {
		$more_tag_text = get_theme_mod( 'creativityarchitect_excerpt_more_text', esc_html__( 'Continue reading', 'creativityarchitect' ) );

		return ' &hellip; ' . str_replace( $more_link_text, wp_kses_data( $more_tag_text ), $more_link );
	}
endif; //creativityarchitect_more_link
add_filter( 'the_content_more_link', 'creativityarchitect_more_link', 10, 2 );

function creativityarchitect_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// Catch Web Tools.
		array(
			'name' => 'Catch Web Tools', // Plugin Name, translation not required.
			'slug' => 'catch-web-tools',
		),
		// Catch IDs
		array(
			'name' => 'Catch IDs', // Plugin Name, translation not required.
			'slug' => 'catch-ids',
		),
		// To Top.
		array(
			'name' => 'To top', // Plugin Name, translation not required.
			'slug' => 'to-top',
		),
		// Catch Gallery.
		array(
			'name' => 'Catch Gallery', // Plugin Name, translation not required.
			'slug' => 'catch-gallery',
		),
	);

	if ( ! class_exists( 'Catch_Infinite_Scroll_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Infinite Scroll', // Plugin Name, translation not required.
			'slug' => 'catch-infinite-scroll',
		);
	}

	if ( ! class_exists( 'Essential_Content_Types_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Content Types', // Plugin Name, translation not required.
			'slug' => 'essential-content-types',
		);
	}

	if ( ! class_exists( 'Essential_Widgets_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Essential Widgets', // Plugin Name, translation not required.
			'slug' => 'essential-widgets',
		);
	}

	if ( ! class_exists( 'Catch_Instagram_Feed_Gallery_Widget_Pro' ) ) {
		$plugins[] = array(
			'name' => 'Catch Instagram Feed Gallery & Widget', // Plugin Name, translation not required.
			'slug' => 'catch-instagram-feed-gallery-widget',
		);
	}

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'creativityarchitect',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
	);

	tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'creativityarchitect_register_required_plugins' );

/**
 * Checks if there are options already present from free version and adds it to the Pro theme options
 *
 * @since 1.0
 * @hook after_theme_switch
 */
function creativityarchitect_setup_options( $old_theme_name ) {
	if ( $old_theme_name ) {
		$old_theme_slug = sanitize_title( $old_theme_name );
		$free_version_slug = array(
			'creativityarchitect',
		);

		$pro_version_slug  = 'creativityarchitect';

		$free_options = get_option( 'theme_mods_' . $old_theme_slug );

		// Perform action only if theme_mods_photoFocus free version exists.
		if ( in_array( $old_theme_slug, $free_version_slug ) && $free_options && '1' !== get_theme_mod( 'free_pro_migration' ) ) {
			$new_options = wp_parse_args( get_theme_mods(), $free_options );

			if ( update_option( 'theme_mods_' . $pro_version_slug, $free_options ) ) {
				// Set Migration Parameter to true so that this script does not run multiple times.
				set_theme_mod( 'free_pro_migration', '1' );
			}
		}
	}
}
add_action( 'after_switch_theme', 'creativityarchitect_setup_options' );

function creativityarchitect_copyright() {
  global $wpdb;
  $copyright_dates = $wpdb->get_results("
  SELECT
  YEAR(min(post_date_gmt)) AS firstdate,
  YEAR(max(post_date_gmt)) AS lastdate
  FROM
  $wpdb->posts
  WHERE
  post_status = 'publish'
  ");
  $output = '';
  if($copyright_dates) {
    $copyright = "&copy; " . $copyright_dates[0]->firstdate;
    if($copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate) {
      $copyright .= '-' . $copyright_dates[0]->lastdate;
    }
    $output = $copyright;
  }
  return $output;
}
