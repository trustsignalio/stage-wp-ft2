<?php
if (!defined('ABSPATH')) exit;

function funneltap_setoption($option_name, $new_value)
{
	if (get_option($option_name) !== false) {
		update_option($option_name, $new_value);
	} else {
		add_option($option_name, $new_value);
	}
}

function funneltap_getFunneltapHost()
{
	/* Get current Funneltap Host */
	/* Function to check weather we are running in a Development environment,
    file /tmp/funneltapmode only exists in Dev environment */
	if (constant('WPFTHOSTDEV') == true) {
		return "https://stageapp.funneltap.ai";
	} else {
		return "https://app.funneltap.ai";
	}
}

function funneltap_gen_uuid()
{
	return sprintf(
		'%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0x0fff) | 0x4000,
		mt_rand(0, 0x3fff) | 0x8000,
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff),
		mt_rand(0, 0xffff)
	);
}
