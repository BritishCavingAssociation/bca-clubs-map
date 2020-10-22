# bca-clubs-map
WP Plugin: Maps BCA member clubs using open source data

**Note to contributors:** If you would like to correct the location of your club, add or remove a marked location, or make any other change to the map *content*, please make your modifications to `caving_clubs.csv`.

## What is this?


## How to:
### Secure
Don't store API keys hardcoded in the files - store them in the system environment variables or something instead.

### Update
This plugins dependencies are managed with [`Composer`](getcomposer.org), which is installed on the BCAs EC2 instance. To update these dependencies navigate to the plugin directory and run `composer update`.

### Debug
Tips:
* The plugin directory needs to be writable by the web server in order to log errors. The easiest way to do this is to recursively `chown` the plugin directory to the web server user/group (i.e. `apache`) and then recursively `chmod` its permissions to 755.
* You can log more information using the [`v`](https://github.com/BritishCavingAssociation/bca-zoom-endpoint/blob/9c61ce3e16426de50eb144dcf34f1aad46c76f30/bca-zoom-endpoint.php#L15)erbose debug flag.

### Develop
This plugin is entirely custom coded, so development will need to be done on the plugin file ([`bca-clubs-map.php`](https://github.com/BritishCavingAssociation/bca-zoom-endpoint/blob/master/bca-zoom-endpoint.php)).

## Contents
### [`bca-clubs-map.php`](https://github.com/BritishCavingAssociation/bca-zoom-endpoint/blob/master/bca-zoom-endpoint.php)
This is the plugins core code. The function called when a webhook is received is [`delegate_zoom_license_to_next_meeting`](https://github.com/BritishCavingAssociation/bca-zoom-endpoint/blob/9c61ce3e16426de50eb144dcf34f1aad46c76f30/bca-zoom-endpoint.php#L187), and the binding of that function to our custom REST endpoint is at [the bottom of the file](https://github.com/BritishCavingAssociation/bca-zoom-endpoint/blob/9c61ce3e16426de50eb144dcf34f1aad46c76f30/bca-zoom-endpoint.php#L305).
### Composer dependencies
`composer.json`, `composer.lock`, and `vendor/` are used by composer to bundle and process the libraries that this project depends on.
