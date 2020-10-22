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

### Develop
This plugin is entirely custom coded, so development will need to be done on the plugin file.

## Contents
### Composer dependencies
`composer.json`, `composer.lock`, and `vendor/` are used by composer to bundle and process the libraries that this project depends on.
