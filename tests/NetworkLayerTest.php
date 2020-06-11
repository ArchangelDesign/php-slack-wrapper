<?php

namespace RaffMartinez\Slack\Test;

use PHPUnit\Framework\TestCase;
use RaffMartinez\Slack\Channel;
use RaffMartinez\Slack\Message;
use RaffMartinez\Slack\Slack;

class NetworkLayerTest extends TestCase
{
    public function testGetChannelList()
    {
        $slack = new Slack(getenv('api-token'));
        $list = $slack->getChannelList();
        $lastResponse = $slack->getLastResponseBody();
        $this->assertEquals(200, $slack->getLastResponseCode());
        $this->assertIsArray($lastResponse);
        $this->assertArrayHasKey('ok', $lastResponse);
        $this->assertTrue($lastResponse['ok']);
        $this->assertArrayHasKey('channels', $lastResponse);
        $this->assertNotEmpty($lastResponse['channels']);
        $this->assertIsArray($list);
        $firstChannel = array_shift($list);
        $this->assertInstanceOf(Channel::class, $firstChannel);
    }

    public function testBotsInfo()
    {
        $slack = new Slack(getenv('api-token'));
        $response = $slack->getBotsInfo('');
        $this->assertEquals(true, $response['ok']);
        $this->markAsRisky();
    }

    public function testPostMessage()
    {
        $slack = new Slack(getenv('api-token'));
        $channels = $slack->getChannelList();
        $res = $slack->postMessage($channels[3], Message::simpleMessage('The message', 'test'));
        $this->assertIsArray($res);
        $this->assertEquals(true, $res['ok']);
        $this->assertIsArray($res['message']);
        $this->assertEquals('message', $res['message']['type']);
        $this->assertEquals('The message', $res['message']['text']);
    }
}
