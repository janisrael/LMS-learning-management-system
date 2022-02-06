<?php

namespace learntotrade\salesforce\fields;

class IncomeInvoiceFields
{
    /**
     * Reference to subscription the payment has been taken for
     */
    const SUBSCRIPTION = 'Subscription__c';

    /**
     * Currency ISO2 code
     */
    const CURRENCY = 'CurrencyIsoCode';

    /**
     * Date of successful payment
     */
    const SUCCESS_DATE = 'date_of_success_attempt__c';

    /**
     * Success after first attempt - Boolean
     */
    const SUCCESS_AFTER_ATTEMPT_1 = 'success_after_1st_attempt__c';

    /**
     * Success after second attempt - Boolean
     */
    const SUCCESS_AFTER_ATTEMPT_2 = 'success_after_2nd_attempt__c';

    /**
     * Success after third attempt - Boolean
     */
    const SUCCESS_AFTER_ATTEMPT_3 = 'success_after_3rd_attempt__c';
}
