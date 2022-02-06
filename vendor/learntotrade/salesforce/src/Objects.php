<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use learntotrade\salesforce\Exceptions\SalesforceException;

class Objects extends SalesforceObject
{
    protected $name = 'sobjects';

    /**
     * Returns a list of Salesforce objects
     *
     * @return Collection
     */
    public function getObjectsList()
    {
        try {
            $response = $this->client->request()->get($this->resource, [
                RequestOptions::HEADERS => $this->headers(),
            ]);
            $data = json_decode($response->getBody());
            $objects = new Collection($data->sobjects);
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to get objects from Salesforce');
        }

        return $objects->pluck('name');
    }
}
