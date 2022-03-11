<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 */

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0, user-scalable=yes" />
<link rel="profile" href="http://gmpg.org/xfn/11">

<title>
	<?php bloginfo('name'); ?> |
	<?php is_front_page() ? bloginfo('description') : wp_title(''); ?>
</title>

<?php if ( is_singular() && pings_open( get_queried_object() ) ) :
	<link rel="pingback" href="<?php echo esc_url( get_bloginfo( 'pingback_url' ) ); ?>">
 endif; ?>
<script src="https://kit.fontawesome.com/a52bc36f18.js" crossorigin="anonymous"></script>

<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_stylesheet_directory(); ?>/assests/scripts/js/lib/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <?php get_sidebar(); ?>



  <main class="main">
