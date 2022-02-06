<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use learntotrade\salesforce\fields\SaleFields;
use learntotrade\salesforce\fields\ProductFields;
use learntotrade\salesforce\fields\PurchaseOptionFields;
use learntotrade\salesforce\Exceptions\SalesforceException;
use Carbon\Carbon;

class Sale extends SalesforceObject
{
    protected $name = 'Sale__c';

    /**
     * Find sales by products
     *
     * @param string $accountId Salesforce Account Casesafe ID
     * @param array $productIds Product IDs
     * @return array
     */
    public function findByProducts($accountId, array $productIds) : array
    {
        $fields = (new \ReflectionClass(SaleFields::class))->getConstants();
        $query = 'SELECT Id,' . implode(',', $fields) . ' FROM Sale__c';
        $query .= ' WHERE ' . SaleFields::CUSTOMER . ' = \'' . addslashes($accountId) . '\'';
        $query .= ' AND ' . SaleFields::PRODUCT . ' IN (\'' . implode('\',\'', $productIds) . '\')';
        $query .= ' ORDER BY ' . SaleFields::SESSIONS_EXPIRY . ' DESC';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query,
                ],
            ]);
            $sales = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to query Sale__c Salesforce object'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }
        if (empty($sales['totalSize']) || $sales['totalSize'] < 1) {
            return [];
        }

        return $sales;
    }

    /**
     * Generates a new coaching session sale from a purchase option for a customer
     *
     * @param string $accountId Salesforce Account Casesafe ID
     * @param string $purchaseOptionId Salesforce Purchase Option Casesafe ID
     * @return string|bool|void The ID of the sale, null if no sale to be generated or false if there was an issue
     */
    public function generateCoachingSessionSale(string $accountId, string $purchaseOptionId)
    {
        $purchaseOption = resolve(PurchaseOption::class)->get($purchaseOptionId);
        if (empty($purchaseOption[PurchaseOptionFields::COACHING_SESSION_PRODUCT_ID])) {
            return null;
        }

        $productId = $purchaseOption[PurchaseOptionFields::COACHING_SESSION_PRODUCT_ID];
        $product = (new Product($this->client))->get($productId);
        if (empty($product)) {
            return false;
        }

        $sale = [
            SaleFields::CUSTOMER => $accountId,
            // Salesforce requires that we create a 'child sale' here as we have no booking.
            SaleFields::RECORD_TYPE_ID => $this->findRecordType('Child Sale', 'Sale__c'),
            SaleFields::PRODUCT => $productId,
            SaleFields::SESSIONS => $product[ProductFields::COACHING_SESSIONS] ?? 0,
            SaleFields::DATE => date('Y-m-d'),
        ];
        if (! empty($purchaseOption[PurchaseOptionFields::MONTHS])) {
            $sale[SaleFields::SESSIONS_EXPIRY] = Carbon::now()
                ->addMonths($purchaseOption[PurchaseOptionFields::MONTHS])
                ->format('Y-m-d');
        }

        return $this->create($sale);
    }
}
