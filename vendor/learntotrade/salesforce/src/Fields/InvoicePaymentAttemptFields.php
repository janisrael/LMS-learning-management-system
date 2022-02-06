<?php

namespace learntotrade\salesforce\fields;

class InvoicePaymentAttemptFields
{
    /**
     * Reference to subscription invoice the payment has been taken for
     */
    const INVOICE = 'Subscription_Invoice__c';

    /**
     * Payment amount
     */
    const AMOUNT = 'Amount__c';

    /**
     * Currency ISO2 code
     */
    const CURRENCY = 'CurrencyIsoCode';

    /**
     * Date of payment attempt
     */
    const DATE = 'Date__c';

    /**
     * Success flag
     */
    const SUCCESSFUL = 'isSuccessful__c';

    /**
     * Transaction ID from payment gateway
     */
    const TRANSACTION_ID = 'Transaction_Id__c';
}
