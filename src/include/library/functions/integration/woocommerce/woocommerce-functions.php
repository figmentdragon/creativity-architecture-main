<?php
/**
 * WooCommerce functions.
 *
 * @package THEMENAME
 * @subpackage Integration/WooCommerce
 */

defined( 'ABSPATH' ) || die( "Can't access directly" );

/**
 * Deregister defaults.
 */
function woo_deregister_defaults() {

	// Default sidebar.
	remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );

	// Default wrappers.
	remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
	remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

	// Loop.
	remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
	remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
	remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
	remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );

}
add_action( 'wp', 'woo_deregister_defaults', 10 );

/**
 * Register defaults.
 */
function woo_register_defaults() {
	add_action( 'woocommerce_after_shop_loop_item', 'woo_loop_content' );
}
add_action( 'wp', 'woo_register_defaults', 20 );

/**
 * Remove first & last classes from loop.
 *
 * @param array $classes The post classes.
 *
 * @return array The updated post classes.
 */
function woo_loop_remove_first_last_class( $classes ) {

	if ( 'product' === get_post_type() ) {
		$classes = array_diff( $classes, array( 'first', 'last' ) );
	}

	return $classes;

}
add_filter( 'post_class', 'woo_loop_remove_first_last_class', 21 );

/**
 * Register sidebars.
 */
function woo_sidebar() {

	// Shop page sidebar.
	register_sidebar(
		array(
			'id'            => 'woocommerce-sidebar',
			'name'          => __( 'WooCommerce Sidebar', 'TheCreativityArchitect' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
			'description'   => __( 'Widgets in this area will be shown on WooCommerce archive pages.', 'TheCreativityArchitect' ),
		)
	);

	// Product page sidebar.
	register_sidebar(
		array(
			'id'            => 'woocommerce-product-sidebar',
			'name'          => __( 'WooCommerce Product Page Sidebar', 'TheCreativityArchitect' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
			'description'   => __( 'Widgets in this area will be shown on WooCommerce product pages.', 'TheCreativityArchitect' ),
		)
	);

}
add_action( 'widgets_init', 'woo_sidebar' );

/**
 * Filter sidebars.
 *
 * @param string $sidebar The sidebar.
 *
 * @return string The updated sidebar.
 */
function woo_sidebars( $sidebar ) {

	if ( is_woocommerce() ) {

		if ( is_product() ) {
			$sidebar = 'woocommerce-product-sidebar';
		} else {
			$sidebar = 'woocommerce-sidebar';
		}
	}

	return $sidebar;

}
add_filter( 'do_sidebar', 'woo_sidebars' );

/**
 * Construct starting wrapper.
 */
function woo_output_content_wrapper() {

	$grid_gap = get_theme_mod( 'sidebar_gap', 'medium' );

	echo '<div id="content">';

	do_action( 'content_open' );

	inner_content();

	do_action( 'inner_content_open' );

	echo '<div class="grid main-grid grid-' . esc_attr( $grid_gap ) . '">';

	do_action( 'sidebar_left' );

	echo '<main id="main" class="main medium-2-3' . archive_class() . '">';

	do_action( 'main_content_open' );

}
add_action( 'woocommerce_before_main_content', 'woo_output_content_wrapper', 10 );

/**
 * Construct closing wrapper.
 */
function woo_output_content_wrapper_end() {

	do_action( 'main_content_close' );

	echo '</main>';

	do_action( 'sidebar_right' );

	echo '</div>';

	do_action( 'inner_content_close' );

	inner_content_close();

	do_action( 'content_close' );

	echo '</div>';

}
add_action( 'woocommerce_after_main_content', 'woo_output_content_wrapper_end', 10 );

/**
 * Filter sidebar layout.
 *
 * @param string $sidebar The sidebar layout.
 *
 * @return string The updated sidebar layout.
 */
function woo_sidebar_layout( $sidebar ) {

	if ( is_product() ) {

		$sidebar = get_theme_mod( 'woocommerce_single_sidebar_layout', 'none' );

		$id               = get_the_ID();
		$sidebar_position = get_post_meta( $id, 'sidebar_position', true );

		if ( $sidebar_position && 'global' !== $sidebar_position ) {
			$sidebar = $sidebar_position;
		}
	} elseif ( is_shop() || is_product_category() || is_product_taxonomy() ) {

		$sidebar = get_theme_mod( 'woocommerce_sidebar_layout', 'none' );

	}

	return $sidebar;

}
add_filter( 'sidebar_layout', 'woo_sidebar_layout' );

/**
 * Apply content/archive class.
 *
 * @param string $archive_class The archive class.
 *
 * @return string The updated archive class.
 */
function woo_archive_class( $archive_class ) {

	if ( is_product() ) {

		$archive_class = ' product-content';

	} elseif ( is_shop() || is_product_category() ) {

		$archive_class = ' product-archive';

	}

	return $archive_class;

}
add_filter( 'archive_class', 'woo_archive_class' );

/**
 * Construct starting product loop wrapper.
 *
 * @param string $start The loop start output.
 */
function woo_product_loop_start( $start ) {

	/**
	 * Only use this if you 100% know what you are doing.
	 * Allows us and 3rd parties to remove THEMENAMEs WooCommerce product loop wrappers.
	 */
	if ( ! apply_filters( 'woo_product_loop_wrapper', true ) ) {
		return $start;
	}

	// This should help with better supporting Elementor.
	// Since this class is only present on loops created with Elementor, this is save to add globally
	// if Elementor is installed.
	if ( class_exists( '\Elementor\Plugin' ) ) {
		$elementor_support = ' elementor-grid';
	} else {
		$elementor_support = '';
	}

	$products_per_row   = json_decode( get_theme_mod( 'woocommerce_loop_products_per_row' ), true );
	$desktop_breakpoint = get_theme_mod_value( $products_per_row, 'desktop', 4, true );
	$tablet_breakpoint  = get_theme_mod_value( $products_per_row, 'tablet', 3, true );
	$mobile_breakpoint  = get_theme_mod_value( $products_per_row, 'mobile', 1, true );
	$grid_gap           = get_theme_mod( 'woocommerce_loop_grid_gap', 'large' );

	return '<ul class="grid grid-' . esc_attr( $grid_gap ) . ' grid-1-' . esc_attr( $mobile_breakpoint ) . ' grid-small-1-' . esc_attr( $tablet_breakpoint ) . ' grid-large-1-' . esc_attr( $desktop_breakpoint ) . ' products' . $elementor_support . ' columns-' . esc_attr( $desktop_breakpoint ) . '">';

}
add_filter( 'woocommerce_product_loop_start', 'woo_product_loop_start', 0 );

/**
 * Construct ending product loop wrapper.
 *
 * @param string $end The loop end output.
 */
function woo_product_loop_end( $end ) {

	/**
	 * Only use this if you 100% know what you are doing.
	 * Allows us and 3rd parties to remove THEMENAMEs WooCommerce product loop wrappers.
	 */
	if ( ! apply_filters( 'woo_product_loop_wrapper', true ) ) {
		return $end;
	}

	return '</ul>';

}
add_filter( 'woocommerce_product_loop_end', 'woo_product_loop_end', 0 );

/**
 * Construct starting product wrapper.
 */
function woo_loop_product_wrap_start() {
	echo '<div class="woo-product-wrapper clearfix">';
}
add_action( 'woocommerce_before_shop_loop_item', 'woo_loop_product_wrap_start', 0 );

/**
 * Construct ending product wrapper.
 */
function woo_loop_product_wrap_end() {
	echo '</div>';
}
add_action( 'woocommerce_after_shop_loop_item', 'woo_loop_product_wrap_end', 100 );

/**
 * Construct starting thumbnail wrapper.
 */
function woo_loop_thumbnail_wrap_start() {

	echo '<div class="woo-loop-thumbnail-wrapper">';
	echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';

}
add_action( 'woocommerce_before_shop_loop_item_title', 'woo_loop_thumbnail_wrap_start', 5 );

/**
 * Construct ending thumbnail wrapper.
 */
function woo_loop_thumbnail_wrap_end() {

	echo '</a>';
	echo '</div>';

}
add_action( 'woocommerce_before_shop_loop_item_title', 'woo_loop_thumbnail_wrap_end', 12 );

/**
 * Remove sale badge from loop.
 */
function woo_loop_remove_sale_badge() {

	$sale_badge_position = get_theme_mod( 'woocommerce_loop_sale_position' );

	if ( $sale_badge_position && 'none' === $sale_badge_position ) {
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
	}

}
add_action( 'wp', 'woo_loop_remove_sale_badge' );

/**
 * Hide WooCommerce page title on archives.
 *
 * @param string $page_title The page title.
 *
 * @return boolean|string Wether to display the page title or not.
 */
function woo_loop_remove_page_title( $page_title ) {

	if ( get_theme_mod( 'woocommerce_loop_remove_page_title' ) ) {
		$page_title = false;
	}

	return $page_title;

}
add_filter( 'woocommerce_show_page_title', 'woo_loop_remove_page_title' );

/**
 * Remove WooCommerce breadcrumbs from shop pages.
 */
function woo_loop_remove_breadcrumbs() {

	if ( get_theme_mod( 'woocommerce_loop_remove_breadcrumbs' ) ) {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

}
add_action( 'wp', 'woo_loop_remove_breadcrumbs' );

/**
 * Remove the results count from shop pages.
 */
function woo_loop_remove_result_count() {

	if ( get_theme_mod( 'woocommerce_loop_remove_result_count' ) ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
	}

}
add_action( 'wp', 'woo_loop_remove_result_count' );

/**
 * Remove the sorting dropdown from shop pages.
 */
function woo_loop_remove_ordering() {

	if ( get_theme_mod( 'woocommerce_loop_remove_ordering' ) ) {
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
	}

}
add_action( 'wp', 'woo_loop_remove_ordering' );

/**
 * Construct out of stock notice.
 */
function woo_loop_out_of_stock() {

	$out_of_stock_notice = get_theme_mod( 'woocommerce_loop_out_of_stock_notice' );

	if ( ! $out_of_stock_notice || 'hide' !== $out_of_stock_notice ) {

		$out_of_stock        = get_post_meta( get_the_ID(), '_stock_status', true );
		$out_of_stock_string = apply_filters( 'woo_loop_out_of_stock_string', __( 'Out of stock', 'TheCreativityArchitect' ) );

		if ( 'outofstock' === $out_of_stock ) {
			echo '<span class="woo-loop-out-of-stock">' . esc_html( $out_of_stock_string ) . '</span>';
		}
	}

}
add_action( 'woocommerce_before_shop_loop_item_title', 'woo_loop_out_of_stock', 11 );

/**
 * Add parent category to loop.
 */
function woo_loop_category() {

	?>
	<span class="woo-product-category">
		<?php
		global $product;
		$categories = function_exists( 'wc_get_product_category_list' ) ? wc_get_product_category_list( get_the_ID(), ',', '', '' ) : $product->get_categories( ',', '', '' );

		$categories = strip_tags( $categories );
		if ( $categories ) {
			list( $category ) = explode( ',', $categories );
			echo esc_html( $category );
		}
		?>
	</span>
	<?php

}

/**
 * Construct loop title.
 */
function woo_loop_title() {

	echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link woocommerce-loop-product__link">';
	echo '<h3 class="woocommerce-loop-product__title">' . get_the_title() . '</h3>';
	echo '</a>';

}

/**
 * Construct loop short description.
 */
function woo_loop_short_description() {

	if ( has_excerpt() ) {
		?>
		<div class="woo-loop-excerpt">
			<?php the_excerpt(); ?>
		</div>
		<?php
	}

}

/**
 * Construct sortable loop content.
 */
function woo_loop_content() {

	$content = get_theme_mod( 'woocommerce_loop_sortable_content', array( 'category', 'title', 'price', 'add_to_cart' ) );

	if ( is_array( $content ) && ! empty( $content ) ) {

		do_action( 'woo_loop_before_summary' );
		echo '<div class="woo-loop-summary">';
		do_action( 'woo_loop_summary_open' );

		foreach ( $content as $value ) {

			switch ( $value ) {
				case 'title':
					do_action( 'woo_loop_before_title' );
					woo_loop_title();
					do_action( 'woo_loop_after_title' );
					break;
				case 'price':
					do_action( 'woo_loop_before_price' );
					woocommerce_template_loop_price();
					do_action( 'woo_loop_after_price' );
					break;
				case 'rating':
					do_action( 'woo_loop_before_rating' );
					woocommerce_template_loop_rating();
					do_action( 'woo_loop_after_rating' );
					break;
				case 'excerpt':
					do_action( 'woo_loop_before_excerpt' );
					woo_loop_short_description();
					do_action( 'woo_loop_after_excerpt' );
					break;
				case 'add_to_cart':
					do_action( 'woo_loop_before_add_to_cart' );
					woocommerce_template_loop_add_to_cart();
					do_action( 'woo_loop_after_add_to_cart' );
					break;
				case 'category':
					do_action( 'woo_loop_before_category' );
					woo_loop_category();
					do_action( 'woo_loop_after_category' );
					break;
				default:
					break;
			}
		}

		do_action( 'woo_loop_summary_close' );
		echo '</div>';
		do_action( 'woo_loop_after_summary' );

	}

}

/**
 * Products per row.
 */
function loop_columns() {

	$products_per_row = json_decode( get_theme_mod( 'woocommerce_loop_products_per_row' ), true );
	$columns          = get_theme_mod_value( $products_per_row, 'desktop', 4, true );

	return $columns;

}
add_filter( 'loop_shop_columns', 'loop_columns' );

/**
 * Current menu item class.
 *
 * Add class to WooCommerce menu item if we're on the cart page.
 *
 * @param string $css_classes The css classes.
 *
 * @return string The updated css classes.
 */
function woo_menu_item_class_current( $css_classes ) {

	if ( is_cart() ) {
		$css_classes .= ' current-menu-item';
	}

	return $css_classes;

}
add_filter( 'woo_menu_item_classes', 'woo_menu_item_class_current' );

/**
 * Construct cart menu item.
 *
 * @param string $markup The markup for the parent container.
 * Defaults to 'li' as it lives inside the main navigation by default.
 *
 * @return string The cart menu item.
 */
function woo_menu_item( $markup = 'li' ) {

	if ( svg_enabled() ) {
		$icon = apply_filters( 'woo_menu_item_icon', svg( 'cart' )  );
	} else {
		$icon = apply_filters( 'woo_menu_item_icon', '<i class="themenamef themenamef-' . esc_attr( get_theme_mod( 'woocommerce_menu_item_icon', 'cart' ) ) . '"></i>' );
	}

	$css_classes = apply_filters( 'woo_menu_item_classes', 'menu-item woo-menu-item' );
	$title       = apply_filters( 'woo_menu_item_title', __( 'Shopping Cart', 'TheCreativityArchitect' ) );
	$cart_count  = WC()->cart->get_cart_contents_count();
	$cart_url    = wc_get_cart_url();

	// Construct.
	$menu_item = '<' . $markup . ' class="' . esc_attr( $css_classes ) . '">';

	$menu_item .= '<a href="' . esc_url( $cart_url ) . '" title="' . esc_attr( $title ) . '">';

	$menu_item .= '<span class="screen-reader-text">' . __( 'Shopping Cart', 'TheCreativityArchitect' ) . '</span>';

	$menu_item .= apply_filters( 'woo_before_menu_item', '' );

	$menu_item .= $icon;

	if ( 'hide' !== get_theme_mod( 'woocommerce_menu_item_count' ) ) {
		$menu_item .= '<span class="woo-menu-item-count">' . wp_kses_data( $cart_count ) . '<span class="screen-reader-text">' . __( 'Items in Cart', 'TheCreativityArchitect' ) . '</span></span>';
	}

	$menu_item .= apply_filters( 'woo_after_menu_item', '' );

	$menu_item .= '</a>';

	$menu_item .= apply_filters( 'woo_menu_item_dropdown', '' );

	$menu_item .= '</' . $markup . '>';

	return $menu_item;

}

/**
 * Add cart menu item to main navigation.
 *
 * @param string $items The HTML list content for the menu items.
 * @param object $args The arguments.
 *
 * @return string The updated HTML.
 */
function woo_menu_icon( $items, $args ) {

	// Stop right here if menu item is hidden.
	if ( 'hide' === get_theme_mod( 'woocommerce_menu_item_desktop' ) ) {
		return $items;
	}

	// Hide if we're on non-WooCommerce pages.
	if ( get_theme_mod( 'woocommerce_menu_item_hide_if_not_wc' ) && ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
		return $items;
	}

	// Stop here if we're on a off canvas menu.
	if ( is_off_canvas_menu() ) {
		return $items;
	}

	// Finally, add menu item to main menu.
	if ( 'main_menu' === $args->theme_location ) {
		$items .= woo_menu_item();
	}

	return $items;

}
add_filter( 'wp_nav_menu_items', 'woo_menu_icon', 10, 2 );

/**
 * Add cart menu item to mobile navigation.
 */
function woo_menu_icon_mobile() {

	// Stop right here if menu item is hidden.
	if ( 'hide' === get_theme_mod( 'woocommerce_menu_item_mobile' ) ) {
		return;
	}

	// Hide if we're on non-WooCommerce pages.
	if ( get_theme_mod( 'woocommerce_menu_item_hide_if_not_wc' ) && ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() ) {
		return;
	}

	// Construct.
	$menu_item  = '<ul class="mobile-nav-item">';
	$menu_item .= woo_menu_item();
	$menu_item .= '</ul>';

	echo $menu_item;

}
add_action( 'before_mobile_toggle', 'woo_menu_icon_mobile' );

/**
 * WooCommerce fragments.
 *
 * @param array $fragments The fragments.
 *
 * @return array The updated fragments.
 */
function woo_fragments( $fragments ) {
	global $woocommerce;

	ob_start();
	echo woo_menu_item();
	$fragments['li.woo-menu-item'] = ob_get_clean();

	ob_start();
	echo woo_menu_item( $markup = 'div' );
	$fragments['div.woo-menu-item'] = ob_get_clean();

	return $fragments;

}
add_filter( 'woocommerce_add_to_cart_fragments', 'woo_fragments' );

/**
 * Prevent redirection inside `woo_single_add_to_cart` ajax request.
 *
 * @param string $location The existing redirection url.
 * @param int    $status The redirection http status.
 *
 * @return string The modified redirection url.
 */
function woo_single_add_to_cart_prevent_redirect( $location, $status ) {

	if ( ! wp_doing_ajax() || ! isset( $_POST['action'] ) || 'woo_single_add_to_cart' !== $_POST['action'] ) {
		return $location;
	}

	return false;

}
add_filter( 'wp_redirect', 'woo_single_add_to_cart_prevent_redirect', 20, 2 );

/**
 * Ajax add to cart on product pages.
 *
 * @see wp-content/plugins/woocommerce/includes/class-wc-form-handler.php
 */
function woo_single_add_to_cart() {

	// If product was successfully added to cart.
	if ( wc_notice_count( 'success' ) > 0 ) {
		$notices = wc_get_notices( 'success' );

		wc_clear_notices();
		wp_send_json_success( $notices );
	} else {
		$notice_notices = wc_get_notices( 'notice' );
		$error_notices  = wc_get_notices( 'error' );
		$notices        = array_merge( $error_notices, $error_notices );

		wc_clear_notices();
		wp_send_json_error( $notices, 401 );
	}

}
add_action( 'wp_ajax_woo_single_add_to_cart', 'woo_single_add_to_cart' );
add_action( 'wp_ajax_nopriv_woo_single_add_to_cart', 'woo_single_add_to_cart' );

/**
 * Add output before quantity input.
 */
function woo_before_quantity_input_field() {
	?>

	<button type="button" class="qty-control qty-decrease">
		<span class="screen-reader-text"><?php _e( 'Decrease quantity', 'TheCreativityArchitect' ); ?></span>
	</button>

	<?php
}

/**
 * Add output after quantity input.
 */
function woo_after_quantity_input_field() {
	?>

	<button type="button" class="qty-control qty-increase">
		<span class="screen-reader-text"><?php _e( 'Increase quantity', 'TheCreativityArchitect' ); ?></span>
	</button>

	<?php
}

/**
 * Add WooCommerce increase decrease button.
 */
function woo_qty_increase_decrease_button() {
	if ( 'hide' === get_theme_mod( 'woocommerce_quantity_buttons', 'show' ) ) {
		return;
	}

	add_action( 'woocommerce_before_quantity_input_field', 'woo_before_quantity_input_field' );
	add_action( 'woocommerce_after_quantity_input_field', 'woo_after_quantity_input_field' );
}
add_action( 'wp', 'woo_qty_increase_decrease_button' );

/**
 * Filter Nested Category Layout for WooCommerce product wrapper classes.
 *
 * @param array $classes The product wrapper classes
 *
 * @return array $classes The updated product wrapper classes
 */
function woo_nested_category_layout_classes( $classes ) {

	$products_per_row   = json_decode( get_theme_mod( 'woocommerce_loop_products_per_row' ), true );
	$desktop_breakpoint = get_theme_mod_value( $products_per_row, 'desktop', 4, true );
	$tablet_breakpoint  = get_theme_mod_value( $products_per_row, 'tablet', 3, true );
	$mobile_breakpoint  = get_theme_mod_value( $products_per_row, 'mobile', 1, true );
	$grid_gap           = get_theme_mod( 'woocommerce_loop_grid_gap', 'large' );

	$classes[] = 'grid grid-' . esc_attr( $grid_gap ) . ' grid-1-' . esc_attr( $mobile_breakpoint ) . ' grid-small-1-' . esc_attr( $tablet_breakpoint ) . ' grid-large-1-' . esc_attr( $desktop_breakpoint );

	return $classes;

}
add_filter( 'wc_nested_category_layout_loop_products_wrapper_classes', 'woo_nested_category_layout_classes' );

/**
 * Disable WooCommere theme support.
 */
function woo_disable_theme_support() {

	if ( get_theme_mod( 'woocommerce_single_disable_gallery_zoom' ) ) {
		remove_theme_support( 'wc-product-gallery-zoom' );
	}

	if ( get_theme_mod( 'woocommerce_single_disable_gallery_slider' ) ) {
		remove_theme_support( 'wc-product-gallery-slider' );
	}

	if ( get_theme_mod( 'woocommerce_single_disable_gallery_lightbox' ) ) {
		remove_theme_support( 'wc-product-gallery-lightbox' );
	}

}
add_action( 'wp', 'woo_disable_theme_support' );
