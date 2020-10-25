# bca-clubs-map
WP Plugin: Maps BCA member clubs using open source data

**Note to contributors:** If you would like to correct the location of your club, add or remove a marked location, or make any other change to the map *content*, please make your modifications to `caving_clubs.csv`.

## What is this?
This is a wordpress plugin that makes the shortcode `[clubs-map]` available, which renders a map of BCA member clubs, visible [on the BCA website](https://british-caving.org.uk/about-bca/caving-clubs/).

## How to:
### Secure
Don't store API keys hardcoded in the files - store them in the system environment variables or something instead.

### Update
The leaflet scripts and styles are fetched each time the map is rendered, so the custom code in bca-clubs-map.php is the only code that needs updating, and it must be updated manually.

### Debug
Tips:
* The plugin directory needs to be writable by the web server in order to log errors. The easiest way to do this is to recursively `chown` the plugin directory to the web server user/group (i.e. `apache`) and then recursively `chmod` its permissions to 755.

### Develop
This plugin is entirely custom coded, so development will need to be done on the plugin file.

## Contents
### `images/`
Contains the images used as marker icons.
### `caving_clubs.csv`
A CSV file of a club, its web address, and (if available) its coordinates and what those coordinates point to.
### `bca-clubs-map.php`
The plugin code.
