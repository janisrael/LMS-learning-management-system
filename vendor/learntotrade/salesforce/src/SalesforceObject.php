<?php
namespace learntotrade\salesforce;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use learntotrade\salesforce\Exceptions\SalesforceException;

abstract class SalesforceObject
{
    /**
     * Object resource
     *
     * @var string
     */
    protected $resource;

    /**
     * Query resource for HTTP requests
     *
     * @var string
     */
    protected $queryResource = 'services/data/v44.0/query';

    /**
     * Constructor
     *
     * @param \learntotrade\salesforce\Client $client Salesforce client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->cache = new \learntotrade\salesforce\Cache;
        if (! empty($this->name) && empty($this->resource)) {
            $this->resource = 'services/data/v44.0/sobjects/' . $this->name . '/';
        }
    }

    /**
     * Get headers for API call
     *
     * @param array $headers Additional headers
     * @return array Headers array for use with Guzzle
     */
    protected function headers(array $headers = []) : array
    {
        $defaultHeaders = [
            'Authorization' => 'Bearer ' . $this->client->getAccessToken(),
            'X-PrettyPrint' => 1,
        ];

        return array_merge($defaultHeaders, $headers);
    }

    /**
     * Find a record type
     *
     * This allows us to determine the record ID for things like creating a new 'Person Account'.
     *
     * @param string $typeName Record type name
     * @param string $objectType Object type
     * @return string Record type ID
     */
    public function findRecordType($typeName, $objectType = 'Account') : string
    {
        $key = 'salesforce.record_type.' . $objectType . '.' . $typeName;

        // The record type only needs fetching once from Salesforce, after that we can just use the
        // cached value.
        return $this->cache->rememberForever($key, function () use ($typeName, $objectType) {
            try {
                $query = 'SELECT Id, Name FROM RecordType';
                $query .= ' WHERE Name = \'' . addslashes($typeName) . '\'';
                $query .= ' AND SobjectType = \'' . addslashes($objectType) . '\'';
                $response = $this->client->request()->get('services/data/v20.0/query', [
                    RequestOptions::HEADERS => $this->headers(),
                    RequestOptions::QUERY => [
                        'q' => $query
                    ]
                ]);
                $record = json_decode($response->getBody(), true);
            } catch (\Exception $exception) {
                throw new SalesforceException('Unable to retrieve Salesforce Record Type');
            }

            return $record['records'][0]['Id'] ?? '';
        });
    }

    /**
     * Describe an object
     *
     * @return array
     */
    public function describe() : array
    {
        try {
            $response = $this->client->request()->get($this->resource . 'describe', [
                RequestOptions::HEADERS => $this->headers(),
            ]);
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to describe ' . static::class . ' Saleforce object');
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * List of all object fields
     *
     * @return Collection
     */
    public function fields()
    {
        $data = $this->describe();
        if (empty($data['fields'])) {
            return;
        }

        return (new Collection($data['fields']))->pluck('name');
    }

    /**
     * Get all picklists for the object grouped by the field name
     *
     * @return Collection
     */
    public function getPickLists()
    {
        $key = 'salesforce.picklists.' . static::class;

        return $this->cache->remember($key, 1440, function () { // remember for 24 hours
            $data = $this->describe();
            $fields = new Collection($data['fields']);
            $picklists = $fields->filter(function ($value, $key) {
                return ! empty($value['picklistValues']);
            });
            $picklists = $picklists->mapWithKeys(function ($field) {
                $picklist = (new Collection($field['picklistValues']))->pluck('value', 'label');
                return [$field['name'] => $picklist];
            });

            return $picklists;
        });
    }

    /**
     * Get an existing record
     *
     * @param string $id Record ID
     * @return array
     */
    public function get(string $id) : array
    {
        try {
            $response = $this->client->request()->get($this->resource . $id, [
                RequestOptions::HEADERS => $this->headers(),
            ]);
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to get ' . static::class . ' record from Saleforce');
        }

        return json_decode($response->getBody(), true);
    }

    /**
     * Create a new record
     *
     * @param array $data New record data
     * @return string|boolean Returns the new record ID or false if the record cannot be created
     */
    public function create(array $data)
    {
        try {
            $response = $this->client->request()->post($this->resource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::JSON => $data,
            ]);
            $newRecord = json_decode($response->getBody());

        } catch (ClientException $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents());

            throw new SalesforceException('Unable to create ' . static::class . ': ' . $error[0]->message);
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to create ' . static::class . ' Saleforce record');
        }

        return $newRecord->id ?? false;

    }

    /**
     * Update an existing record
     *
     * @param string $id Record ID
     * @param array $data Data to save
     * @return boolean True if successful
     */
    public function update(string $id, array $data) : bool
    {
        try {
            $this->client->request()->patch($this->resource . $id, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::JSON => $data,
            ]);
        } catch (ClientException $exception) {
            $error = json_decode($exception->getResponse()->getBody()->getContents());

            throw new SalesforceException('Unable to update ' . static::class . ': ' . $error[0]->message);
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to update ' . static::class . ' Saleforce record');
        }

        return true;
    }

    /**
     * Query the object
     *
     * @param array $fields Query fields
     * @param array $conditions Query conditions
     * @param array $options Additional query options
     * @return array Found records
     */
    public function query(array $fields, array $conditions, array $options = []) : array
    {
        $objectName = $options['name'] ?? $this->name;
        $query = 'SELECT ' . implode(',', $fields) . ' FROM ' . $objectName;
        $query .= ' WHERE ' . implode(' AND ', $conditions);
        if (! empty($options['group'])) {
            $query .= ' GROUP BY ' . $options['group'];
        }
        if (! empty($options['order'])) {
            $query .= ' ORDER BY ' . $options['order'];
        }
        try {
            $response = $this->client->request()->get($this->queryResource, [
                RequestOptions::HEADERS => $this->headers(),
                RequestOptions::QUERY => [
                    'q' => $query,
                ],
            ]);
            $data = json_decode($response->getBody(), true);
        } catch (\Exception $exception) {
            throw new SalesforceException(
                'Unable to query ' . $objectName
                . ' Salesforce object: ' . $exception->getMessage()
                . ' SOQL: ' . $query
            );
        }
        if (empty($data['totalSize']) || $data['totalSize'] < 1) {
            return [];
        }

        return $data;
    }

    /**
     * Retrieves an array of defined fields for a Salesforce object
     *
     * @param string $alias Optional alias for the fields
     * @return array
     */
    public static function getFields(?string $alias = null) : array
    {
        $fieldsClass = __NAMESPACE__ . '\\fields\\';
        $fieldsClass .= (new \ReflectionClass(get_called_class()))->getShortName() . 'Fields';
        $fields = ['Id' => 'Id'] + (new \ReflectionClass($fieldsClass))->getConstants();
        if ($alias === null) {
            return $fields;
        }

        return collect($fields)->mapWithKeys(function ($value, $key) use ($alias) {
            return [$alias . '.' . $key => $alias . '.' . $value];
        })->toArray();
    }
}
