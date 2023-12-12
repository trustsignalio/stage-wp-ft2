<?php
if (!defined('ABSPATH')) exit;

function funneltap_get_auth_token()
{
	global $wpdb;

	$uid = get_option("funneltap_challenge");
	if ($uid == false) {
		$uid = gen_uuid();
		update_option("funneltap_challenge", $uid);
	}
	return $uid;
}
