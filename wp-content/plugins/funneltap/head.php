<?php

if (!defined('ABSPATH')) exit;
global $wp_current_filter;
global $woocommerce;
$page = $wp_current_filter[0];

$browserpush = get_option("funneltap_browserpush");

$orgid = esc_html(get_option("funneltap_org_token"));
$https = get_option("funneltap_viahttps");
$onsitepush = get_option("funneltap_onsitepush");
$current_user = wp_get_current_user();
$um = sanitize_email($current_user->user_email);
$pwa = get_option("funneltap_pwa");
$org_id = get_option("funneltap_orgId");
$org_token = get_option("funneltap_token");
$funneltap_host = funneltap_getFunneltapHost();

function console_log($data)
{
	echo '<script>';
	echo 'console.log(' . json_encode($data) . ')';
	echo '</script>';
}
function funneltap_call($event, $data)
{
	echo '<script>';
	echo 'funneltap(' . '"' . strval($event) . '"' . ', ' . json_encode($data) . ')';
	echo '</script>';
}
echo "<meta property='funneltap:version' content='" . constant('FUNNELTAP_VERSION') . "' />";
echo "\n    <!-- Added by Funneltap Wordpress Plugin -->\n";
if ($pwa) {
	echo "\n    <!-- PWA ENABLED -->\n";
} else {
	echo "\n    <!-- PWA DISABLED -->\n";
}
$onsitepush_val = $onsitepush ? "true" : "false";
echo <<<EOL
<script>
(function(f,n,t,a,p) {
	var x,y;f['FunneltapObject']=p;f[p]=f[p]||function(){
	(f[p].q=f[p].q||[]).push(arguments)},f[p].l=1*new Date();f[p].h=a;x=n.createElement(t),
	y=n.getElementsByTagName(t)[0];x.async=1;x.src=a;y.parentNode.insertBefore(x, y)})
	(window,document,'script','//stageapp.funneltap.ai/funneltap.wl.compressed.js','funneltap');
	funneltap ('configure', '$orgid');
</script>
EOL;
echo "\n    <!-- End Funneltap Integration -->\n\n";

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
include_once(ABSPATH . 'wp-content/plugins/funneltap/common.php');
if (is_plugin_active('woocommerce/woocommerce.php') && (isset($_COOKIE['FUNNELTAP_LEARNER_ID']))) {

	$postid = get_the_ID();
	$price1 = get_post_meta($postid, '_regular_price', true);
	$sale = get_post_meta($postid, '_sale_price');
	$currenturl = get_permalink();
	$amt = WC()->cart->total;
	$cucy = get_woocommerce_currency();
	$cookieID = $_COOKIE['FUNNELTAP_LEARNER_ID'];

	$gcm_path = "/gcm_manifest.json";
	$subpath = "";
	$using_permalinks = get_option("permalink_structure");
	if (!$using_permalinks) {
		/* We are not using permalinks */
		$gcm_path = "/gcm_manifest.json";
		$subpath = "&subpath=/?";
	}

	if (is_checkout() && !is_wc_endpoint_url()) {
		include_once(ABSPATH . 'wp-content/plugins/funneltap/checkout_started.php');
	}
	if (is_product_category()) {
		include_once(ABSPATH . 'wp-content/plugins/funneltap/category_view.php');
	}
	if (is_product()) {
		include_once(ABSPATH . 'wp-content/plugins/funneltap/product_view.php');
		$product = wc_get_product(get_the_ID());
		$productPrice = (!empty($product->get_sale_price())) ? $product->get_sale_price() : $product->get_regular_price();
		$product_details = array(
			'canonicalUrl' => get_permalink(),
			'title' => $product->get_name(),
			'description' =>  $product->get_description(),
			'price' => strval($productPrice),
			'prevPrice' => strval($product->get_regular_price()),
			'productId' => strval($product->get_id()),
			'image' => wp_get_attachment_image_url($product->get_image_id(), 'full'),
			'category' => get_the_terms($product->get_id(), 'product_cat')[0]->name,
			'language' => 'en'
		);
		$event_name = 'index';

		funneltap_call($event_name, $product_details);
	} else {
?>
		<meta property="wg:url" content="<?php echo get_permalink(); ?>" /><?php


																		}
																	}
