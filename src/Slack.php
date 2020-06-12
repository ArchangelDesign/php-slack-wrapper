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

/**
 * Class Slack
 * @package RaffMartinez\Slack
 */
class Slack extends SlackNetworkClient
{
    private $lastTs = null;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * Returns array of Channel objects
     *
     * @return array
     */
    public function getChannelList(): array {
        $channels = $this->get('conversations.list')['channels'];
        $response = [];

        foreach ($channels as $c) {
            $response[] = Channel::fromArray($c);
        }

        return $response;
    }

    /**
     * @param string $botId
     * @return mixed
     */
    public function getBotsInfo(string $botId) {
        return $this->get('bots.info', ['bot_id' => $botId]);
    }

    /**
     * Returns array of User objects
     *
     * @return array
     */
    public function getUserList() {
        $response = $this->get('users.list');
        $members = [];
        foreach ($response['members'] as $member) {
            $members[] = User::fromArray($member);
        }

        return $members;
    }

    /**
     * @param string $user
     * @return User
     */
    public function getUserInfo(string $user): User {
        $response = $this->get('users.info', ['user' => $user]);

        return User::fromArray($response['user']);
    }

    /**
     * @param string $team
     * @return Team
     */
    public function getTeamInfo(string $team): Team
    {
        $response = $this->get('team.info', ['team' => $team]);

        return Team::fromArray($response['team']);
    }

    /**
     * @param Channel $channel
     * @param string $threadTs
     * @return mixed
     */
    public function deleteMessage(Channel $channel, string $threadTs)
    {
        return $this->post('chat.delete', ['channel' => $channel->getId(), 'ts' => $threadTs]);
    }

    /**
     * Posts message to a channel and returns full response from slack API
     * as array. `ts` can be used to create threads
     *
     * @param Channel $channel
     * @param Message $message
     * @return mixed
     */
    public function postMessage(Channel $channel, Message $message) {
        $args = $message->getMessage();
        $args['channel'] = $channel->getId();
        $response = $this->post('chat.postMessage', $args);
        $this->lastTs = $response['ts'];

        return $response;
    }

    public function getTeamChannels()
    {
        return $this->get('conversations.list');
    }

    public function getCustomEmojis()
    {
        return $this->get('emoji.list');
    }

    /**
     * @return int|null
     */
    public function getLastResponseCode(): ?int
    {
        return $this->lastResponseCode;
    }

    /**
     * @return array|null
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

    public function getLastMessageTs()
    {
        return $this->lastTs;
    }
}