<?php

namespace learntotrade\salesforce;

use Illuminate\Support\Carbon;
use learntotrade\salesforce\Booking;
use learntotrade\salesforce\fields\EventFields;
use learntotrade\salesforce\fields\PersonFields;
use learntotrade\salesforce\fields\BookingFields;
use learntotrade\salesforce\fields\LocationFields;
use learntotrade\salesforce\fields\EventTypeFields;
use learntotrade\salesforce\fields\CombiProductFields;
use learntotrade\salesforce\fields\SubscriptionFields;
use learntotrade\salesforce\Exceptions\SalesforceException;

class Event extends SalesforceObject
{
    protected $name = 'Event__c';

    /**
     * Gets the details of an event
     *
     * @param string $eventId Salesforce event ID
     * @return array
     */
    public function details(string $eventId) : array
    {
        $event = $this->query(
            $this->getFields() + [
                'Event_Type__r.' . EventTypeFields::NAME,
                'Event_Type__r.' . EventTypeFields::DESCRIPTION,
                'Location__r.' . LocationFields::CAPACITY,
                'Location__r.' . LocationFields::MAX_BOOKINGS,
            ],
            ['Id = \'' . addslashes($eventId) . '\'']
        )['records'][0] ?? [];
        if (empty($event)) {
            return [];
        }
        $event['Bookings'] = $this->query(
            Booking::getFields(),
            [
                BookingFields::EVENT . ' = \'' . addslashes($eventId) . '\'',
                BookingFields::STATUS . ' IN (\'' . implode('\',\'', Booking::bookedStates()) . '\')',
            ],
            ['name' => 'Booking__c']
        )['records'] ?? [];

        $maxCapacity = $event[EventFields::MAX_BOOKINGS] ?: 0;
        $event['max_capacity'] = $event['Location__r'][LocationFields::MAX_BOOKINGS] ?: $maxCapacity;
        $inAttendance = collect($event['Bookings'])
            ->groupBy(BookingFields::WATCH_REMOTELY)
            ->toArray()[false] ?? [];
        $event['inattendance'] = count($inAttendance);
        $event['remaining_spaces'] = $event['max_capacity'] > 0 ? $event['max_capacity'] - $event['inattendance'] : null;

        return $event;
    }

    /**
     * Find all events between two dates (not to be used for determining events for a user)
     *
     * @param Carbon $from
     * @param Carbon $to
     * @return array
     */
    public function findAll($from, $to) : array
    {
        $conditions = [
            EventFields::START_DATE . ' > ' . $from->format('Y-m-d'),
            EventFields::END_DATE . ' < ' . $to->format('Y-m-d'),
            // We need to check the colour has been set as this is a requirement in Salesforce for a
            // bookable event.
            'Event_Type__r.' . EventTypeFields::COLOUR . ' != \'\'',
        ];

        return $this->query($this->getFields(), $conditions)['records'] ?? [];
    }

    /**
     * Get all events for a given account
     *
     * @param string $accountId Salesforce account ID
     * @param Carbon $from Optional from date
     * @param Carbon $to Optional to date
     * @return array
     */
    public function findByAccount(string $accountId, $from, $to) : array
    {
        $subscriptions = collect((new Subscription($this->client))->getAllSubscriptions($accountId));
        $productStatuses = $subscriptions->sort(function ($value1, $value2) {
            if ($value1 === 'Subscribed') {
                return 1;
            }

            return $value1 === $value2 ? 0 : -1;
        })->pluck('status', 'product')->toArray();

        $combiItems = $subscriptions->pluck('product')->toArray();
        $fields = $this->getFields() + [
            'Event_Type__r.Id',
            'Event_Type__r.' . EventTypeFields::NAME,
            'Event_Type__r.' . EventTypeFields::COLOUR,
            'Event_Type__r.Combi_Product__r.Parent_Combi_Product__c',
        ];
        $conditions = [
            EventFields::START_DATE . ' > ' . $from->format('Y-m-d'),
            EventFields::END_DATE . ' < ' . $to->format('Y-m-d'),
            'Event_Type__r.Combi_Product__r.Parent_Combi_Product__c IN (\'' . implode('\',\'', $combiItems) . '\')',
            // We need to check the colour has been set as this is a requirement in Salesforce for a
            // bookable event.
            'Event_Type__r.' . EventTypeFields::COLOUR . ' != \'\'',
        ];
        $events = $this->query($fields, $conditions)['records'] ?? [];
        foreach ($events as &$event) {
            $productId = $event['Event_Type__r']['Combi_Product__r']['Parent_Combi_Product__c'];
            $event['locked'] = $productStatuses[$productId] !== 'Subscribed';
        }
        unset($event);

        return $events;
    }

    /**
     * Get presenters relating to courses visible to an account
     *
     * @param string $accountId Salesforce casesafe account ID
     * @return array Presenters
     */
    public function getPresenters(string $accountId) : array
    {
        $key = 'salesforce.events.presenters.' . $accountId;

        return $this->cache->remember($key, 1440, function () use ($accountId) { // remember for 24 hours
            $products = collect((new Subscription($this->client))->getAllSubscriptions($accountId))
                ->pluck('product')
                ->toArray();
            $fields = [
                EventFields::SPEAKER,
                'Speaker__r.Name',
            ];
            $conditions = [
                'Event_Type__r.Combi_Product__r.Parent_Combi_Product__c IN (\'' . implode('\',\'', $products) . '\')',
                // We need to check the colour has been set as this is a requirement in Salesforce
                // for a bookable event.
                'Event_Type__r.' . EventTypeFields::COLOUR . ' != \'\'',
                // We want to restrict to just a year's worth of data.
                EventFields::START_DATE . ' < ' . now()->addMonths(6)->format('Y-m-d'),
                EventFields::END_DATE . ' > ' . now()->addMonths(-6)->format('Y-m-d'),
            ];

            return $this->query($fields, $conditions, ['group' => implode(',', $fields)])['records'] ?? [];
        });
    }

    /**
     * Book an event
     *
     * @param string $eventId Event ID
     * @param string $accountId Account ID
     * @param array $options Additional event booking data to save
     * @return bool True on success, otherwise false
     */
    public function book(string $eventId, string $accountId, array $options = []) : bool
    {
        $account = new Account($this->client, $accountId);
        $person = $account->get();
        $event = $this->details($eventId);

        if (
            empty($event[EventFields::STATUS])
            || $event[EventFields::STATUS] !== 'Running'
            || ! Carbon::createFromFormat(
                'Y-m-d H:i',
                $event[EventFields::START_DATE] . ' ' . $event[EventFields::START_TIME]
            )->subMinutes(30)->isFuture()
        ) {
            return false;
        }
        if (
            empty($options[BookingFields::WATCH_REMOTELY])
            && $event['max_capacity'] > 0
            && empty($event['remaining_spaces'])
        ) {
            return false; // Fully booked
        }

        $recordTypeId = $this->findRecordType('Free Seminar Booking', 'Booking__c');
        if (empty($recordTypeId)) {
            return false;
        }

        return (new Booking($this->client))->create([
            BookingFields::EVENT => $eventId,
            BookingFields::DELEGATE => $accountId,
            BookingFields::STATUS => 'Attending',
            BookingFields::DELEGATE_NAME => $person[PersonFields::FULL_NAME],
            BookingFields::RECORD_TYPE => $recordTypeId,
        ] + $options);
    }
}
