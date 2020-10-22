<?php
/**
 * Plugin Name: BCA Zoom Endpoint
 * Description: Listen for Zoom webhooks and reallocate licenses to upcoming meetings
 * Plugin URI: https://github.com/BritishCavingAssociation/bca-zoom-endpoint
 * Author: Ari Cooper-Davis
 * Licence: Unlicense
 * Licence URI: https://unlicense.org
 */

// Don't access this file directly
defined( 'ABSPATH' ) or die();

// Debugging flag
$v = False;

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

function logf( $log ) {
	file_put_contents(__DIR__ . '/log_'.date("j.n.Y").'.log', date("H:i:s").$log."\r\n", FILE_APPEND);
}

// Shortcodes

function display_clubs_map($atts) {
/*  */

  // Parse attributes
  $b = shortcode_atts( array(
    'disabled' => 0,
  ), $atts);

  return '<p>There should be a map here</p>';
}
add_shortcode('clubs_map', 'display_clubs_map');

?>
