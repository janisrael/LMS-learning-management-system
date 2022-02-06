<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use learntotrade\salesforce\Exceptions\SalesforceException;
use learntotrade\salesforce\fields\CombiProductFields;
use learntotrade\salesforce\fields\InvoicePaymentAttemptFields;

class InvoicePaymentAttempt extends SalesforceObject
{
    protected $name = 'Invoice_Payment_Attempt__c';

    /**
     * Gets a complete list of payments attempts for a given user - with the latest payments first
     *
     * @param string $accountId Person account ID
     * @return array
     */
    public function findByAccount(string $accountId) : array
    {
        $paymentAttempts = $this->query(
            $this->getFields() + [
                'Subscription_Invoice__r.Subscription__r.Account__r.Id',
                'Subscription_Invoice__r.Subscription__r.Combi_Product__r.' . CombiProductFields::NAME,
            ],
            ['Subscription_Invoice__r.Subscription__r.Account__r.Id  = \'' . addslashes($accountId) . '\''],
            ['order' => InvoicePaymentAttemptFields::DATE . ' DESC, ' . InvoicePaymentAttemptFields::SUCCESSFUL . ' DESC']
        )['records'] ?? [];

        return collect($paymentAttempts)->map(function ($paymentAttempt) {
            return [
                'date' => (new \DateTime($paymentAttempt['Date__c']))->format('j M Y'),
                'amount' => $paymentAttempt['Amount__c'],
                'currency' => $paymentAttempt['CurrencyIsoCode'],
                'subscription' => $paymentAttempt['Subscription_Invoice__r']['Subscription__r']['Combi_Product__r'][CombiProductFields::NAME] ?? null,
                'isSuccessful' => $paymentAttempt['isSuccessful__c'],
                'invoice' => $paymentAttempt[InvoicePaymentAttemptFields::INVOICE]
            ];
        })->toArray();
    }

    /**
     * Fetches a list of invoice payment attempts associated with the passed in invoice id(s)
     * @param  array  $invoiceIds
     * @return array
     */
    public function findByInvoice($invoiceIds = []) : array
    {
        $query = 'SELECT Id,' . implode(',', $this->getInvoicePaymentAttemptFields());
        $query .= ' FROM ' . $this->name;
        $query .= ' WHERE ' . InvoicePaymentAttemptFields::INVOICE . ' IN (\'' . implode('\',\'', $invoiceIds) . '\')';
        $query .= ' ORDER BY ' . InvoicePaymentAttemptFields::DATE . ' DESC';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $paymentAttempts = json_decode($response->getBody(), true)['records'] ?? [];
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve invoice payment attempts from Salesforce'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        return $paymentAttempts;
    }

    /**
     * Retrieves an array of invoice payment fields we are interested in.
     * @return array
     */
    protected function getInvoicePaymentAttemptFields()
    {
        return (new \ReflectionClass(InvoicePaymentAttemptFields::class))->getConstants();
    }
}
