<?php

namespace learntotrade\salesforce\fields;

class EventTypeFields
{
    /**
     * Name of event type - this represents a course name
     */
    const NAME = 'Name';

    /**
     * Description of the event type
     */
    const DESCRIPTION = 'Course_Description__c';

    /**
     * Colour used for the event in the interface
     */
    const COLOUR = 'Smartcharts_Colour__c';

    /**
     * ID to the combi item product the event is associated with
     */
    const COMBI_ITEM = 'Combi_Product__c';
}
