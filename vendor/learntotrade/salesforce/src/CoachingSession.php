<?php

namespace learntotrade\salesforce;

use Carbon\Carbon;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use learntotrade\salesforce\fields\SaleFields;
use learntotrade\salesforce\fields\PersonFields;
use learntotrade\salesforce\fields\SubscriptionFields;
use learntotrade\salesforce\fields\CoachingSessionFields;
use learntotrade\salesforce\Exceptions\SalesforceException;

class CoachingSession extends SalesforceObject
{
    protected $name = 'Coaching_Session__c';

    /**
     * Get all booked sessions for a user for a given date
     *
     * @param string $accountId Salesforce account ID
     * @param Carbon $date Date
     * @return array
     */
    public function findBookedByDate(string $accountId, $date) : array
    {
        $conditions = [
            CoachingSessionFields::SALE . ' IN (' . $this->saleQuery($accountId) . ')',
            CoachingSessionFields::DATE . ' = ' . $date->format('Y-m-d'),
            CoachingSessionFields::STATUS . ' = \'Booked\'',
        ];

        return $this->query($this->getCoachingSessionFields(), $conditions);
    }

    /**
     * Get all sessions for a given coach
     *
     * @param string $coachId User ID for the coach/mentor
     * @param Carbon $from Optional from date
     * @param Carbon $to Optional to date
     * @return array
     */
    public function findByCoach(string $coachId, $from = null, $to = null) : array
    {
        $conditions = [
            CoachingSessionFields::COACH . ' = \'' . addslashes($coachId) . '\'',
        ];
        if (! empty($from) && $from instanceof Carbon) {
            $after = CoachingSessionFields::DATE . ' >= ' . $from->format('Y-m-d');
            if ($from->isToday()) {
                $after = CoachingSessionFields::DATE . ' > ' . $from->format('Y-m-d');
                $after .= ' OR (' . CoachingSessionFields::DATE . ' = ' . $from->format('Y-m-d');
                $after .= ' AND ' . CoachingSessionFields::START_TIME . ' > \'' . $from->format('H:i') . '\')';
            }
            $conditions[] = '(' . $after . ')';
        }
        if (! empty($to) && $to instanceof Carbon) {
            $before = CoachingSessionFields::DATE . ' <= ' . $to->format('Y-m-d');
            if ($to->isToday()) {
                $before = CoachingSessionFields::DATE . ' < ' . $to->format('Y-m-d');
                $before .= ' OR (' . CoachingSessionFields::DATE . ' = ' . $to->format('Y-m-d');
                $before .= ' AND ' . CoachingSessionFields::START_TIME . ' <= \'23:59\')';
            }
            $conditions[] = '(' . $before . ')';
        }

        return $this->query($this->getCoachingSessionFields(), $conditions);
    }

    /**
     * Get all future sessions for a given coach
     *
     * @param string $coachId User ID for the coach/mentor
     * @return array
     */
    public function findFutureByCoach(string $coachId) : array
    {
        return $this->findByCoach($coachId, Carbon::now());
    }

    /**
     * Get all sessions for a given account
     *
     * @param string $accountId Salesforce account ID
     * @param Carbon $from Optional from date
     * @param Carbon $to Optional to date
     * @return array
     */
    public function findByAccount(string $accountId, $from, $to) : array
    {
        $conditions = [
            CoachingSessionFields::SALE . ' IN (' . $this->saleQuery($accountId) . ')',
        ];
        if (! empty($from) && $from instanceof Carbon) {
            $after = CoachingSessionFields::DATE . ' >= ' . $from->format('Y-m-d');
            if ($from->isToday()) {
                $after = CoachingSessionFields::DATE . ' > ' . $from->format('Y-m-d');
                $after .= ' OR (' . CoachingSessionFields::DATE . ' = ' . $from->format('Y-m-d');
                $after .= ' AND ' . CoachingSessionFields::START_TIME . ' >= \'00:00\')';
            }
            $conditions[] = '(' . $after . ')';
        }
        if (! empty($to) && $to instanceof Carbon) {
            $before = CoachingSessionFields::DATE . ' <= ' . $to->format('Y-m-d');
            if ($to->isToday()) {
                $before = CoachingSessionFields::DATE . ' < ' . $to->format('Y-m-d');
                $before .= ' OR (' . CoachingSessionFields::DATE . ' = ' . $to->format('Y-m-d');
                $before .= ' AND ' . CoachingSessionFields::START_TIME . ' < \'' . $to->format('H:i') . '\')';
            }
            $conditions[] = '(' . $before . ')';
        }

        return $this->query($this->getCoachingSessionFields(), $conditions);
    }

    /**
     * Get all past sessions for a given customer/Person Account
     *
     * @param string $accountId
     * @return array
     */
    public function findPastByAccount(string $accountId) : array
    {
        return $this->findByAccount($accountId, null, Carbon::now());
    }

    /**
     * Get all sessions for an account by status
     *
     * @param string $accountId
     * @param string $status
     * @return array
     */
    public function findByStatus(string $accountId, string $status) : array
    {
        $conditions[] = 'Sale__r.' . SaleFields::CUSTOMER . ' = \'' . addslashes($accountId) . '\'';
        $conditions[] = CoachingSessionFields::STATUS . ' = \'' . addslashes($status) . '\'';
        // We want to restrict to just a year's worth of data.
        $conditions[] = CoachingSessionFields::DATE . ' < ' . now()->addMonths(6)->format('Y-m-d');
        $conditions[] = CoachingSessionFields::DATE . ' > ' . now()->addMonths(-6)->format('Y-m-d');

        return $this->query($this->getCoachingSessionFields(), $conditions);
    }

    /**
     * Get statistics for an account's coaching sessions, counts the sessions for each status
     *
     * @param string $accountId Salesforce Account ID
     * @return void
     */
    public function getStatusStatistics(string $accountId) : array
    {
        $query = 'SELECT Status__c, COUNT(Id) cnt FROM ' . $this->name;
        $query .= ' WHERE ' . CoachingSessionFields::SALE . ' IN (' . $this->saleQuery($accountId) . ')';
        $query .= ' GROUP BY Status__c';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query,
                ],
            ]);
            $statistics = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to query ' . $this->name . ' Salesforce object'
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        return (new Collection($statistics['records']))
            ->pluck('cnt', CoachingSessionFields::STATUS)
            ->toArray();
    }

    /**
     * Sale query for an account
     *
     * @param string $accountId Salesforce Account ID
     * @return string SOQL query
     */
    protected function saleQuery(string $accountId) : string
    {
        return  'SELECT id FROM Sale__c WHERE ' . SaleFields::CUSTOMER . ' = \'' . addslashes($accountId) . '\'';
    }

    /**
     * Get remaining coaching sessions for an account and the expiry date (the latest expiry date
     * set on a relevant sale).
     *
     * @param string $accountId Salesforce Account ID
     * @return array
     */
    public function getRemaining(string $accountId) : array
    {
        $remaining = 0;
        $expires = null;
        $account = new Account($this->client, $accountId);
        $sales = $account->getSales($accountId);
        if (! empty($sales['records'])) {
            $sales = new Collection($sales['records']);
            $remaining = (int)$sales->pluck(SaleFields::SESSIONS_REMAINING)->sum();
            $expires = $sales->sortByDesc(SaleFields::SESSIONS_EXPIRY)->first()[SaleFields::SESSIONS_EXPIRY] ?? null;
        }
        if (! empty($expires) && Carbon::createFromFormat('Y-m-d', $expires)->isPast()) {
            // All coaching sessions have expired, so none remaining.
            $remaining = 0;
        }

        return compact('remaining', 'expires');
    }

    /**
     * Book a coaching session
     *
     * @param string $sessionId Coaching session ID
     * @param string $accountId Account ID
     * @param array $options Booking data
     * @return array
     */
    public function book(string $sessionId, string $accountId, array $options = []) : array
    {
        $account = new Account($this->client, $accountId);
        $person = $account->get();
        // Determine the first sale that will expire that still has remaining coaching sessions.
        $sale = collect($account->getSales()['records'] ?? [])
            ->filter(function ($value, $key) {
                return $value[SaleFields::SESSIONS_REMAINING] > 0;
            })
            ->sort(function ($value1, $value2) {
                return $value1[SaleFields::SESSIONS_EXPIRY] <=> $value2[SaleFields::SESSIONS_EXPIRY];
            })
            ->first();
        if (empty($sale)) {
            return [
                'booked' => false,
                'message' => 'You have no remaining session credits',
            ];
        }
        $session = $this->get($sessionId);
        if (
            ! empty($session[CoachingSessionFields::STATUS])
            && $session[CoachingSessionFields::STATUS] === 'Pending'
            // Cannot book a session less than half an hour before it starts
            && Carbon::createFromFormat(
                'Y-m-d H:i',
                $session[CoachingSessionFields::DATE] . ' ' . $session[CoachingSessionFields::START_TIME]
            )->subMinutes(30)->isFuture()
        ) {
            // We just need to attach the customer's sale to the coaching session as Salesforce will
            // then automatically set the status to 'Booked' and attach the relevant customer data
            // to the record.
            $data = [CoachingSessionFields::SALE => $sale['Id']];
            $booked = $this->update($sessionId, $data + $options);

            return [
                'booked' => $booked,
                'message' => $booked ? 'Booking confirmed' : 'There was a problem making the booking',
            ];
        }

        return [
            'booked' => false,
            'message' => 'This session is no longer available to book',
        ];
    }

    /**
     * Cancel a coaching session
     *
     * @param string $sessionId Coaching session ID
     * @param string $accountId Account ID
     * @return bool True if successful
     */
    public function cancel(string $sessionId, string $accountId) : bool
    {
        $session = $this->findWithSale($sessionId);
        if (
            empty($session)
            || $session[CoachingSessionFields::STATUS] !== 'Booked'
            // Ensure the coaching session is booked by the correct account
            || $session['Sale__r'][SaleFields::CUSTOMER] !== $accountId
            || Carbon::createFromFormat(
                'Y-m-d H:i',
                $session[CoachingSessionFields::DATE] . ' ' . $session[CoachingSessionFields::START_TIME]
            )->isPast()
        ) {
            return false;
        }

        return $this->update($sessionId, [
            CoachingSessionFields::STATUS => 'Cancelled',
        ]);
    }

    /**
     * Find a coaching session with its associated sale
     *
     * @param string $sessionId
     * @return array
     */
    public function findWithSale(string $sessionId) : array
    {
        $fields = $this->getFields();
        $fields[] = 'Sale__r.' . SaleFields::CUSTOMER;

        return $this->query($fields, ['Id = \'' . addslashes($sessionId) . '\''])['records'][0] ?? [];
    }

    /**
     * Retrieves an array of coaching session fields
     *
     * @return array
     */
    protected function getCoachingSessionFields() : array
    {
        return ['Id' => 'Id'] + (new \ReflectionClass(CoachingSessionFields::class))->getConstants();
    }
}
