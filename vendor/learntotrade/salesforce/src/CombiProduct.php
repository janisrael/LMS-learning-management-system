<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use learntotrade\salesforce\Helpers\Url;
use learntotrade\salesforce\fields\CombiProductFields;
use learntotrade\salesforce\Exceptions\SalesforceException;

class CombiProduct extends SalesforceObject
{
    protected $name = 'Combi_Product__c';

    /**
     * Get the default subscription (e.g. Learn Forex)
     *
     * @return array
     */
    public function getDefaultSubscription() : array
    {
        return $this->findById(config('salesforce.default_subscription'));
    }

    /**
     * Find a CombiProduct record from salesforce by ID
     *
     * @return array
     */
    public function findById($id)
    {
        $fields = (new \ReflectionClass(CombiProductFields::class))->getConstants();
        $query = 'SELECT Id,' . implode(',', $fields) . ' FROM Combi_Product__c';
        $query .= ' WHERE Id = \'' . addslashes($id) . '\'';

        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $products = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve default subscription'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        return $products['records'][0] ?? [];
    }

    /**
     * Find all subscription combi products
     *
     * @param array $productIds Optional combi product IDs
     * @return array
     */
    public function getSubscriptions(array $productIds = []) : array
    {
        $fields = (new \ReflectionClass(CombiProductFields::class))->getConstants();
        $query = 'SELECT Id,' . implode(',', $fields) . ' FROM Combi_Product__c';
        // Only combi products with a value set for the FXBLUE_SUBSCRIPTION represent the
        // subscription products we want, as it is a decimal field we need to check it's value is
        // greater than zero.
        $query .= ' WHERE ' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' > 0';
        if (! empty($productIds)) {
            $query .= ' AND ID IN (\'' . implode('\',\'', $productIds) . '\')';
        }
        $query .= ' ORDER BY ' . CombiProductFields::FXBLUE_SUBSCRIPTION . ' ASC';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $products = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to retrieve subscriptions from Combi_Product__c Salesforce object');
        }

        foreach ($products['records'] as &$product) {
            if (!empty($product[CombiProductFields::VIDEO_URL])) {
                $product[CombiProductFields::VIDEO_URL] = Url::addProtocol($product[CombiProductFields::VIDEO_URL]);
            }

            if (!empty($product[CombiProductFields::IMAGE_URL])) {
                $product[CombiProductFields::IMAGE_URL] = Url::addProtocol($product[CombiProductFields::IMAGE_URL]);
            }
        }

        return $products;
    }

    /**
     * Find all subscription combi products with associated pricing
     *
     * @param array $productIds Optional combi product IDs
     * @return array
     */
    public function getSubscriptionsWithPricing(array $productIds = []) : array
    {
        $subscriptions = $this->getSubscriptions($productIds)['records'] ?? null;

        if (empty($subscriptions)) {
            return [];
        }
        $ids = (new Collection($subscriptions))->pluck('Id');
        $pricing = (new PurchaseOption($this->client))->findByIds($ids->toArray());
        foreach ($subscriptions as &$subscription) {
            $subscription['pricing'] = $pricing[$subscription['Id']] ?? [];
        }

        // Filter out any with no pricing options found
        return array_filter($subscriptions, function ($subscription) {
            return !empty($subscription['pricing']);
        });
    }
}
