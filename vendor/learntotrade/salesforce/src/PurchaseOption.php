<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use learntotrade\salesforce\Exceptions\SalesforceException;
use learntotrade\salesforce\fields\PurchaseOptionFields;

class PurchaseOption extends SalesforceObject
{
    protected $name = 'Purchase_Option__c';

    /**
     * Find all purchase options grouped by CombiProduct ID
     *
     * @param int|array $combiProductIds CombiProduct IDs
     * @return array
     */
    public function findByIds($combiProductIds) : array
    {
        $fields = (new \ReflectionClass(PurchaseOptionFields::class))->getConstants();
        $query = 'SELECT Id,' . implode(',', $fields) . ' FROM Purchase_Option__c';
        $query .= ' WHERE ' . PurchaseOptionFields::COMBI_PRODUCT_ID . ' IN (\'' . implode('\',\'', (array)$combiProductIds) . '\')';
        $query .= ' ORDER BY ' . PurchaseOptionFields::PRICE . ' ASC';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $options = json_decode($response->getBody(), true)['records'] ?? [];
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve purchase options from Salesforce'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }
        $data = [];
        foreach ($options as $option) {
            $data[$option[PurchaseOptionFields::COMBI_PRODUCT_ID]][] = $option;
        }

        return $data;
    }
}
