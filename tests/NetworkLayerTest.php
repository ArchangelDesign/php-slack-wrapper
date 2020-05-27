<?php

namespace RaffMartinez\Slack\Test;

use PHPUnit\Framework\TestCase;
use RaffMartinez\Slack\Slack;

class NetworkLayerTest extends TestCase
{
    public function testGetChannelList()
    {
        $slack = new Slack(getenv('api-token'));
        $list = $slack->getChannelList();
        $lastResponse = json_decode($slack->getLastResponseBody(), true);
        $this->assertEquals(200, $slack->getLastResponseCode());
        $this->assertIsArray($lastResponse);
        $this->assertArrayHasKey('ok', $lastResponse);
        $this->assertTrue($lastResponse['ok']);
        $this->assertArrayHasKey('channels', $lastResponse);
        $this->assertNotEmpty($lastResponse['channels']);
        $this->assertIsArray($list);
    }
}
