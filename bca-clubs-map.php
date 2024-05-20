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
defined('ABSPATH') or die();

$v = False;

/**
 * Display a leaflet map of the caving clubs (where possible)
 */
function display_clubs_map()
{

  // Start buffering output
  ob_start();
  echo '<div id="mapid" style="height: 50rem;"></div>';

  // Fetch clubs data
  $clubs_data_str = file_get_contents(plugins_url('caving_clubs.csv', __FILE__));
  $clubs_data = array_slice(array_map('str_getcsv', explode("\n", $clubs_data_str)), 1, -1);

?>

  <!-- Load leaflet style -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A==" crossorigin="" />

  <!-- Load leaflet script -->
  <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js" integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA==" crossorigin=""></script>

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
      accessToken: 'pk.eyJ1IjoiYXJpY29vcGVyZGF2aXMiLCJhIjoiY2xydGM4cHJ5MDU0MDJqcGI5ZzQ5a3VudyJ9.IEHn7scX7fL7RpvtSNcmIw'
    }).addTo(mymap);

    // Setup icons
    const icons = {
      centre: null,
      club: null,
      hut: null,
      meet: null,
      scouts: null
    };

    for (const icon in icons) {
      icons[icon] = L.icon({
        iconSize: [32, 32],
        iconAnchor: [16, 16],
        popupAnchor: [0, -16],
        iconUrl: '<?php echo plugins_url('/images/', __FILE__); ?>' + icon + '.png'
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
      try {
        if ((clubs_data[club][0] === null) || clubs_data[club][0].startsWith('#')) {
          continue
        } else if (clubs_data[club][4] == "") {
          continue;
        } else if (clubs_data[club][4].toLowerCase() == "area") {
          var a = L.circle([parseFloat(clubs_data[club][2]), parseFloat(clubs_data[club][3])], {
            color: 'orange',
            fillColor: 'orange',
            fillOpacity: 0.5,
            radius: 10000
          });
          a.addTo(circles_lg);
        } else {
          var a = L.marker([parseFloat(clubs_data[club][2]), parseFloat(clubs_data[club][3])], {
            icon: icons[clubs_data[club][4].toLowerCase()]
          });
          a.addTo(markers_lg);
        };
        var popup = "<b>" + clubs_data[club][0] + "</b>";
        if (clubs_data[club][1] != "") {
          popup += "<br><a href=" + clubs_data[club][1] + ">" + clubs_data[club][1] + "</a>";
        }
        a.bindPopup(popup);
      } catch (error) {
        console.log(error);
        continue;
      }
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

/**
 * Display bulleted list of clubs
 */
function display_clubs_list()
{

  // Fetch clubs data
  $clubs_data_str = file_get_contents(plugins_url('caving_clubs.csv', __FILE__));
  $clubs_data = array_slice(array_map('str_getcsv', explode("\n", $clubs_data_str)), 1, -1);

  // Start buffering output
  ob_start();
  echo '<ul class="clubsList">';

  $alphabet = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');

  foreach ($alphabet as $a) {
    // prepare first-letter headings
    echo <<<EOD
<li>
    <strong>{$a}</strong>
    <ul>
EOD;
    $_last_club = '';
    foreach ($clubs_data as $club) {
      // list each club once only
      if ($club[0] == $_last_club) {
        continue;
      } else {
        $_last_club = $club[0];
      }
      // don't list "commented" clubs
      $init = substr($club[0], 0, 1);
      if ($init == '#' || $init < $a) {
        continue;
      } else if ($init > $a) {
        break;
      } else if ($init == $a) {
        // prepare club entry
        $club_el = ($club[1] ? "<a href='{$club[1]}'>{$club[0]}</a>" : $club[0]);
        echo <<<EOD
  <li>
    {$club_el}
  </li>
  EOD;
      }
    }
    echo <<<'EOD'
    </ul>
</li>
EOD;
  }

  echo '</ul>';

  // End buffering output and return
  $output = ob_get_contents();
  ob_end_clean();
  return $output;
}
add_shortcode('clubs_list', 'display_clubs_list');

?>