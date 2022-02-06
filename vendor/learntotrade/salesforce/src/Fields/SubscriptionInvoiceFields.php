<?php

namespace learntotrade\salesforce\fields;

class SubscriptionInvoiceFields
{
    /**
     * Invoice name (read-only)
     */
    const NAME = 'Name';

    /**
     * Reference to subscription invoice is for
     */
    const SUBSCRIPTION = 'Subscription__c';

    /**
     * Amount invoice is for
     */
    const AMOUNT = 'Amount__c';

    /**
     * Currency ISO2 code
     */
    const CURRENCY = 'CurrencyIsoCode';

    /**
     * Date invoice issued/created
     */
    const DATE_ISSUED = 'Date_Issued__c';

    /**
     * Date invoice paid - if this field is populated then a successful payment has been made
     */
    const DATE_PAID = 'Date_Paid__c';

    /**
     * Attempt count - the number of times we've attempted to take payment for the invoice
     */
    const ATTEMPT_COUNT = 'Attempt_Count__c';
}
