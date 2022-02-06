<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use learntotrade\salesforce\Exceptions\SalesforceException;
use learntotrade\salesforce\fields\PersonFields;

class Person extends SalesforceObject
{
    protected $name = 'Account';

    /**
     * Create a new Person Account
     *
     * @param array $data New record data
     * @return string|boolean Returns the new account ID or false if the account cannot be created
     */
    public function create(array $data)
    {
        $recordTypeId = $this->findRecordType('Person Account');
        if (empty($recordTypeId)) {
            return false;
        }
        $data[PersonFields::RECORD_TYPE_ID] = $recordTypeId;

        if (empty($data[PersonFields::LAST_NAME]) || empty($data[PersonFields::EMAIL])) {
            throw new Exception('LastName and PersonEmail required to create new Person Account');
        }

        $data[PersonFields::MOBILE] = $this->getMobileField($data);

        return parent::create($data);
    }

    /**
     * Update an existing person record
     *
     * @param string $id Record ID
     * @param array $data Data to save
     * @return boolean True if successful
     */
    public function update(string $id, array $data) : bool
    {
        if (array_key_exists(PersonFields::MOBILE, $data)) {
            $data[PersonFields::MOBILE] = $this->getMobileField($data);
        }

        return parent::update($id, $data);
    }

    /**
     * Find a Person Account in Salesforce by email address
     *
     * The returned data may contain more than one record if multiple accounts are found with the
     * same email address. The returned array contains a 'totalSize' index that should be 1 if a
     * single match is found (which is what we want).
     *
     * @param string $accountEmail Account's primary email address
     * @return array Person Account data
     */
    public function findByEmail(string $accountEmail, $fields = []) : array
    {
        $fields = array_unique([
            'Id',
            'Name',
            PersonFields::FIRST_NAME,
            PersonFields::LAST_NAME,
            PersonFields::SALUTATION,
            PersonFields::NICKNAME,
            PersonFields::LANGUAGE,
            PersonFields::DATE_OF_BIRTH,
            PersonFields::LEARN_FOREX_VERSION,
            PersonFields::REGION,
            PersonFields::TIMEZONE,
        ] + $fields);

        $query = 'SELECT ' . implode(',', $fields) . ' FROM Account';
        $query .= ' WHERE ' . PersonFields::EMAIL . ' = \'' . addslashes($accountEmail) . '\'';
        $query .= ' AND IsPersonAccount = TRUE';
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query
                ]
            ]);
            $accounts = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to retrieve Salesforce Accounts by email (' . $accountEmail . '): ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }

        if (empty($accounts)) {
            return [];
        }

        return $accounts;
    }

    /**
     * Fetch the last trading account used.
     *
     * @param string $id The salesforce ID of the person
     * @param string $field The field name to fetch. Defaults to the original field
     * @return int|null The account ID or null
     */
    public function fetchTradingAccountId(string $id, string $field = PersonFields::LATEST_TRADING_ACCOUNT_ID) : ?int
    {
        return $this->query([$field], ['Id = \'' . addSlashes($id) . '\''])['records'][0][$field] ?? null;
    }

    /**
     * Gets the mobile field from the request data or uses a default value
     * @param  array  $data
     * @return string
     */
    protected function getMobileField(array $data)
    {
        // A mobile phone number is required to create/update a Person, if one isn't set it defauls to '0000'
        return $data[PersonFields::MOBILE] ?? '0000';
    }
}
