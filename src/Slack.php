<?php

namespace RaffMartinez\Slack;

/**
 * Class Slack
 * @package RaffMartinez\Slack
 */
class Slack extends SlackNetworkClient
{

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function getChannelList() {
        $channels = json_decode($this->get('conversations.list'), true)['channels'];
        $response = [];

        foreach ($channels as $c) {
            $response[] = Channel::fromArray($c);
        }

        return $response;
    }

    public function getUserList() {}

    public function getUserInfo() {}

    public function postMessage() {}

    /**
     * @return int|null
     */
    public function getLastResponseCode(): ?int
    {
        return $this->lastResponseCode;
    }

    /**
     * @return string|null
     */
    public function getLastResponseBody(): ?string
    {
        return $this->lastResponseBody;
    }

    /**
     * @return array|null
     */
    public function getLastResponseHeaders(): ?array
    {
        return $this->lastResponseHeaders;
    }


}