<?php
/**
 * Header.
 *
 * Construct the theme header.
 *
 * @package TheCreativityArchitect
 * @subpackage Template Parts
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

?>

<header id="header" class="page-header" itemscope="itemscope" itemtype="https://schema.org/WPHeader">

	<?php do_action( 'header_open' ); ?>

	<?php do_action( 'pre_header' ); ?>

	<?php // transparent_header() & sticky_navigation() will be removed with 3.0. Instead navigation_classes() & navigation_attributes will be used. ?>
	<div class="<?php navigation_classes(); if ( function_exists( 'transparent_header' ) ) transparent_header(); ?>" <?php navigation_attributes(); ?> <?php if ( function_exists( 'sticky_navigation' ) ) sticky_navigation(); ?>>

		<?php do_action( 'before_main_navigation' ); ?>

		<?php do_action( 'navigation' ); ?>

		<?php do_action( 'mobile_navigation' ); ?>

		<?php do_action( 'after_main_navigation' ); ?>

	</div>

	<?php do_action( 'header_close' ); ?>

</header>
