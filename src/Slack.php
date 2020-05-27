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
        return json_decode($this->get('conversations.list'), true);
    }

    public function getUserList() {}

    public function getUserInfo() {}

    public function postMessage() {}
}