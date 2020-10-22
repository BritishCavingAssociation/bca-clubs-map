<?php
/**
 * Plugin Name: BCA Clubs Map
 * Description: Provides a shortcode that displays BCA clubs on a Leaflet map
 * Plugin URI: https://github.com/BritishCavingAssociation/bca-clubs-map
 * Author: Ari Cooper-Davis
 * Licence: Unlicense
 * Licence URI: https://unlicense.org
 */

// Some generic plugin stuff to make life easier
defined( 'ABSPATH' ) or die();

$v = False;

if ( is_readable( __DIR__ . '/vendor/autoload.php' ) ) {
    require __DIR__ . '/vendor/autoload.php';
}

function logf( $log ) {
  /* A simple logger that doesn't depend on external error/log handlers */
	file_put_contents(__DIR__ . '/log_'.date("j.n.Y").'.log', date("H:i:s").$log."\r\n", FILE_APPEND);
}

// Register leaflet without fetching it until needed
function register_leaflet() {
  wp_register_style('leaflet_style', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.css');
  wp_register_script('leaflet_script', 'https://unpkg.com/leaflet@1.7.1/dist/leaflet.js');
}
add_action('wp_enqueue_scripts', 'register_leaflet');

// Shortcodes

function display_clubs_map($atts) {
  /* This is the function called when the shortcode is used */

  // Fetch leaflet
  wp_enqueue_style('leaflet_style');
  wp_enqueue_script('leaflet_script');

  $raw_data_url = 'https://gitcdn.xyz/repo/BritishCavingAssociation/bca-clubs-map/master/caving_clubs.csv';

  return '<p>There should be a map here</p>';
}
add_shortcode('clubs_map', 'display_clubs_map');

?>
