<?php
/**
 * Storefront engine room
 *
 * @package storefront
 */

/**
 * Assign the Storefront version to a var
 */
$theme              = wp_get_theme( 'storefront' );
$storefront_version = $theme['Version'];

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) ) {
	$content_width = 980; /* pixels */
}

$storefront = (object) array(
	'version' => $storefront_version,

	/**
	 * Initialize all the things.
	 */
	'main'       => require 'inc/class-storefront.php',
	'customizer' => require 'inc/customizer/class-storefront-customizer.php',
);

require 'inc/storefront-functions.php';
require 'inc/storefront-template-hooks.php';
require 'inc/storefront-template-functions.php';

if ( class_exists( 'Jetpack' ) ) {
	$storefront->jetpack = require 'inc/jetpack/class-storefront-jetpack.php';
}

if ( storefront_is_woocommerce_activated() ) {
	$storefront->woocommerce = require 'inc/woocommerce/class-storefront-woocommerce.php';

	require 'inc/woocommerce/storefront-woocommerce-template-hooks.php';
	require 'inc/woocommerce/storefront-woocommerce-template-functions.php';
}

if ( is_admin() ) {
	$storefront->admin = require 'inc/admin/class-storefront-admin.php';
}

/**
 * Note: Do not add any custom code here. Please use a custom plugin so that your customizations aren't lost during updates.
 * https://github.com/woocommerce/theme-customisations
 */













/**
 * @snippet       Remove Sidebar @ Single Product Page for Storefront Theme
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=19572
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 2.5.5
 */
 
add_action( 'get_header', 'bbloomer_remove_storefront_sidebar' );
 
function bbloomer_remove_storefront_sidebar() {
  if ( is_product() ) {
    remove_action( 'storefront_sidebar', 'storefront_get_sidebar', 10 );
  }
}


/**
 * @snippet       Remove Sidebar @ Single Product Page
 * @how-to        Watch tutorial @ https://businessbloomer.com/?p=19055
 * @sourcecode    https://businessbloomer.com/?p=19572
 * @author        Rodolfo Melogli
 * @testedwith    WooCommerce 2.4.12
 */
 
// Remove Sidebar on all the Single Product Pages
 
add_action( 'wp', 'bbloomer_remove_sidebar_product_pages' );
 
function bbloomer_remove_sidebar_product_pages() {
  if (is_product()) {
    remove_action('woocommerce_sidebar','woocommerce_get_sidebar',10);
  }
}



// Mihail add 04-09-2019 - hide categories by ID
/**
 * Remove Categories from WooCommerce Product Category Widget
 *
 * @author   Ren Ventura
 */
//* Used when the widget is displayed as a dropdown - mobile
add_filter( 'woocommerce_product_categories_widget_dropdown_args', 'rv_exclude_wc_widget_categories' );
//* Used when the widget is displayed as a list - desktop
add_filter( 'woocommerce_product_categories_widget_args', 'rv_exclude_wc_widget_categories' );
function rv_exclude_wc_widget_categories( $cat_args ) {
  $cat_args['exclude'] = array('2104','42'); // перечисляем ID категорий, которые скрываем - uncategorized, акции...
  return $cat_args;
}
