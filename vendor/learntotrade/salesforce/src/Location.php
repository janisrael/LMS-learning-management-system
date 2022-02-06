<?php

namespace learntotrade\salesforce;

class Location extends SalesforceObject
{
    protected $name = 'Location__c';

    /**
     * Find locations by name
     *
     * @param string $name
     * @return array
     */
    public function findByName(string $name) : array
    {
        return $this->query(['Id'], ['Name = \'' . addslashes($name) . '\''])['records'];
    }
}
