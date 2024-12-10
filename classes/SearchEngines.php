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

namespace Jump;

use Jump\Exceptions\ConfigException;

/**
 * Loads and validates the search engines defined in searchengines.json.
 */
class SearchEngines {
    private array $default;
    private string $searchfilelocation;
    private array $loadedsearchengines;

    /**
     * Automatically load searchengines.json on instantiation.
     */
    public function __construct(private Config $config, private Cache $cache, private Language $language) {
        $this->config = $config;
        $this->loadedsearchengines = [];
        $this->searchfilelocation = $this->config->get('searchenginesfile');
        $this->cache = $cache;

        // Retrieve search engines from cache. Load from json file if not cached or
        // the cache has expired.
        $this->loadedsearchengines = $this->cache->load(cachename: 'searchengines', callback: function() {
            return $this->load_search_engines_from_json();
        });

    }
    /**
     * Try to load and validate the list of search engines from searchengines.json.
     *
     * Throws an exception if the file cannot be loaded, is empty, or cannot
     * be decoded to an array.
     *
     * @return array AArray of parsed/validated search engine information from searchengines.json
     * @throws ConfigException If searchengines.json cannot be found.
     */
    private function load_search_engines_from_json(): array {
        $searchengines = [];
        $rawjson = file_get_contents($this->searchfilelocation);
        if ($rawjson === false) {
            throw new ConfigException('There was a problem loading the searchengines.json file');
        }
        if ($rawjson === '') {
            throw new ConfigException('The searchengines.json file is empty');
        }
        // Do some checks to see if the JSON decodes into something
        // like what we expect to see...
        $decodedjson = json_decode($rawjson);

        if (!is_array($decodedjson)) {
            throw new ConfigException('The searchengines.json file is invalid');
        }

        // Build a new array using the values we need...
        foreach ($decodedjson as $item) {
            if (!isset($item->name, $item->url)) {
                throw new ConfigException('The searchengines.json does not contain the "name" or "url" properties');
            }
            $searchengine = new \stdClass();
            $searchengine->name = $item->name;
            $searchengine->url = $item->url;
            $searchengines[] = $searchengine;
        }

        return $searchengines;
    }

    /**
     * Get the list of loaded search engines.
     *
     * @return array Array of parsed/validated search engine information from searchengines.json
     */
    public function get_search_engines() {
        return $this->loadedsearchengines;
    }

    /**
     * Return all the strings to be used by JS on the frontend.
     *
     * @return array
     */
    public function get_strings_for_js(): array {
        $strings = [
            'search' => [
                'search' => $this->language->get('search.search'),
                'sites' => $this->language->get('search.sites'),
            ]
        ];
        foreach ($this->loadedsearchengines as $searchengine) {
            $strings['search']['searchon'][$searchengine->name] = $this->language->get('search.searchon', ['searchprovider' => $searchengine->name]);
        }
        return $strings;
    }
}
