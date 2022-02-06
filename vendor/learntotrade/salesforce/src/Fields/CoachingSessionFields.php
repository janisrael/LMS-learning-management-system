<?php

namespace learntotrade\salesforce\fields;

class CoachingSessionFields
{
    /**
     * Date of the session
     */
    const DATE = 'Date__c';

    /**
     * Session start time
     */
    const START_TIME = 'Start_Time__c';

    /**
     * Session end time
     */
    const END_TIME = 'End_Time__c';

    /**
     * Session status - represents whether the session has been booked, cancelled, a no show or
     * attended.
     */
    const STATUS = 'Status__c';

    /**
     * Availability type - represents whether the mentor can do the session in-house, remotely or
     * both.
     */
    const AVAILABILITY_TYPE = 'Availability_Type__c';

    /**
     * The session's coach/mentor
     */
    const COACH = 'Coach__c';

    /**
     * Location of the booked session - remote or in-house.
     */
    const LOCATION = 'Location__c';

    /**
     * Sale associated with the session - we can use this to determine the customer linked to the
     * session.
     */
    const SALE = 'Sale__c';

    /**
     * Zoom URL - URL to the remote video sessions
     */
    const ZOOM_URL = 'Zoom_URL__c';

    /**
     * Name of the customer booked to the session
     */
    const CUSTOMER_NAME = 'Customer__c';
}
