<?php
/**
 * Plugin Name: BCA Clubs Map
 * Description: Provides a shortcode that displays BCA clubs on a Leaflet map
 * Plugin URI: https://github.com/BritishCavingAssociation/bca-clubs-map
 * Author: Ari Cooper-Davis
 * Licence: Unlicense
 * Licence URI: https://unlicense.org
 */

// This should be uncommented in production
defined( 'ABSPATH' ) or die();

$v = False;

// Shortcodes

function display_clubs_map() {
  /* This is the function called when the shortcode is used; it just registers
     the leaflet overheads, the leaflet code we've written, and returns a
     single div */

  // Start buffering output
  ob_start();
  echo '<div id="mapid" style="height: 50rem;"></div>';

  // Fetch clubs data
  $clubs_data_str = file_get_contents(plugins_url('caving_clubs.csv',__FILE__));

  ?>

  <!-- Load leaflet style -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
  integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
  crossorigin=""/>

  <!-- Load leaflet script -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
  integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
  crossorigin=""></script>

  <!-- Build our leaflet map -->
  <script>

    // Setup base map
    var mymap = L.map('mapid').setView([51.505, -0.09], 13);

    // Setup map tiles
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
      attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, <a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
      maxZoom: 18,
      id: 'mapbox/streets-v11',
      tileSize: 512,
      zoomOffset: -1,
      accessToken: 'pk.eyJ1IjoiYXJpY29vcGVyZGF2aXMiLCJhIjoiY2p4YnBvc3Z3MDBodjQydGw3cHNmNWxycSJ9.IuUoWUeuAqVz4bSos8gOqA'
    }).addTo(mymap);

    // Setup icons
    const icons = {
      centre : null,
      club : null,
      hut : null,
      meet: null,
      scouts : null
    };

    for (const icon in icons) {
      icons[icon] = L.icon({
        iconSize: [32, 32],
        iconAnchor: [16, 16],
        popupAnchor: [0, -16],
        iconUrl:  '<?php echo plugins_url('/images/',__FILE__); ?>' + icon + '.png'
      });
    };

    // Get clubs data
    var clubs_data = <?php echo json_encode($clubs_data); ?>;
    // console.log(clubs_data);

    // Create FeatureGroup for markers and areas
    var circles_lg = L.featureGroup();
    var markers_lg = L.featureGroup();

    // Add markers to map
    for (const club in clubs_data) {
      if (clubs_data[club][4] == "") {
        continue;
      } else if (clubs_data[club][4].toLowerCase() == "area") {
        var a = L.circle([parseFloat(clubs_data[club][2]), parseFloat(clubs_data[club][3])], {color: 'orange', fillColor: 'orange', fillOpacity: 0.5, radius: 10000});
        a.addTo(circles_lg);
      } else {
        var a = L.marker([parseFloat(clubs_data[club][2]), parseFloat(clubs_data[club][3])], {icon: icons[clubs_data[club][4].toLowerCase()]});
        a.addTo(markers_lg);
      };
      var popup = "<b>"+clubs_data[club][0]+"</b>";
      if (clubs_data[club][1] != "") {
        popup += "<br><a href="+clubs_data[club][1]+">"+clubs_data[club][1]+"</a>";
      }
      a.bindPopup(popup);
    };
    circles_lg.addTo(mymap);
    markers_lg.addTo(mymap);
    mymap.fitBounds(markers_lg.getBounds());

  </script>

  <?php

  // End buffering output and return
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}
add_shortcode('clubs_map', 'display_clubs_map');

?>
