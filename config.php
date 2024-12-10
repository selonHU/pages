<?php
/**
 *      ██ ██    ██ ███    ███ ██████
 *      ██ ██    ██ ████  ████ ██   ██
 *      ██ ██    ██ ██ ████ ██ ██████
 * ██   ██ ██    ██ ██  ██  ██ ██
 *  █████   ██████  ██      ██ ██
 *
 * @author Dale Davies <dale@daledavies.co.uk>
 * @copyright Copyright (c) 2022, Dale Davies
 * @license MIT
 */

/**
 * Edit the configuration below to suit your requirements.
 */
return [
    // The site name is displayed in the browser tab.
    'sitename'       => getenv('SITENAME')       ?:   'Jump',
    // Where on the this code is located.
    'wwwroot'        => getenv('WWWROOT')        ?:   '/var/www/html',
    // Site URL - might help if just is hosted in a subdirectory.
    'wwwurl'         => getenv('WWWURL')         ?:   'https://selonhu.github.io/pages/',
    // The language Jump should use for strings, uses ISO 639-1 language codes.
    'language'       => getenv('LANGUAGE')       ?:   'en-gb',

    // Stop retrieving items from the cache, useful for testing.
    'cachebypass'    => getenv('CACHEBYPASS')    ?:   false,
    // Where is the cache storage directory, should not be public.
    'cachedir'       => getenv('CACHEDIR')       ?:   '/var/www/cache',

    // Soemthing not working? Set this to "true" to display detailed
    // debugging information.
    'debug'          => getenv('DEBUG')          ?:   false,

    // Display alternative layout of sites list.
    'altlayout'      => getenv('ALTLAYOUT')      ?:   false,
    // Should the clock be displayed?
    'showclock'      => getenv('SHOWCLOCK')      ?:   true,
    // 12 hour clock format?
    'ampmclock'      => getenv('AMPMCLOCK')      ?:   false,
    // Show a friendly greeting message rather than "#home", defaults to a dynamic
    // greeting based on time of day. E.g Good Morning.
    'showgreeting'   => getenv('SHOWGREETING')   ?:   true,
    // Custom greeting string as alternative to built-in friendy greeting.
    'customgreeting' => getenv('CUSTOMGREETING') ?:   '',
    // Show the search bar, requires /search/searchengines.json etc.
    'showsearch'     => getenv('SHOWSEARCH')     ?:   true,
    // Include the robots noindex meta tag in site header.
    'noindex'        => getenv('NOINDEX')        ?:   true,

    // Background blur percentage.
    'bgblur'         => (getenv('BGBLUR') !== false) ? getenv('BGBLUR') : '70',
    // Background brightness percentage.
    'bgbright'       => (getenv('BGBRIGHT') !== false) ? getenv('BGBRIGHT') :   '85',
    // Unsplash API key, when added will use Unsplash background images.
    'unsplashapikey' => getenv('UNSPLASHAPIKEY') ?:   false,
    // Unsplash collection name to pick random image from.
    'unsplashcollections' => getenv('UNSPLASHCOLLECTIONS') ?: '',
    // Alternative background image provider.
    'altbgprovider'  => getenv('ALTBGPROVIDER')  ?:   false,
    // Custom page width.
    'customwidth'    => getenv('CUSTOMWIDTH')    ?:   false,

    // Open Weather Map API key.
    'owmapikey'      => getenv('OWMAPIKEY')      ?:   '',
    // Coordinates for weather location. E.g. 51.509865,-0.118092
    'latlong'        => getenv('LATLONG')        ?:   '',
    // Temperature unit: True = metric / False = imperial.
    'metrictemp'     => getenv('METRICTEMP')     ?:   true,

    // Ping sites to determine availability (e.g. online, offline, errors).
    'checkstatus'    => getenv('CHECKSTATUS')    ?:   true,
    // Duration to cache status in minutes.
    'statuscache'    => getenv('STATUSCACHE')    ?:   '5',

    // Only try to look for sites via Docker rather than first trying to load
    // the sites.json file.
    'dockeronlysites' => getenv('DOCKERONLYSITES') ?: false,
    // The URL and port on which a docker socket proxy is listening, for example
    // if you have tecnativa/docker-socket-proxy named dockerproxy listening on
    // port 2375 then this would be "dockerproxy:2375".
    'dockerproxyurl' => getenv('DOCKERPROXYURL') ?:   false,
    // Docker socket path. Note the host docker socket file must be mapped as
    // a volume into the container, this must match the path it has been mapped to.
    // If possible please don't use this as it can be insecure, use a docker socket
    // proxy instead (see above).
    'dockersocket'   => getenv('DOCKERSOCKET')   ?:   false
];
