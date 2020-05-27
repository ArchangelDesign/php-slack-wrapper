<?php


namespace RaffMartinez\Slack;


use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

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
    private $lastResponseCode;

    /**
     * @var null|StreamInterface
     */
    private $lastResponseBody;

    private $defaultOptions = [
        'verify' => false
    ];

    /**
     * @var null|array
     */
    private $lastResponseHeaders;

    private function getClient(): Client
    {
        if (is_null($this->client)) {
            $this->client = new Client(['defaults' => $this->defaultOptions]);
        }

        return $this->client;
    }

    protected function get(string $endpoint)
    {
        $response = $this->getClient()->get($this->baseUrl . $endpoint);
        $this->lastResponseCode = $response->getStatusCode();
        $this->lastResponseBody = $response->getBody();
        $this->lastResponseHeaders = $response->getHeaders();

        return $response->getBody()->getContents();
    }
}