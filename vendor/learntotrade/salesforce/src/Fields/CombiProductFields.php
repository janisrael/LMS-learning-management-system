<?php

namespace learntotrade\salesforce\fields;

class CombiProductFields
{
    /**
     * Reference to FX Blue subscription (not to be confused with the Subscriptions object in
     * Salesforce). This is a numeric value.
     */
    const FXBLUE_SUBSCRIPTION = 'Subscription_ID__c';

    /**
     * Product name
     */
    const NAME = 'Name';

    /**
     * Product description
     */
    const DESCRIPTION = 'Subscription_Description__c';

    /**
     * Image URL
     */
    const IMAGE_URL = 'Subscription_Image_URL__c';

    /**
     * Video URL
     */
    const VIDEO_URL = 'Subscription_Video_URL__c';

    /**
     * Reference to a parent combi product - used by affiliate products to link to the related
     * product.
     */
    const PARENT_PRODUCT = 'Parent_Combi_Product__c';
}
