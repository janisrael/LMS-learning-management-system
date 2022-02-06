<?php

namespace learntotrade\salesforce;

use learntotrade\salesforce\Sale;
use learntotrade\salesforce\Subscription;

class Account
{
    protected $client;

    protected $accountId;

    protected $person;

    /**
     * Constructor
     *
     * @param \learntotrade\salesforce\Client $client Salesforce client
     * @param string $accountId Salesforce Account ID
     */
    public function __construct(Client $client, string $accountId)
    {
        $this->client = $client;
        $this->accountId = $accountId;
        $this->person = new Person($client);
    }

    /**
     * Get the account data from Salesforce
     *
     * @return array
     */
    public function get() : array
    {
        return $this->person->get($this->accountId);
    }

    /**
     * Get all the sales that belong to the account
     *
     * @return array
     */
    public function getSales() : array
    {
        $products = (new Subscription($this->client))->getProductIds($this->accountId);
        if (empty($products)) {
            return [];
        }

        return (new Sale($this->client))->findByProducts($this->accountId, $products);
    }
}
