<?php

namespace RaffMartinez\Slack;

/**
 * Class Slack
 * @package RaffMartinez\Slack
 */
class Slack
{
    /**
     * @var string|null
     */
    private $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }
}