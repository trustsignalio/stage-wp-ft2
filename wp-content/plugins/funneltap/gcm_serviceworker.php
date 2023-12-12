<?php
if (!defined('ABSPATH')) exit;

include_once('lib.php');

header('Content-Type: text/javascript', true, 200);
if (isset($_GET['orgtoken'])) {
	$orgid = sanitize_text_field($_GET['orgtoken']);
} else {
	$orgid = get_option("funneltap_orgId");
}

$pwa = get_option("funneltap_pwa");
if (!$pwa) {
	$pwa = 0;
}
$pwa_files_to_cache = get_option("funneltap_pwaFilesPath");
$funneltap_host = funneltap_getFunneltapHost();

$filesToCache = json_encode(explode(",", $pwa_files_to_cache));
echo <<<EOL
d = new Date();
var cache_key = d.getDate() + "-" + d.getMonth() + "-" + d.getFullYear() + "-" + d.getHours ()
var swUrl = 'https://stageapp.funneltap.ai/funneltap_sw.js';
importScripts(swUrl + "?orgtoken=$orgid&cache_key="+cache_key);
EOL;
