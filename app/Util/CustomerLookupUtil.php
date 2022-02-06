<?php


namespace App\Util;


use GuzzleHttp\Client;

class CustomerLookupUtil
{
    private $result;
    private $client;
    private $address;
    private $responseBody;
    private $requestType;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Send Request
     *
     * @param array $data
     */
    public function request(array $formParams, string $apiKey)
    {
        $request = $this->client->request(
            $this->requestType,
            $this->address,
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'x-api-key' => $apiKey
                ],
                'json' => $formParams
            ]
        );

        $this->result = $request->getBody()->getContents();
    }


    /**
     * Set the address for the request.
     *
     * @param string $address
     *   The URI or IP address to request.
     */
    public function setAddress($address) {
        $this->address = $address;
    }

    /**
     * Set a request type.
     *
     * @param string $type
     *   GET, POST, DELETE, PUT, etc. Any standard request type will work.
     */
    public function setRequestType($type) {
        $this->requestType = $type;
    }


    /**
     * Get the response body.
     *
     * @return mixed object or array.
     *   Response body.
     */
    public function getResponse() {
        return $this->result;
    }


}
