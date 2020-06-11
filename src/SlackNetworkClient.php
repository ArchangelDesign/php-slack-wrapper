<?php
/*
 * PHP Slack Wrapper
 *
 * https://github.com/ArchangelDesign/php-slack-wrapper
 * https://packagist.org/packages/raffmartinez/php-slack-wrapper
 * license: MIT
 * author: Raff Martinez-Marjanski
 * date: May 2020
 */

namespace RaffMartinez\Slack;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use RuntimeException;

/**
 * Class SlackNetworkClient
 * @package RaffMartinez\Slack
 */
abstract class SlackNetworkClient
{
    /**
     * @var string
     */
    protected $apiKey;

    /**
     * @var string
     */
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

    /**
     * @var array
     */
    private $defaultOptions = [
        'verify' => false
    ];

    /**
     * @var array
     */
    private $defaultHeaders = [];

    /**
     * @var string|null
     */
    private $lastEndpoint;

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
        $this->lastEndpoint = $endpoint;
        $response = $this->getClient()->get($endpoint, array_merge(['query' => $args], $this->getRequestOptions()));

        return $this->handleSlackResponse($response);
    }

    protected function post(string $endpoint, array $arguments)
    {
        $this->lastEndpoint = $endpoint;
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

        throw new RuntimeException('Slack Error: '
            . $responseBody['error'] . ' calling endpoint: ' . $this->lastEndpoint);
    }
}