<?php
/**
 * Add inline styles to the head area
 * @package THEMENAE
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

 // Dynamic styles
function inline_styles($customizer_css) {


// BEGIN CUSTOM CSS

// site identity group
	$sitetitle_colour = esc_attr(get_theme_mod( 'sitetitle_colour', '#262626' ) );
	$tagline_colour = esc_attr(get_theme_mod( 'tagline_colour', '#444' ) );
	$customizer_css .="#site-title a,#site-title a:visited,#site-title a:hover { color: $sitetitle_colour;	}
		#site-description { color: $tagline_colour;	}	";

// Colours
$line_colour = esc_attr(get_theme_mod( 'line_colour', '#dedede' ) );
$image_border = esc_attr(get_theme_mod( 'image_border', '#d8d2c5' ) );
$image_hborder = esc_attr(get_theme_mod( 'image_hborder', '#c3b496' ) );

$splash_button = esc_attr(get_theme_mod( 'splash_button', '#262626' ) );
$splash_button_text = esc_attr(get_theme_mod( 'splash_button_text', '#fff' ) );
$splash_hbutton = esc_attr(get_theme_mod( 'splash_hbutton', '#c3b496' ) );
$splash_hbutton_text = esc_attr(get_theme_mod( 'splash_hbutton_text', '#fff' ) );

$first_colour = esc_attr(get_theme_mod( 'first_colour', '#c7b897' ) );
$second_colour = esc_attr(get_theme_mod( 'third_colour', '#262626' ) );
$third_colour = esc_attr(get_theme_mod( 'fourth_colour', '#9a9a9a' ) );

$menu_link_colour = esc_attr(get_theme_mod( 'menu_link_colour', '#161616' ) );
$menu_hover_link_colour = esc_attr(get_theme_mod( 'menu_hover_link_colour', '#ceb654' ) );
$submenu_bg = esc_attr(get_theme_mod( 'submenu_bg', '#fff' ) );
$submenu_border = esc_attr(get_theme_mod( 'submenu_border', '#ececec' ) );
$submenu_link_colour = esc_attr(get_theme_mod( 'submenu_link_colour', '#161616' ) );
$submenu_link_hover_colour = esc_attr(get_theme_mod( 'submenu_link_hover_colour', '#ceb654' ) );
$customizer_css .="

.hentry .post-thumbnail a img,
.page .post-thumbnail img,
.single .post-thumbnail img,
#author-info .avatar,
#related-posts .wp-post-image,
#attachment-wrapper img,
.thumbnail img,
#banner-sidebar img,
.rp-social-icons-list a,
.rp-social-icons-list a:visited,
#comments .comment .avatar {border-color: $image_border;}


.rp-social-icons-list a:hover {background-color: $image_border;}
.rp-social-icons-list li .icon {fill: $image_border;}

.hentry .post-thumbnail a img:hover,
#related-posts .wp-post-image:hover {border-color: $image_border;}

#splash-menu .splash-button a,
#splash-menu .splash-button a:visited {background-color: $splash_button; color: $splash_button_text; }
#splash-menu .splash-button a:hover {background-color: $splash_hbutton; color: $splash_hbutton_text; }

#site-branding:after,
hr.page-title-line,
#respond input[type=\"text\"],
#respond textarea,
span.page-wrap,
.widget-title,
.tagcloud a,
#author-info,
input[type=\"text\"],
input[type=\"password\"],
input[type=\"date\"],
input[type=\"datetime\"],
input[type=\"datetime-local\"],
input[type=\"month\"],
input[type=\"week\"],
input[type=\"email\"],
input[type=\"number\"],
input[type=\"search\"],
input[type=\"tel\"],
input[type=\"time\"],
input[type=\"url\"],
input[type=\"color\"],
textarea,
select {border-color: $line_colour;}

.entry-title:after,
.author-name:after,
#blog-sidebar li:after {background-color: $line_colour;}

::-moz-selection {background-color: $first_colour;}
::selection {background-color: $first_colour;}

#breadcrumbs-wrapper,
#top-bar {border-color: $first_colour;}
.has-accent-color {color: $first_colour;}
table thead,
.has-accent-background-color,
#top-search {background-color: $first_colour;}
#top-bar .icon:hover {fill: $first_colour;}

#site-title a,
#site-title a:visited,
#site-title a:hover,
#post-categories a,
#post-categories a:visited,
#post-tags a,
#post-tags a:visited,
.attachment .gallery-post-caption,
h1, h2, h3, h4, h5, h6,
a:hover,
.image figcaption,
figcaption,
.image figcaption,
.has-dark-grey-color,
#comments a,
.main-navigation-toggle {color: $second_colour;}

#top-bar,
.has-dark-grey-background-color,
.button,
.button:visited,
button,
button:visited,
input[type=\"submit\"],
input[type=\"submit\"]:visited,
input[type=\"reset\"],
input[type=\"reset\"]:visited,
.attachment-button a,
.attachment-button a:visited,
#infinite-handle span {background-color: $second_colour;}

.main-navigation-toggle .icon,
#footer-social-icons .social-icons-menu li a .icon {fill: $second_colour;}

.post-details,
.post-details a,
.post-details a:visited,
.related-post-date,
#page-intro,
.has-grey-color {color: $third_colour;}

.has-grey-background-color {-background-color: $third_colour;}



.main-navigation-menu a,
    .main-navigation-menu a:visited { color: $menu_link_colour;}
	.main-navigation-menu > .menu-item-has-children a .sub-menu-icon .icon { fill: $menu_link_colour;}


.main-navigation-menu ul a,
    .main-navigation-menu ul a:visited { color: $submenu_link_colour;}

@media (min-width: 768px){
.main-navigation-menu ul a:focus,
    .main-navigation-menu ul a:hover { color: $submenu_link_hover_colour;}
}
.main-navigation-menu a:focus,
    .main-navigation-menu a:hover,
	.main-navigation-menu ul a:hover,
    .main-navigation-menu ul a:active,
    .main-navigation-menu .sub-menu li.current-menu-item > a  { color: $menu_hover_link_colour;}

.main-navigation-menu ul,
.main-navigation-menu  { background: $submenu_bg;}
.main-navigation-menu ul { border-color: $submenu_border;}

@media (min-width: 768px){
.main-navigation-menu {background: transparent;}
}
";


// Dropcap
	$dropcap_colour = esc_attr(get_theme_mod( 'dropcap_colour', '#444' ) );
	$customizer_css .="p.has-drop-cap:not(:focus):first-letter { color: $dropcap_colour;	} ";


// END CUSTOM CSS - Output all the styles
wp_add_inline_style( 'stylesheet', $customizer_css );

}
add_action( 'wp_enqueue_scripts', 'inline_styles' );
