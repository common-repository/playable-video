<?php
/*
 * Name: Playable Video
 * Section: content
 * Description: Playable Video block
 * 
 */

/* @var $options array */
/* @var $wpdb wpdb */

$default_options = array(
	'code' => '',
    'block_padding_left' => 0,
    'block_padding_right' => 0,
    'block_padding_top' => 0,
    'block_padding_bottom' => 0,
    'block_background' => '#ffffff',
);

$options = array_merge($default_options, $options);

if ($options['code'] !== '') {
	$video = playable_decode_video(substr($options['code'], 10, -1));
	echo $video;
} else {
	// display video placeholder
	echo "<h3>Your video will be displayed here.</h3>";
}
?>