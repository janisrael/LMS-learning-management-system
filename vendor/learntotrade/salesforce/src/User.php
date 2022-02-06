<?php

namespace learntotrade\salesforce;

class User extends SalesforceObject
{
    protected $name = 'User';

    /**
     * Find users by name
     *
     * @param string $name
     * @return array
     */
    public function findByName(string $name) : array
    {
        return $this->query($this->getFields(), ['Name = \'' . addslashes($name) . '\''])['records'];
    }
}
