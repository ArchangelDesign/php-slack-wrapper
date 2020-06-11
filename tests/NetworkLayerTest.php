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

namespace RaffMartinez\Slack\Test;

use PHPUnit\Framework\TestCase;
use RaffMartinez\Slack\Channel;
use RaffMartinez\Slack\Message;
use RaffMartinez\Slack\Slack;
use RaffMartinez\Slack\User;

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
        $this->assertNotEmpty($res['ts']);
        $ts = $res['ts'];
        $slack->postMessage($channels[3], Message::responseMessage('The response', 'test', $ts));
    }

    public function testUserList()
    {
        $slack = new Slack(getenv('api-token'));
        $users = $slack->getUserList();
        $this->assertIsArray($users);
        $this->assertNotEmpty($users);
        $this->assertInstanceOf(User::class, $users[0]);
    }
}
