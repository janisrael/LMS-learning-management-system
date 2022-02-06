<?php

namespace learntotrade\salesforce\fields;

class EventFields
{
    /**
     * Event type lookup field
     */
    const TYPE = 'Event_Type__c';

    /**
     * Event status
     */
    const STATUS = 'Status__c';

    /**
     * Start date of the event
     */
    const START_DATE = 'Event_Date__c';

    /**
     * End date of the event
     */
    const END_DATE = 'Event_End_Date__c';

    /**
     * Start time of the event
     */
    const START_TIME = 'Start_Time__c';

    /**
     * End time of the event
     */
    const END_TIME = 'End_Time__c';

    /**
     * Region (read-only)
     */
    const REGION = 'Region__c';

    /**
     * Zoom URL - URL to the remote event sessions
     */
    const ZOOM_URL = 'Webinar_URL__c';

    /**
     * Event speaker/presenter (read-only)
     */
    const SPEAKER = 'Speaker__c';

    /**
     * Location
     */
    const LOCATION = 'Location__c';

    /**
     * Event capacity
     */
    const CAPACITY = 'Capacity__c';

    /**
     * Maximum bookings for an event
     */
    const MAX_BOOKINGS = 'Max_Bookings__c';
}
