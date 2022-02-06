<?php

namespace learntotrade\salesforce;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Collection;
use GuzzleHttp\Exception\ClientException;
use learntotrade\salesforce\Exceptions\SalesforceException;

class Client
{
    protected $client = null;

    protected $accessToken = null;

    /**
     * API credentials
     *
     * @var array
     */
    protected $apiCredentials;

    /**
     * Salesforce user credentials
     *
     * @var array
     */
    protected $UserCredentials;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cache = new \learntotrade\salesforce\Cache;

        $this->apiCredentials = [
            'client_id' => config('salesforce.client_id'),
            'client_secret' => config('salesforce.client_secret'),
        ];

        $this->UserCredentials = [
            'username' => config('salesforce.username'),
            'password' => config('salesforce.password'),
            'security_token' => config('salesforce.security_token')
        ];

        $this->client = new \GuzzleHttp\Client(['base_uri' => config('salesforce.url')]);
        $this->authenticate();
    }

    /**
     * API authentication, sets the access token
     *
     * @return bool True if able to authenticate
     */
    public function authenticate() : bool
    {
        $timeout = config('salesforce.session_timeout');
        $this->accessToken = $this->cache->remember('salesforce.access_token', $timeout, function () {
            return $this->fetchAccessToken();
        });

        return ! empty($this->accessToken);
    }

    /**
     * Fetch the access token from Salesforce
     *
     * @return string Salesforce access token
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    protected function fetchAccessToken() : string
    {
        try {
            $response = $this->client->post('services/oauth2/token', [
                RequestOptions::FORM_PARAMS => [
                    'grant_type' => 'password',
                    'client_id' => $this->apiCredentials['client_id'],
                    'client_secret' => $this->apiCredentials['client_secret'],
                    'username' => $this->UserCredentials['username'],
                    'password' => $this->UserCredentials['password'] . $this->UserCredentials['security_token'],
                ]
            ]);

            $data = json_decode($response->getBody());
        } catch (\Exception $exception) {
            throw new SalesforceException('Unable to connect to Salesforce');
        }


        if ($this->validateAccessToken($data)) {
            return $data->access_token;
        }

        throw new SalesforceException('Unable to authenticate connection to Salesforce');
    }

    /**
     * Validate the access token by checking the Base64-encoded HMAC-SHA256 signature
     *
     * @param Object $params API response containing access token details
     * @param string $secret Client secret
     * @return bool
     */
    protected function validateAccessToken($params)
    {
        if (empty($params->id) || empty($params->issued_at)) {
            return false;
        }
        $data = $params->id . $params->issued_at;
        $hash = hash_hmac('sha256', $data, $this->apiCredentials['client_secret'], true);

        return ! empty($params->signature) && base64_encode($hash) === $params->signature;
    }

    /**
     * Get the access token
     *
     * @return string
     */
    public function getAccessToken() : string
    {
        return $this->accessToken;
    }

    /**
     * Returns the Guzzle Client for making requests
     *
     * @return \GuzzleHttp\Client
     */
    public function request()
    {
        return $this->client;
    }
}
