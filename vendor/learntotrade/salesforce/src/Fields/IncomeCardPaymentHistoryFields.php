<?php

namespace learntotrade\salesforce\fields;

class IncomeCardPaymentHistoryFields
{
    /**
     * Amount
     */
    const AMOUNT = 'Amount__c';

    /**
     * Currency ISO2 code
     */
    const CURRENCY = 'CurrencyIsoCode';

    /**
     * Status
     */
    const STATUS = 'Payment_Status__c';

    /**
     * Foreign key to the IncomeCardPayment record
     */
    const INCOME_CARD_PAYMENT = 'Income_Card_Payment__c';
}
