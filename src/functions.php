<?php
/**
 * TheCreativityArchitect's functions and definitions
 *
 * @package TheCreativityArchitect
 * @since TheCreativityArchitect 1.0
 */

 defined( 'ABSPATH' ) || die( "Can't access directly" );
 define( 'theme_directory()', 'get_stylesheet_directory()' );

 global $content_width;
 if ( !isset( $content_width ) ) { $content_width = 1920; }

function THEMENAE_setup() {
  require theme_directory() . '/inc/theme-support.php';
  require theme_directory() . '/inc/customizer.php';

  require theme_directory() . '/inc/functions/custom-theme-functions.php';
  require theme_directory() . '/inc/functions/menu-functions.php';
  require theme_directory() . '/inc/functions/template-functions.php';

  require theme_directory() . '/inc/admin-options.php';
  require theme_directory() . '/inc/body-classes.php';
  require theme_directory() . '/inc/class-css.php';
  require theme_directory() . '/inc/css-output.php';
  require theme_directory() . '/inc/custom-css.php';
  require theme_directory() . '/inc/dashboard.php';
  require theme_directory() . '/inc/defaults.php';
  require theme_directory() . '/inc/edit-link.php';
  require theme_directory() . '/inc/element-classes.php';
  require theme_directory() . '/inc/general.php';
  require theme_directory() . '/inc/helpers.php';
  require theme_directory() . '/inc/licences.php';
  require theme_directory() . '/inc/markup.php';
  require theme_directory() . '/inc/men-descriptions.php';
  require theme_directory() . '/inc/meta-box.php';
  require theme_directory() . '/inc/plugin-compat.php';
  require theme_directory() . '/inc/plugins.php';
  require theme_directory() . '/inc/portfolio.php';
  require theme_directory() . '/inc/setup.php';
  require theme_directory() . '/inc/shortcode-taglist.php';
  require theme_directory() . '/inc/shortcode-fix-empty-p-tag.php';
  require theme_directory() . '/inc/shortcode-div-wraparound.php';
  require theme_directory() . '/inc/theme-functions.php';
  require theme_directory() . '/inc/tools.php';
  require theme_directory() . '/inc/typography.php';

  require theme_directory() . '/inc/classes/classes-theme-options.php';

  add_action( 'after_setup_theme', 'autologin' );
  add_action( 'after_setup_theme', 'background_setup' );
  add_action( 'after_switch_theme', 'custom_theme_functions' );
  add_action( 'after_setup_theme', 'theme_functions' );
  add_action( 'after_setup_theme', 'theme_support' );
  add_action( 'after_setup_theme', 'theme_setup' );
  add_action( 'after_setup_theme', 'custom_logo_setup' );
  add_action( 'after_setup_theme', 'custom_header_setup' );
  add_action( 'after_setup_theme', 'menu_functions_and_filters' );
  add_action( 'after_setup_theme', 'load_theme_options', 9 );
  add_action( 'after_setup_theme', 'remove_admin_bar' );

  add_action( 'add_meta_boxes', 'editlink_meta_box' );
  add_action( 'admin_enqueue_scripts', 'custom_admin_styles' );
  add_action( 'admin_notices', 'admin_notice' );
  add_action( 'admin_init', 'notice_dismissed' );
  add_action( 'admin_menu', 'change_post_label' );
  add_action( 'admin_menu', 'drafts_menu');
  add_action( 'after_switch_theme', 'setup' );

  add_action( 'comment_form_before', 'enqueue_comment_reply_script' );
  add_action( 'comment_form_before', 'enqueue_comments_reply' );
  add_action( 'customize_preview_init', 'customize_preview_js' );
  add_action( 'customize_register', 'customize_register' );
  add_action( 'get_header', 'enable_threaded_comments' );
  add_action( 'init', 'change_post_object' );
  add_action( 'init', 'remove_dynamic_css' );

  add_action( 'login_enqueue_scripts', 'login_logo' );
  add_action( 'pre_get_posts', 'show_drafts' );
  add_action( 'publish_post',  'publish', 10, 2 );
  add_action( 'rest_api_init', 'create_api_posts_meta_field' );
  add_action( 'widgets_init', 'widgets_init' );

  add_action( 'wp_ajax_nopriv_ajax_tag_search', 'ajax_tag_search' );
  add_action( 'wp_ajax_ajax_tag_search', 'ajax_tag_search' );
  add_action( 'wp_ajax_nopriv_upload_action', 'upload_action' );
  add_action( 'wp_ajax_upload_action', 'upload_action' );
  add_action( 'wp_before_admin_bar_render', 'options_to_admin' );

  add_action( 'wp_body_open', 'skip_link', 5 );

 add_action( 'wp_enqueue_scripts', 'add_scripts');
 add_action( 'wp_enqueue_scripts', 'enqueue_dynamic_css', 50 );
 add_action( 'wp_enqueue_scripts', 'enqueue_scripts_and_styles' );
 add_action( 'wp_enqueue_scripts', 'enqueue_styles' );
 add_action( 'wp_enqueue_scripts', 'enqueue_vendor_scripts_and_styles' );
 add_action( 'wp_enqueue_scripts', 'magic_cursor_scripts' );

 add_action( 'wp_footer', 'footer' );

 add_action( 'wp_head', 'customizer_css' );
 add_action( 'wp_head', 'enqueue_conditional_scripts' );
 add_action( 'wp_head', 'enqueue_fonts' );
 add_action( 'wp_head', 'no_featured_image');

 add_action( 'wp_head', 'enqueue_scripts' );
 add_action( 'wp_head', 'enqueue_support_scripts_and_styles' );
 add_action( 'wp_head', 'javascript_detection', 0 );
 add_action( 'wp_head', 'pingback_header' );


 add_filter('admin_footer_text', 'remove_footer_admin');
 add_filter( 'auth_cookie_expiration', 'cookie_expiration', 99, 3 );
 add_filter( 'big_image_size_threshold', '__return_false' );
 add_filter('comment_form_defaults', 'comment_mod');
 add_filter( 'comment_notification_recipients', 'comment_notification_recipients', 15, 2 );
 add_filter( 'comment_notification_text', 'comment_notification_text', 20, 2 );
 add_filter( 'document_title_separator', 'document_title_separator' );
 add_filter( 'excerpt_length', 'new_excerpt_length' );
 add_filter( 'excerpt_more', 'excerpt_read_more_link' );
 add_filter( 'excerpt_more', 'trim_excerpt' );
 add_filter( 'get_comments_number', 'comment_count', 0 );
 add_filter( 'get_the_archive_title', 'get_the_archive_title', 10, 1 );
 add_filter( 'intermediate_image_sizes_advanced', 'image_insert_override' );
 add_filter( 'login_headerurl', 'login_link' );
 add_filter('login_message', 'add_login_message');
 add_filter( 'login_headertext', 'login_logo_url_title' );

 add_filter( 'nav_menu_link_attributes', 'schema_url', 10 );
 add_filter( 'pre_option_image_default_size', 'my_default_image_size' );
 add_filter( 'query_vars', 'tqueryvars' );
 add_filter( 'show_admin_bar', 'remove_admin_bar' );
 add_filter( 'the_content_more_link', 'read_more_link' );
 add_filter( 'the_content', 'firstview' );
 add_filter( 'the_excerpt', 'read_more_custom_excerpt' );
 add_filter( 'the_generator', 'remove_version' );
 add_filter( 'the_posts', 'reveal_previews', 10, 2 );
 add_filter( 'the_title', 'title' );
 add_filter( 'wp_mail_content_type', 'set_html_content_type' );

 remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

 add_shortcode('count', 'count');
 add_shortcode("taglist", "taglist");
}

function remove_version() {
  return '';
}

function remove_footer_admin () {
   echo 'Fueled by <a href="http://www.wordpress.org" target="_blank">WordPress</a> | WordPress Tutorials: <a href="https://deardorffassociatesweb.wordpress.com/" target="_blank">Dev</a></p>';
 }

function footer() {
   ?>
   <script>
   jQuery(document).ready(function($) {
     var deviceAgent = navigator.userAgent.toLowerCase();
     if (deviceAgent.match(/(iphone|ipod|ipad)/)) {
       $("html").addClass("ios");
     }
     if (navigator.userAgent.search("MSIE") >= 0) {
       $("html").addClass("ie");
     }
     else if (navigator.userAgent.search("Chrome") >= 0) {
       $("html").addClass("chrome");
     }
     else if (navigator.userAgent.search("Firefox") >= 0) {
       $("html").addClass("firefox");
     }
     else if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
       $("html").addClass("safari");
     }
     else if (navigator.userAgent.search("Opera") >= 0) {
       $("html").addClass("opera");
     }
   });
   </script>
   <?php
 }


function document_title_separator( $sep ) {
 $sep = '|';
 return $sep;
}

function title( $title ) {
 if ( $title == '' ) {
   return '...';
 } else {
   return $title;
 }
}

function schema_url( $atts ) {
  $atts['itemprop'] = 'url';
  return $atts;
}

function remove_admin_bar() {
  return false;
}

function javascript_detection() {
 	echo "<script>(function(html){html.className = html.className.replace(/\bno-js\b/,'js')})(document.documentElement);</script>\n";
}

function reading_time() {
  $content = get_post_field( 'post_content', $post->ID );
  $word_count = str_word_count( strip_tags( $content ) );
  $readingtime = ceil($word_count / 200);
  if ($readingtime == 1) {
    $timer = " minute";
  } else {
    $timer = " minutes";
  } $totalreadingtime = $readingtime . $timer;
  return $totalreadingtime;
}

function enable_threaded_comments() {
  if ( ! is_admin() ) {
    if ( is_singular() AND comments_open() AND ( get_option( 'thread_comments' ) == 1 ) ) {
      wp_enqueue_script( 'comment-reply' );
    }
  }
}

function custom_pings( $comment ) {
  ?>
  <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>"><?php echo esc_url( comment_author_link() ); ?></li>
  <?php
}

function comment_count( $count ) {
  if ( !is_admin() ) {
    global $id;
    $get_comments = get_comments( 'status=approve&post_id=' . $id );
    $comments_by_type = separate_comments( $get_comments );
    return count( $comments_by_type['comment'] );
  } else {
    return $count;
  }
}

function html_classes() {
  $classes = apply_filters( 'html_classes', '' );
  if ( ! $classes ) {
    return;
  }
 echo 'class="' . esc_attr( $classes ) . '"';
}

function skip_link() {
  echo '<a href="#content" class="skip-link screen-reader-text">' . esc_html__( 'Skip to the content', 'TheCreativityArchitect' ) . '</a>';
}

function read_more_link() {
  if ( !is_admin() ) {
    return ' <a href="' . esc_url( get_permalink() ) . '" class="more-link">' . sprintf( __( '...%s', 'TheCreativityArchitect' ), '<span class="screen-reader-text">  ' . esc_html( get_the_title() ) . '</span>' ) . '</a>';
  }
}

function excerpt_read_more_link( $more ) {
  if ( !is_admin() ) {
    global $post;
    return ' <a href="' . esc_url( get_permalink( $post->ID ) ) . '" class="more-link">' . sprintf( __( '...%s', 'TheCreativityArchitect' ), '<span class="screen-reader-text">  ' . esc_html ( get_the_title() ) . '</span>' ) . '</a>';
  }
}

function image_insert_override( $sizes ) {
   unset( $sizes['medium_large'] );
   unset( $sizes['1536x1536'] );
   unset( $sizes['2048x2048'] );
   return $sizes;
 }

function widgets_init() {
 register_sidebar(
   array(
     'name'          => esc_html__( 'Sidebar', 'TheCreativityArchitect' ),
     'id'            => 'sidebar-1',
     'description'   => '',
     'before_widget' => '<div id="%1$s" class="widget">',
     'after_widget'  => '</div>',
     'before_title'  => '<h2 class="widget-title">',
     'after_title'   => '</h2>',
   )
 );

  register_sidebar(
    array(
      'name'          => esc_html__( 'Top Widget',
      'TheCreativityArchitect' ),
      'id'            => 'sidebar-2',
      'description'   => '',
      'before_widget' => '<div id="%1$s"
      class="widget">',
      'after_widget'  => '</div>',
      'before_title'  => '<h2 class="widget-title">',
      'after_title'   => '</h2>',
    )
  );
}

function pingback_header() {
  if ( is_singular() && pings_open() ) {
    printf( '<link rel="pingback" href="%s" />' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
  }
}

function theme_uri_link() {
  return 'https://thecreativityarchitect.com';
}

function queryvars( $qvars ) {
	$qvars[] = 'tk'; // token key for editing previously made stuff
	$qvars[] = 'wid'; // post id for editing
	$qvars[] = 'random'; // random flag
	$qvars[] = 'elink'; // edit link flag
	$qvars[] =  'ispre'; // another preview flag

	return $qvars;
}

function rewrite_rules() {
	// for sending to random item
   add_rewrite_rule('random/?$', 'index.php?random=1','top');

   // for edit link requests
   add_rewrite_rule( '^get-edit-link/([^/]+)/?',  'index.php?elink=1&wid=$matches[1]','top');

}

function save_post_random_check( $post_id ) {
    // verify post is not a revision and that the post slug is "random"

    $new_post = get_post( $post_id );
    if ( ! wp_is_post_revision( $post_id ) and  $new_post->post_name == 'random' ) {
        // unhook this function to prevent infinite looping
        remove_action( 'save_post', 'save_post_random_check' );

        // update the post slug
        wp_update_post( array(
            'ID' => $post_id,
            'post_name' => 'randomly' // do your thing here
        ));

        // re-hook this function
        add_action( 'save_post', 'save_post_random_check' );

    }
}

function comment_notification_recipients( $emails, $comment_id ) {
  $comment = get_comment( $comment_id );
  if ( ok_to_notify( $comment ) ) {
    $emails[] = get_post_meta(  $comment->comment_post_ID, 'wEmail', 1 );
  }
  return ( $emails );
}

function comment_notification_text( $notify_message, $comment_id ){
    // get the current comment
    $comment = get_comment( $comment_id );

    // change notification only for recipient who is the author of this an item (e.g. skip for admins)
    if ( ok_to_notify( $comment ) ) {
    	// get post data
    	$post = get_post( $comment->comment_post_ID );

		// don't modify trackbacks or pingbacks
		if ( '' == $comment->comment_type ){
			// build the new message text
			$notify_message  = sprintf( __( 'New comment on  "%s" published at "%s"' ), $post->post_title, get_bloginfo( 'name' ) ) . "\r\n\r\n----------------------------------------\r\n";
			$notify_message .= sprintf( __('Author : %1$s'), $comment->comment_author ) . "\r\n";
			$notify_message .= sprintf( __('E-mail : %s'), $comment->comment_author_email ) . "\r\n";
			$notify_message .= sprintf( __('URL    : %s'), $comment->comment_author_url ) . "\r\n";
			$notify_message .= sprintf( __('Comment Link: %s'), get_comment_link( $comment_id ) ) . "\r\n\r\n----------------------------------------\r\n";
			$notify_message .= __('Comment: ') . "\r\n" . $comment->comment_content . "\r\n\r\n----------------------------------------\r\n\r\n";

			$notify_message .= __('See all comments: ') . "\r\n";
			$notify_message .= get_permalink($comment->comment_post_ID) . "#comments\r\n\r\n";

		}
	}

	// return the notification text
    return $notify_message;
}

function ok_to_notify( $comment ) {
	// check if theme options are set to use comments and that the post associated with comment has the notify flag activated
	return ( sort_option('allow_comments') and get_post_meta( $comment->comment_post_ID, 'wCommentNotify', 1 ) );
}

function enqueue_scripts_and_styles() {
   function enqueue_styles() {
    $css_path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/scripts/css/lib/' : 'assets/scripts/css/';

    wp_register_style( 'animate-style', get_template_directory_uri() . '/css/animate.css', array(), '1', 'screen' );
    wp_register_style( 'style', get_template_directory_uri() . '/style.css' );

    wp_enqueue_style( 'icon-font', get_template_directory_uri() . '/css/min/iconfont-min.css', '', 'VERSION' );
    wp_enqueue_style( 'responsive', get_template_directory_uri() . '/assets/scripts/css/min/responsive-min.css', '', 'VERSION' );
  }

  function enqueue_fonts() {
    wp_enqueue_style( 'avdira', get_template_directory() . '/assets/fonts/avdira/avdira.css' );
    wp_enqueue_style( 'enjoy-writing', get_template_directory() . '/assets/fonts/enjoy-writing/enjoywriting.css' );
    wp_enqueue_style( 'euphorigenic', get_template_directory() . '/assets/fonts/euphorigenic/euphorigenic.css' );
    wp_enqueue_style( 'glass-antiqua', get_template_directory() . '/assets/fonts/glass-antiqua/glassantiqua.css' );
    wp_enqueue_style( 'hand-typewriter', get_template_directory() . '/assets/fonts/handtypewriter/handtypewriter.css' );
    wp_enqueue_style( 'raleway', get_template_directory() . '/assets/fonts/raleway/raleway.css' );
    wp_enqueue_style( 'lifesavers', get_template_directory() . '/assets/fonts/lifesavers.css' );
    wp_enqueue_style( 'raylig', get_template_directory() . '/assets/fonts/raylig.css' );
  }

  function enqueue_scripts() {
   $min  = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
   $js_path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? 'assets/cripts/js/lib/' : 'assets/scripts/js/';
   $min_js = 'assets/scripts/js/min/';
   $deps[] = 'jquery';

    wp_register_script( 'responsive-videos', $js_path . 'responsive-videos.js', array( 'jquery' ), '1.0', true );
    wp_register_script( 'custom', get_template_directory_uri() . '/ssets/scripts/js/customscripts.js', array( 'jquery' ), '1.0', true );

    wp_register_script( 'html5', $js_path . 'html5.js' );
    wp_register_script( 'copyright', get_theme_file_uri() . '/assets/scripts/js/css_comment.js' );
    wp_register_script( 'scripts', get_theme_file_uri() . '/assets/scripts/js/scripts.js', array( 'jquery' ), '', true );
    wp_register_script( 'skip-link-focus-fix', $js_path . 'skip-link-focus-fix' . $min . '.js', array(), '201800703', true );
    wp_register_script( 'site', $min_js . 'site-min.js', array( 'jquery' ), 'VERSION', true );
    wp_register_script( 'responsive-embeds-script', $js_path. 'responsive-embeds.js', array( 'ie11-polyfills' ), wp_get_theme()->get( 'VERSION' ), true );
    wp_register_script( 'index', get_theme_file_uri() . '/assets/scripts/js/index.js' );
   }

  function header_scripts() {
    if ( $GLOBALS['pagenow'] != 'wp-login.php' && ! is_admin() ) {
      if ( 'SCRIPT_DEBUG' ) {
        wp_deregister_script( 'jquery' );
        wp_register_script( 'jquery', get_template_directory_uri() . '/assets/scripts/js/lib/jQuery/jquery.js', array(), '1.11.1' );

        wp_register_script( 'conditionizr', get_template_directory_uri() . '/assets/scripts/js/lib/conditionizr-4.3.0.min.js', array(), '4.3.0' );

        wp_register_script( 'modernizr', get_template_directory_uri() . '/assets/scripts/js/lib/modernizr.js', array(), '2.8.3' );
      }
    }
  }

  function enqueue_vendor_scripts_and_styles() {
    $path = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '/assets/scripts/js/lib/' : 'assets/scripts/js/';
    $jquery = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '/assets/scripts/js/jQuery/' : '/assets/scripts/js_admn' ;

    wp_register_script( 'animate', get_template_directory_uri() . $jquery . 'animate.js', array( 'jquery' ), true );
    wp_register_script( 'editlink', get_template_directory_uri() . $jquery . 'editlink.js', array( 'jquery' ), '0.1.0', true );
    wp_register_script( 'fittext', get_template_directory_uri() . $jquery . 'fittext.js', array( 'jquery' ), '0.1.0', true );
    wp_register_script( 'fitvids', get_template_directory_uri() . $jquery . 'fitvids.js', array( 'jquery' ), '0.1.0', true );
    wp_register_script( 'keyboard-image-navigation', get_template_directory_uri() . $jquery . 'keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
    wp_register_script( 'matchHeight', get_template_directory_uri() . $jquery . 'matchHeight.js', array( 'jquery' ), '20171226', true );
    wp_register_script( 'menu-button', get_template_directory_uri() . $jquery . 'menu-button.js', array( 'jquery' ), '0.1.0', true );
    wp_register_script( 'small-menu', get_template_directory_uri() . $jquery . 'small-menu.js', array( 'jquery' ), '0.1.0', true );
    wp_register_script( 'options', get_template_directory_uri() . $jquery . 'opitions.js', array( 'jquery' ), '0.1.0', true );
    wp_register_script( 'writer', get_template_directory_uri() . $jquery . 'writer.js', array( 'jquery' ), '0.1.0', true );
  }

  function enqueue_support_scripts_and_styles() {
    wp_add_inline_script(
      'site',
      'var Obj = {
        ajaxurl: "' . admin_url( 'admin-ajax.php' ) . '"
      };',
      'before'
    );
    wp_style_add_data( 'style', 'rtl', 'replace' );
  }

  function magic_cursor_scripts() {
    $dir_uri = get_stylesheet_directory_uri();
    $settings = get_option( 'settings' );
    $magic_cursor  = 'enable';

    if ( isset( $settings['magic_cursor'] ) ) {
      $magic_cursor = $settings['magic_cursor'];
    }
    if ( $magic_cursor != 'disable' ) {
      wp_register_style( 'magic-mouse', esc_url( $dir_uri ) . "/assets/scripts/css/magic-mouse.css", false, 'VERSION', 'all' );
      wp_register_script( 'magic-mouse', esc_url( $dir_uri ) . "/assets/scripts/js/jQuery/magic-mouse.js", array( 'jquery'), 'VERSION', true );
    }
  }

 wp_enqueue_script( 'html5' );
 wp_enqueue_script( 'copyright' );
 wp_enqueue_script( 'scripts' );
 wp_enqueue_script( 'jquery' );
 wp_enqueue_script( 'skip-link-focus-fix' );
 wp_enqueue_script( 'site' );
 wp_enqueue_script( 'responsive-embeds-script' );
 wp_enqueue_script( 'index' );
 wp_enqueue_script( 'fitvid' );
 wp_enqueue_script( 'animate' );
 wp_enqueue_script( 'functions' );
 wp_enqueue_script( 'responsive-videos' );
 wp_enqueue_script( 'animate' );
 wp_enqueue_script( 'custom' );
 wp_enqueue_script( 'magic-mouse' );

 wp_enqueue_script( 'header_scripts', get_template_directory_uri() . '/assets/scripts/js/scripts.js', array( 'conditionizr', 'modernizr', 'jquery' ), '1.0.0' );

 wp_enqueue_style( 'magic-mouse' );
 wp_enqueue_style( 'owl-carousel-core' );
 wp_enqueue_style( 'owl-carousel-default' );
 wp_enqueue_style( 'owl-carousel' );

 wp_enqueue_style( 'animate' );
 wp_enqueue_style( 'style' );
 function enqueue_comment_reply_script() {
     if ( get_option( 'thread_comments' ) ) {
       wp_enqueue_script( 'comment-reply' );
     }
   }
 function enqueue_conditional_scripts() {
     if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
       wp_enqueue_script( 'comment-reply' );
     }
     if ( is_singular() && wp_attachment_is_image() ) {
       wp_enqueue_script( 'keyboard-image-navigation',  get_template_directory_uri() . '/assets/scripts/js/jQuery/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
     }
     if ( has_nav_menu( 'primary-menu' ) ) {
       wp_enqueue_script( 'primary-navigation-script',
          array(
            get_template_directory_uri() . '/assets/scripts/js/lib/primary-navigation.js', array( 'ie11-polyfills' ),
            get_template_directory_uri() , '/assets/scripts/js/lib/menu-control.js', array( 'jquery'), VERSION, true
          )
        );
        if ( 'click' == $settings[ 'nav_dropdown_type' ] || 'click-arrow' == $settings[ 'nav_dropdown_type' ] ) {
          wp_enqueue_script( 'dropdown-click', get_template_directory_uri(). "/assets/scripts/js/dropdown-click{$suffix}.js", array( 'menu' ), VERSION, true );
        }
        if ( 'enable' == $settings['nav_search'] ) {
    			wp_enqueue_script( 'navigation-search', get_template_directory_uri() . "/js/navigation-search{$suffix}.js", array( 'menu' ), VERSION, true );
    		}
        if ( 'enable' == $settings['back_to_top'] ) {
        wp_enqueue_script( 'back-to-top', $dir_uri . "/js/back-to-top{$suffix}.js", array(), VERSION, true );
      }
    }

    if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
       echo '<script>'; include get_template_directory() . '/assets/scripts/js/lib/skip-link-focus-fix.js'; echo '</script>';
     } else {
       ?>
       <script>
       /(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){
         var t,e=location.hash.substring(1);/^[A-z0-9_-]+$/.test(e)&&(t=document.getElementById(e))&&(/^(?:a|select|input|button|textarea)$/i.test(t.tagName)||(t.tabIndex=-1),t.focus())
       }
       ),!1)
       </script>
       <?php
     }
   }
 }

function customize_controls_enqueue_scripts() {
  wp_enqueue_script( 'customizer', get_directory_uri() . '/assets/scripts/js/customize.js' );
  wp_enqueue_script( 'customize-live-preview',
   get_directory_uri() . '/inc/customize/controls/js/customizer-live-preview.js' ,
   array(),
   wp_get_theme()->get( 'VERSION' ),
   true
 );
 wp_enqueue_script( 'customizer-reset',
   get_theme_file_uri() . '/assets/scripts/js/lib/customizer/customizer-reset.js' ,
   wp_get_theme()->get( 'VERSION' ),
   true
 );
}
