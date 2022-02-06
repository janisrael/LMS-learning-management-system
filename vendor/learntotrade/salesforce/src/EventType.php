<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use learntotrade\salesforce\Subscription;
use learntotrade\salesforce\fields\EventTypeFields;
use learntotrade\salesforce\Exceptions\SalesforceException;

class EventType extends SalesforceObject
{
    protected $name = 'Event_Type__c';

    /**
     * Find all event types ('courses') for an account
     *
     * @param string $accountId Salesforce casesafe account ID
     * @return array
     */
    public function findByAccount(string $accountId) : array
    {
        $productStatuses = collect(
            (new Subscription($this->client))->getAllSubscriptions($accountId)
        )->sort(function ($value1, $value2) {
            if ($value1 === 'Subscribed') {
                return 1;
            }

            return $value1 === $value2 ? 0 : -1;
        })->pluck('status', 'product')->toArray();

        $fields = [
            'Id',
            EventTypeFields::NAME,
            EventTypeFields::COLOUR,
            'Combi_Product__r.Parent_Combi_Product__c',
        ];
        $conditions = [
            'Combi_Product__r.Parent_Combi_Product__c IN (\'' . implode('\',\'', array_keys($productStatuses)) . '\')',
        ];
        $courses = $this->query($fields, $conditions)['records'] ?? [];
        foreach ($courses as &$course) {
            $productId = $course['Combi_Product__r']['Parent_Combi_Product__c'];
            $course['locked'] = empty($productStatuses[$productId]) || $productStatuses[$productId] !== 'Subscribed';
        }
        unset($course);

        return $courses;
    }

    /**
     * Get all SmartCharts courses
     *
     * @return array
     */
    public function getAll() : array
    {
        // We determine if a course is for SmartCharts based on whether or not a colour has been set
        return $this->query($this->getFields(), [
            EventTypeFields::COLOUR . ' != \'\'',
        ])['records'];
    }
}
