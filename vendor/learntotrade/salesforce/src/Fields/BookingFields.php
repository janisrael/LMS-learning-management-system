<?php

namespace learntotrade\salesforce\fields;

class BookingFields
{
    /**
     * Associated event lookup field
     */
    const EVENT = 'Event_Name__c';

    /**
     * Event start date (read-only)
     */
    const START_DATE = 'Event_Date__c';

    /**
     * Event end date (read-only)
     */
    const END_DATE = 'Event_End_Date__c';

    /**
     * Person booked onto an event/course
     */
    const DELEGATE = 'Delegate_Name__c';

    /**
     * Name of person booked onto event
     */
    const DELEGATE_NAME = 'Name';

    /**
     * Booking status, e.g. 'Registered', 'Attending', 'Cancelled', 'No Show', etc.
     */
    const STATUS = 'Status__c';

    /**
     * Watch remotely flag - will be true if the booking is for a remote attendance
     */
    const WATCH_REMOTELY = 'Watch_Remotely_Flag__c';

    /**
     * Record type, we want to be using 'Free Seminar Booking'
     */
    const RECORD_TYPE = 'RecordTypeId';

    /**
     * Number of remote video views
     */
    const REMOTE_VIEWS = 'Number_of_Remote_Video_Views__c';
}
