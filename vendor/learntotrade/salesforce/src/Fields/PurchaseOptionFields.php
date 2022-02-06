<?php

namespace learntotrade\salesforce\fields;

class PurchaseOptionFields
{
    /**
     * Name
     */
    const NAME = 'Name';

    /**
     * Price
     */
    const PRICE = 'Price__c';

    /**
     * Sale price
     */
    const SALE_PRICE = 'Sale_Price__c';

    /**
     * CombiProduct foreign key
     */
    const COMBI_PRODUCT_ID = 'Combi_Product__c';

    /**
     * Product for coaching sessions
     */
    const COACHING_SESSION_PRODUCT_ID = 'Coaching_Session_Product__c';

    /**
     * The number of months that are being purchased
     */
    const MONTHS = 'Purchase_Option_Number__c';

    /**
     * The number of months that are being purchased
     */
    const CHARGEBEE_PLAN_ID = 'Chargebee_Plan_ID__c';
}
