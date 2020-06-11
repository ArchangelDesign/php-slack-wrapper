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

    public function getChannelList(): array {
        $channels = $this->get('conversations.list')['channels'];
        $response = [];

        foreach ($channels as $c) {
            $response[] = Channel::fromArray($c);
        }

        return $response;
    }

    public function getBotsInfo(string $botId) {
        return $this->get('bots.info', ['bot_id' => $botId]);
    }

    public function getUserList() {}

    public function getUserInfo() {}

    public function postMessage(Channel $channel, Message $message) {
        $args = $message->getMessage();
        $args['channel'] = $channel->getId();
        return $this->post('chat.postMessage', $args);
    }

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
    public function getLastResponseBody(): ?array
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