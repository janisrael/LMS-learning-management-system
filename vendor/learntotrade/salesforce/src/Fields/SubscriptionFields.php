<?php

namespace learntotrade\salesforce\fields;

class SubscriptionFields
{
    /**
     * Reference to associated person account
     */
    const PERSON = 'Account__c';

    /**
     * Status of the subscription
     */
    const STATUS = 'Status__c';

    /**
     * Date of cancellation, the status should come back with 'Cancelled' once this has been set
     */
    const CANCELLED_DATE = 'Cancelled_Date__c';

    /**
     * The date of when the status was set to 'pending cancellation'.
     */
    const PENDING_CANCELLATION_DATE = 'pending_cancelled_date__c';

    /**
     * Foreign key to Purchase Option
     */
    const PURCHASE_OPTION = 'Purchase_Option__c';

    /**
     * Foreign key to Combi Product
     */
    const COMBI_PRODUCT = 'Combi_Product__c';

    /**
     * Product status of the subscription
     *
     * - Subscribed
     * - Upgrade
     * - Teaser
     */
    const PRODUCT_STATUS = 'Combi_product_status__c';

    /**
     * Subscription message to show to customer - e.g. sales text relating to a teaser
     */
    const MESSAGE = 'Combi_Product_Message__c';

    /**
     * The price to pay per period for this subscription
     */
    const RECURRING_AMOUNT = 'Monthly_Amount__c';

    /**
     * Status of syncing data from salesforce to chargebee
     */
    const CHARGEBEE_SYNC_STATUS = 'Chargebee_Sync_Status__c';

    /**
     * Linked subscription inside chargebee
     */
    const CHARGEBEE_SUBSCRIPTION_ID = 'Chargebee_Subscription_ID__c';

    /**
     * Date & Time of last status update
     */
    const DATE_MODIFIED_AT = 'Date_Modified_at__c';
}