<?php

namespace learntotrade\salesforce;

use Carbon\Carbon;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use learntotrade\salesforce\fields\CombiProductFields;
use learntotrade\salesforce\fields\SubscriptionFields;
use learntotrade\salesforce\Exceptions\SalesforceException;

class Subscription extends SalesforceObject
{
    protected $name = 'Subscription__c';

    /**
     * Returns an array of all the active subscription states for Salesforce
     *
     * @return array
     */
    public static function activeStates() : array
    {
        return [
            'Active',
            'first card payment failed',
            'second card payment failed',
            'third card payment failed',
            'immediate contact needed',
            'Pending Cancellation',
        ];
    }

    /**
     * Create a subscription to the default product
     *
     * @param string $accountId
     * @param string $combiProductId - attempt to use this as the default subscription if a valid record is found
     * @param string|null $affiliate
     * @return string
     */
    public function createDefault(string $accountId, $combiProductId = null)
    {
        $CombiProduct = new CombiProduct($this->client);

        if (!empty($combiProductId)) {
            // Lookup a combi product and in the event of an exception, just assign product to false.
            $product = rescue(function () use ($CombiProduct, $combiProductId) {
                return $CombiProduct->findById($combiProductId);
            }, false);
        }

        // If we've not got an affiliate combi-product or it was an invalid ID, fallback to the default product
        $product = !empty($product) ? $product : $CombiProduct->getDefaultSubscription();

        $data = [
            SubscriptionFields::PERSON => $accountId,
            SubscriptionFields::STATUS => 'Created',
            SubscriptionFields::COMBI_PRODUCT => $product['Id'],
            SubscriptionFields::PRODUCT_STATUS => 'Upgrade',
        ];

        return $this->create($data);
    }

    /**
     * Gets all the upgrade subscriptions for a given account along with the product and pricing.
     *
     * @param string $accountId Person account ID
     * @return array
     */
    public function getUpgradeByAccount(string $accountId) : array
    {
        $query = 'SELECT Id,' . implode(',', $this->getSubscriptionFields()) . ' FROM ' . $this->name;
        $query .= ' WHERE ' . SubscriptionFields::PERSON . ' = \'' . addslashes($accountId) . '\'';
        $query .= ' AND ' . SubscriptionFields::PRODUCT_STATUS . ' = \'Upgrade\'';
        $query .= ' AND ' . SubscriptionFields::STATUS . ' != \'Cancelled\'';
        $query .= ' AND ' . SubscriptionFields::CANCELLED_DATE . ' = NULL';
        $query .= ' AND Combi_Product__r.' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' > 0';

        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $subscriptions = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve subscriptions for account'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        if (empty($subscriptions['records'])) {
            return [];
        }

        $productIds = (new Collection($subscriptions['records']))
            ->pluck(SubscriptionFields::COMBI_PRODUCT, 'Id')
            ->toArray();

        $subscriptionIds = array_flip($productIds);
        $products = (new CombiProduct($this->client))->getSubscriptionsWithPricing($productIds);
        foreach ($products as &$product) {
            $product['subscription'] = $subscriptionIds[$product['Id']];
        }

        return $products;
    }

    /**
     * Gets all the active subscriptions for a given account along with the product and pricing.
     *
     * @param string $accountId Person account ID
     * @return array
     */
    public function getActiveSubscriptions(string $accountId) : array
    {
        $query = 'SELECT Id,' . implode(',', $this->getSubscriptionFields()) . ' FROM ' . $this->name;
        $query .= ' WHERE ' . SubscriptionFields::PERSON . ' = \'' . addslashes($accountId) . '\'';
        $query .= ' AND ' . SubscriptionFields::PRODUCT_STATUS . ' = \'Subscribed\'';
        $query .= ' AND ' . SubscriptionFields::STATUS . ' != \'Cancelled\'';
        $query .= ' AND ' . SubscriptionFields::CANCELLED_DATE . ' = NULL';
        $query .= ' AND Combi_Product__r.' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' > 0';

        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $subscriptions = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve subscriptions for account'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        if (empty($subscriptions['records'])) {
            return [];
        }

        $productIds = (new Collection($subscriptions['records']))
            ->pluck(SubscriptionFields::COMBI_PRODUCT)
            ->toArray();

        return (new CombiProduct($this->client))->getSubscriptionsWithPricing($productIds);
    }

    /**
     * Get all SmartChart subscriptions for the account and their respective statuses.
     *
     * @param string $accountId
     * @return array
     */
    public function getAllSubscriptions(string $accountId) : array
    {
        $key = 'salesforce.subscriptions.all.' . $accountId;

        return $this->cache->remember($key, 1440, function () use ($accountId) { // remember for 24 hours
            $subscriptions = $this->query(
                [
                    'Id',
                    SubscriptionFields::PRODUCT_STATUS,
                    'Combi_Product__r.Id',
                    'Combi_Product__r.' . CombiProductFields::PARENT_PRODUCT,
                ],
                [
                    SubscriptionFields::PERSON . ' = \'' . addslashes($accountId) . '\'',
                    // Exclude any cancelled subscriptions
                    SubscriptionFields::STATUS . ' IN (\'Created\',\'' . implode('\',\'', $this->activeStates()) . '\')',
                    SubscriptionFields::CANCELLED_DATE . ' = NULL',
                    'Combi_Product__r.' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' > 0',
                ]
            )['records'] ?? [];
            $data = [];
            foreach ($subscriptions as $subscription) {
                $data[$subscription['Id']] = [
                    'status' => $subscription[SubscriptionFields::PRODUCT_STATUS],
                    'product' => $subscription['Combi_Product__r'][CombiProductFields::PARENT_PRODUCT] ?: $subscription['Combi_Product__r']['Id'],
                ];
            }

            return $data;
        });
    }

    /**
     * Retrieves an array of subscription fields we are interested in.
     * @return array
     */
    protected function getSubscriptionFields()
    {
        return (new \ReflectionClass(SubscriptionFields::class))->getConstants();
    }

    /**
     * Get a subscription along with it's combi product and purchase option
     *
     * @param string $subscriptionId Salesforce subscription ID
     * @return array
     */
    public function getFull($subscriptionId) : array
    {
        $subscription = $this->get($subscriptionId);
        $subscription['combi_product'] = [];
        $subscription['purchase_option'] = [];
        if (! empty($subscription[SubscriptionFields::COMBI_PRODUCT])) {
            $subscription['combi_product'] = (new CombiProduct($this->client))
            ->get($subscription[SubscriptionFields::COMBI_PRODUCT]);
        }
        if (! empty($subscription[SubscriptionFields::PURCHASE_OPTION])) {
            $subscription['purchase_option'] = (new PurchaseOption($this->client))
            ->get($subscription[SubscriptionFields::PURCHASE_OPTION]);
        }

        return $subscription;
    }

    /**
     * Get all the products available to an Account via its active subscriptions
     *
     * @param string $accountId Salesforce Account ID
     * @return array
     */
    public function getProductIds(string $accountId) : array
    {
        $combiProductIds = $this->getCombiProductIds($accountId, $this->activeStates(), ['Subscribed']);
        if (empty($combiProductIds)) {
            return [];
        }
        $query = 'SELECT Id, Name, (SELECT Product__r.Id FROM Combi_Items__r) FROM Combi_Product__c';
        $query .= ' WHERE Id IN (\'' . implode('\',\'', $combiProductIds) . '\')';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query,
                ],
            ]);
            $products = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to query Combi_Product__c to obtain associated products'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        if (empty($products['records'])) {
            return [];
        }

        return (new Collection($products['records']))->pluck('Combi_Items__r.records.*.Product__r.Id')
            ->flatten()
            ->toArray();
    }

    /**
     * Get the combi products based on relation to a salesforce account - e.g. Only those where the
     * user has an Active subscription
     *
     * @param string $accountId Salesforce Account ID
     * @param array $statuses - An array of subscription statuses
     * @param array $combiProductStatues - An array of combi-product status on a subscription
     * @param array $fields
     * @return array
     */
    public function getCombiProducts(string $accountId, $statuses = [], $combiProductStatuses = [], $fields = []) : array
    {
        $defaultFields = [
            'Combi_Product__r.Id',
            'Subscription__c.Id',
            SubscriptionFields::PRODUCT_STATUS,
            SubscriptionFields::MESSAGE,
        ];
        $conditions = [
            SubscriptionFields::PERSON . ' = \'' . addslashes($accountId) . '\'',
            'Combi_Product__r.' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' > 0',
        ];
        if (! in_array('Cancelled', $statuses)) {
            $conditions[] = SubscriptionFields::CANCELLED_DATE . ' = NULL';
        }
        if (! empty($statuses)) {
            $conditions[] = SubscriptionFields::STATUS . ' IN (\'' . implode('\',\'', $statuses) . '\')';
        }
        if (! empty($combiProductStatuses)) {
            SubscriptionFields::PRODUCT_STATUS . ' IN (\'' . implode('\',\'', $combiProductStatuses) . '\')';
        }

        return $this->query(array_merge($defaultFields, $fields), $conditions)['records'] ?? [];
    }

    /**
     * Backwards-compatible / convenience wrapper for getting combi products based on association with the user
     * and just plucking the IDs for use with subsequent queries
     *
     * @param string $accountId Salesforce Account ID
     * @param  $statuses - An array of subscription statuses
     * @param  $combiProductStatues - An array of combi-product status on a subscription
     * @return array
     */
    public function getCombiProductIds(string $accountId, $statuses = [], $combiProductStatuses = []) : array
    {
        return collect($this->getCombiProducts($accountId, $statuses, $combiProductStatuses))
            ->pluck('Combi_Product__r.Id')
            ->toArray();
    }

    /**
     * Fetches a complete list of all subscriptions belonging to a person account
     * @param  $accountId
     * @return array
     */
    public function findByAccount($accountId) : array
    {
        $query = 'SELECT Id, Combi_Product__r.Name, ' . implode(',', $this->getSubscriptionFields());
        $query .= ' FROM ' . $this->name;
        $query .= ' WHERE ' . SubscriptionFields::PERSON . ' = \'' . addslashes($accountId) . '\'';
        $query .= ' AND Combi_Product__r.' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' > 0';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query,
                ],
            ]);
            $subscriptions = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to query Subscription__c to obtain a list of subscriptions for a Person Account'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        return $subscriptions['records'] ?? [];
    }
    
    /**
     * Fetches a complete list of all updated/unsynced subscriptions by date
     * @param  $accountId
     * @return array
     */
    public function getUpdatedSubscriptionByDate(Carbon $date) {
  
        $query = $this->query([
                'Id',
                SubscriptionFields::STATUS,
                SubscriptionFields::PENDING_CANCELLATION_DATE,
                SubscriptionFields::CHARGEBEE_SYNC_STATUS,
                SubscriptionFields::CHARGEBEE_SUBSCRIPTION_ID,
                SubscriptionFields::DATE_MODIFIED_AT
            ],
            [
                SubscriptionFields::CHARGEBEE_SYNC_STATUS . ' = ' . 'false',
                SubscriptionFields::DATE_MODIFIED_AT . ' >= ' . $date->startOfDay()->format('Y-m-d\TH:i:s.000+0000'),
                SubscriptionFields::DATE_MODIFIED_AT . ' <= ' . $date->endOfDay()->format('Y-m-d\TH:i:s.000+0000')
            ]
        );      

        return $query;
    }
}
