<?php


namespace RaffMartinez\Slack;


use GuzzleHttp\Client;
use RuntimeException;

abstract class SlackNetworkClient
{
    protected $apiKey;

    private $baseUrl = 'https://slack.com/api/';

    /**
     * @var null|Client
     */
    private $client = null;

    /**
     * @var null|int
     */
    protected $lastResponseCode;

    /**
     * @var null|String
     */
    protected $lastResponseBody;

    private $defaultOptions = [
        'verify' => false
    ];

    private $defaultHeaders = [];

    /**
     * @var null|array
     */
    protected $lastResponseHeaders;

    private function getClient(): Client
    {
        if (is_null($this->client)) {
            $this->defaultHeaders['Authorization'] = 'Bearer ' . $this->apiKey;
            $this->client = new Client(
                [
                    'defaults' => $this->defaultOptions,
                    'base_uri' => $this->baseUrl,
                    'headers' => $this->defaultHeaders,
                ]
            );
        }

        return $this->client;
    }

    private function getRequestOptions(): array
    {
        return array_merge(['headers' => $this->defaultHeaders], $this->defaultOptions);
    }

    protected function get(string $endpoint)
    {
        $response = $this->getClient()->get($endpoint, $this->getRequestOptions());
        $this->lastResponseCode = $response->getStatusCode();
        $this->lastResponseBody = $response->getBody()->getContents();
        $this->lastResponseHeaders = $response->getHeaders();

        return $this->handleSlackResponse($this->lastResponseBody);
    }

    private function handleSlackResponse(string $rawResponse)
    {
        $response = json_decode($rawResponse, true);
        if ($response['ok'] === true) {
            return $rawResponse;
        }

        throw new RuntimeException('Slack Error: ' . $response['error']);
    }
}