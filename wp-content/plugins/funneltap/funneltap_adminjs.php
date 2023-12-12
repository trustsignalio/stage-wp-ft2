<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

// include_once ("oauth/oauth_helpers.php.inc");
include_once ("lib.php");

$funneltap_oauth_done = false;

$oauth_token = get_option("funneltap_oauth");
if ($oauth_token) {
    $funneltap_oauth_done = true;
}

if (! $funneltap_oauth_done) {
	include_once("html/funneltap_askoauth.html");
	die ();
}

$clientId = get_option ("funneltap_client_id");
$funneltap_host = funneltap_getFunneltapHost();

$funneltap_app = "Disabled";
if (get_option ("funneltap_enabled")) {
	$funneltap_app = "Enabled";
}
$browser_push = "disabled";
if (get_option ("funneltap_browserpush")) {
    $browser_push = "enabled";
}

$onsite = "disabled";
if (get_option ("funneltap_onsitepush")) {
    $onsite = "enabled";
}

$https = "";
if (get_option ("funneltap_viahttps")) {
    $https = "(over https)";
}
$pwa ="Disabled";
if(get_option("funneltap_pwa")){
	$pwa ="Enabled";
}

include_once ("html/funneltap_settings.html");


