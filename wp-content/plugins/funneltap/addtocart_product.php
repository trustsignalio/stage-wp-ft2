<?php
if (!defined('ABSPATH')) exit;
global $wp_current_filter;
global $woocommerce;

$page = $wp_current_filter[0];

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
function funneltap_add_to_cart()
{
	if (is_plugin_active('woocommerce/woocommerce.php') && !is_admin()) {
		$wc_cart = WC()->cart;
		if ($wc_cart != NULL) {
			$cart = $wc_cart->get_cart();
		}
		if ($cart != NULL && sizeof($cart) > 0) {
			foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
				$_product = $values['data'];
				$prod_id = $_product->get_id();
				echo "<script>";
				// Here, you need to add one or more Funneltap API methods as per your requirement.   	   		   	   		
				//				echo("\njQuery(document).ready(function($){ \n");
				echo ("\ndocument.addEventListener(\"DOMContentLoaded\", function(event) { \n");
				echo ("\n var wCartItems = localStorage.getItem('funneltap_add_to_cart')\n");
				echo ("var wCartItemFound = false;\n");
				echo ("if (!!wCartItems) {\n");
				echo ("\twCartItems.split(',').forEach(function(wCartItem) {\n");
				echo ("\t\tif (wCartItem == '$prod_id') {\n");
				echo ("\t\t\twCartItemFound = true;\n");
				echo ("\t\t}\t\t\n");
				echo ("\t})\n");
				echo ("}\n");
				echo ("if (!wCartItemFound) {\n");
				echo ("\tvar wNewCartItems = \"$prod_id\";\n");
				echo ("\tif (!!wCartItems) wNewCartItems += \",\" + wCartItems\n");
				echo ("\tfunneltap(\"track\", \"addtocart\", \"$prod_id\");\n");
				echo ("\tlocalStorage.setItem('funneltap_add_to_cart',wNewCartItems)\n");
				echo ("} });");

				echo "</script>";
			}
		}
	}
}
