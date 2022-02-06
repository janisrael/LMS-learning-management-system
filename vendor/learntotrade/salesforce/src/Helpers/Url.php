<?php

namespace learntotrade\salesforce\Helpers;

class Url
{
    /**
     * Prefix a protocol to a URL if one isn't already set
     *
     * @param string $url URL
     * @return string
     */
    public static function addProtocol(string $url) : string
    {
        // Relative URLs can skip the protocol stuff
        if (substr($url, 0, 1) == "/") {
            return $url;
        }

        if (! preg_match('~^(?:f|ht)tps?://~i', $url)) {
            return 'https://' . $url;
        }

        return $url;
    }
}
