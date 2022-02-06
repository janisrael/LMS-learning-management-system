<?php

namespace learntotrade\salesforce;

use \Illuminate\Support\Facades\Cache as IlluminateCache;

class Cache
{
    public function __call($name, $arguments)
    {
        if (IlluminateCache::getStore() instanceof \Illuminate\Cache\TaggableStore) {
            return IlluminateCache::tags(['salesforce'])->{$name}(...$arguments);
        }

        return IlluminateCache::{$name}(...$arguments);
    }
}
