<?php

require( __DIR__ . "/../app/class.php");

$TwitchAutomator = new TwitchAutomator();

$vod = mb_ereg_replace("([^\w\s\d\-_~,;\[\]\(\).])", '', $_GET['vod']);

$vodclass = new TwitchVod();
$vodclass->load( TwitchHelper::vod_folder() . DIRECTORY_SEPARATOR . $vod . '.json');

if( $vodclass->twitch_vod_id ){
	echo 'downloading: ';
	var_dump( $vodclass->downloadChat() );
}

echo 'done';
