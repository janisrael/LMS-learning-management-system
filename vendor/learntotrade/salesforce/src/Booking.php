<?php

namespace learntotrade\salesforce;

use Carbon\Carbon;
use learntotrade\salesforce\SalesforceObject;
use learntotrade\salesforce\fields\EventFields;
use learntotrade\salesforce\fields\BookingFields;

class Booking extends SalesforceObject
{
    protected $name = 'Booking__c';

    /**
     * Returns an array of all the booked states from Salesforce
     *
     * @return array
     */
    public static function bookedStates() : array
    {
        return [
            'Attending',
            'Attended',
            'Attended - Late Purchase',
            'Attended Purchased',
            'Attended Not Purchased',
        ];
    }

    /**
     * Get all bookings for a user for a given date
     *
     * @param string $accountId Salesforce account ID
     * @param Carbon $date Date
     * @return array
     */
    public function findBookedByDate(string $accountId, $date) : array
    {
        $conditions = [
            BookingFields::DELEGATE . ' = \'' . addslashes($accountId) . '\'',
            '(' . BookingFields::START_DATE . ' = ' . $date->format('Y-m-d')
                . 'OR (' . BookingFields::START_DATE . ' >= ' . $date->format('Y-m-d')
                . ' AND ' . BookingFields::END_DATE . '<=' . $date->format('Y-m-d') . '))',
            BookingFields::STATUS . ' = \'Attending\'',
        ];

        return $this->query($this->getFields(), $conditions);
    }

    /**
     * Cancel a booking
     *
     * @param string $bookingId Booking ID
     * @param string $accountId Account ID
     * @return bool True if successfully cancelled
     */
    public function cancel(string $bookingId, string $accountId) : bool
    {
        $booking = $this->query(
            ['Id'],
            [
                'Id = \'' . $bookingId . '\'',
                BookingFields::STATUS . ' = \'Attending\'',
                BookingFields::DELEGATE . ' = \'' . $accountId . '\'',
                'Event_Date__c >= ' . now()->format('Y-m-d'),
            ]
        )['records'][0] ?? null;
        if (empty($booking)) {
            return false;
        }

        return $this->update($bookingId, [
            BookingFields::STATUS => 'Cancelled',
        ]);
    }

    /**
     * Get a booking along with its associated event
     *
     * @param string $bookingId Booking ID
     * @return array
     */
    public function findWithEvent(string $bookingId) : array
    {
        return $this->query($this->getFields() + Event::getFields('Event_Name__r'), [
            'Id = \'' . addslashes($bookingId) . '\'',
        ])['records'][0] ?? [];
    }
}
