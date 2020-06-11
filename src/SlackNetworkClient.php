<?php


namespace RaffMartinez\Slack;


use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
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
     * @var null|array
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

    protected function get(string $endpoint, $args = [])
    {
        $response = $this->getClient()->get($endpoint, array_merge($args, $this->getRequestOptions()));

        return $this->handleSlackResponse($response);
    }

    protected function post(string $endpoint, array $arguments)
    {
        $response = $this->getClient()
            ->post($endpoint, array_merge(['json' => $arguments], $this->getRequestOptions()));

        return $this->handleSlackResponse($response);
    }

    private function handleSlackResponse(ResponseInterface $response)
    {
        $responseBody = json_decode($response->getBody()->getContents(), true);
        $this->lastResponseCode = $response->getStatusCode();
        $this->lastResponseBody = $responseBody;
        $this->lastResponseHeaders = $response->getHeaders();
        if ($responseBody['ok'] === true) {
            return $responseBody;
        }

        throw new RuntimeException('Slack Error: ' . $responseBody['error']);
    }
}