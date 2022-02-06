<?php

namespace learntotrade\salesforce\fields;

class IncomeCardPaymentFields
{
    /**
     * Name
     */
    const NAME = 'Name';

    /**
     * Card token from payment gateway so that card details can be reused
     */
    const CARD_TOKEN = 'Card_Token__c';

    /**
     * Reference to subscription the payment has been taken for
     */
    const SUBSCRIPTION = 'Subscription__c';

    /**
     * Date payment was taken, e.g. '2017-05-11T02:02:15.000+0000'
     */
    const DATE = 'Last_Collection_Date__c';

    /**
     * Date next payment is due
     */
    const NEXT_PAYMENT_DATE = 'RP_Next_Payment_Date__c';

    /**
     * Currency ISO2 code
     */
    const CURRENCY = 'CurrencyIsoCode';
}
