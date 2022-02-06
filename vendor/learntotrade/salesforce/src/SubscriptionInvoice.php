<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use learntotrade\salesforce\fields\PersonFields;
use learntotrade\salesforce\fields\CombiProductFields;
use learntotrade\salesforce\fields\SubscriptionFields;
use learntotrade\salesforce\fields\PurchaseOptionFields;
use learntotrade\salesforce\Exceptions\SalesforceException;
use learntotrade\salesforce\fields\SubscriptionInvoiceFields;

class SubscriptionInvoice extends SalesforceObject
{
    protected $name = 'Subscription_Invoice__c';

    /**
     * Returns an invoice along with details of the subscription, product and customer
     *
     * @param string $invoiceId Invoice ID
     * @return array
     */
    public function details(string $invoiceId) : array
    {
        return $this->query(
            $this->getFields() + Subscription::getFields('Subscription__r')
            + CombiProduct::getFields('Subscription__r.Combi_Product__r')
            + Person::getFields('Subscription__r.Account__r')
            + [
                'Subscription__r.Purchase_Option__r.' . PurchaseOptionFields::MONTHS,
                'Subscription__r.Purchase_Option__r.Name',
            ],
            ['Id = \'' . addslashes($invoiceId) . '\'']
        )['records'][0] ?? [];
    }

    /**
     * Get the account associated with a particular invoice and include the relevant subscription
     * data.
     *
     * @param string $invoiceId Salesforce casesafe ID
     * @return array
     */
    public function getAccount(string $invoiceId) : array
    {
        $accountFields = ['Id'] + (new \ReflectionClass(PersonFields::class))->getConstants();
        $subscriptionFields = (new \ReflectionClass(SubscriptionFields::class))->getConstants();
        $combiProductFields = (new \ReflectionClass(CombiProductFields::class))->getConstants();
        $query = 'SELECT Id, Subscription__r.Account__r.' . implode(',Subscription__r.Account__r.', $accountFields);
        $query .= ',Subscription__r.' . implode(',Subscription__r.', $subscriptionFields);
        $query .= ',Subscription__r.Combi_Product__r.' . implode(',Subscription__r.Combi_Product__r.', $combiProductFields);
        $query .= ' FROM Subscription_Invoice__c';
        $query .= ' WHERE Id = \'' . addslashes($invoiceId) . '\'';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $invoice = json_decode($response->getBody(), true)['records'] ?? [];
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve account for invoice from Salesforce'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }
        $subscription = reset($invoice)['Subscription__r'] ?? [];
        $account = $subscription['Account__r'] ?? [];
        unset($subscription['Account__r']);
        $account['Subscription'] = $subscription ?? [];

        return $account;
    }

    /**
     * Fetches a list of subscription invoices associated with the passed in subscription id(s)
     * @param  array  $subscriptionIds
     * @return array
     */
    public function findBySubscription($subscriptionIds = []) : array
    {
        $query = 'SELECT Id, ' . SubscriptionInvoiceFields::SUBSCRIPTION . ' FROM Subscription_Invoice__c';
        $query .= ' WHERE ' . SubscriptionInvoiceFields::SUBSCRIPTION . ' IN (\'' . implode('\',\'', $subscriptionIds) . '\')';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $subscriptions = json_decode($response->getBody(), true)['records'] ?? [];
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve invoices by subscrition from Salesforce'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        return $subscriptions;
    }
}
