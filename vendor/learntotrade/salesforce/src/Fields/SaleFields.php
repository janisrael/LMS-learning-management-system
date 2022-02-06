<?php

namespace learntotrade\salesforce\fields;

class SaleFields
{
    /**
     * Customer reference - the customer's casesafe ID is stored as the Customer Name on the Sale
     */
    const CUSTOMER = 'Customer_Name__c';

    /**
     * Date of sale
     */
    const DATE = 'Date_of_Sale__c';

    /**
     * Record type - e.g. 'Child Sale', 'Parent Sale' or 'Simple Sale'
     */
    const RECORD_TYPE_ID = 'RecordTypeID';

    /**
     * Associated product
     */
    const PRODUCT = 'Product__c';

    /**
     * Total number of coaching sessions (writeable)
     */
    const SESSIONS = 'Number_of_Coaching_Sessions__c';

    /**
     * Number of remaining sessions (read-only)
     */
    const SESSIONS_REMAINING = 'Coaching_Sessions_Remaining__c';

    /**
     * Number of booked sessions (read-only)
     */
    const SESSIONS_BOOKED = 'Coaching_Sessions_Booked__c';

    /**
     * Number of cancelled sessions (read-only)
     */
    const SESSIONS_CANCELLED = 'Coaching_Sessions_Cancelled__c';

    /**
     * Number of recredited sessions (read-only)
     */
    const SESSIONS_RECREDITED = 'Coaching_Sessions_Recredited__c';

    /**
     * Expiry date of sale for coaching sessions
     */
    const SESSIONS_EXPIRY = 'Coaching_Expiry_Date__c';
}
