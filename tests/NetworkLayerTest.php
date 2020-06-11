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
use RaffMartinez\Slack\Team;
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

    public function testGetBotsInfo()
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
        $c = $channels[3];
        $res = $slack->postMessage($c, Message::simpleMessage('The message', 'test'));
        $this->assertIsArray($res);
        $this->assertEquals(true, $res['ok']);
        $this->assertIsArray($res['message']);
        $this->assertEquals('message', $res['message']['type']);
        $this->assertEquals('The message', $res['message']['text']);
        $this->assertNotEmpty($res['ts']);
        $ts = $res['ts'];
        $subTs = $slack->postMessage($c, Message::responseMessage('The response', 'test', $ts))['ts'];
        $slack->deleteMessage($c, $subTs);
        $slack->deleteMessage($c, $ts);
    }

    public function testGetUserList()
    {
        $slack = new Slack(getenv('api-token'));
        $users = $slack->getUserList();
        $this->assertIsArray($users);
        $this->assertNotEmpty($users);
        $this->assertInstanceOf(User::class, $users[0]);
    }

    public function testGetUserInfo()
    {
        $slack = new Slack(getenv('api-token'));
        /** @var User $user */
        $user = $slack->getUserList()[0];
        $res = $slack->getUserInfo($user->getId());
        $this->assertInstanceOf(User::class, $res);
        $this->assertEquals($user->getId(), $res->getId());
    }

    public function testGetTeamInfo()
    {
        $slack = new Slack(getenv('api-token'));
        /** @var User $user */
        $user = $slack->getUserList()[0];
        $res = $slack->getTeamInfo($user->getProfile()->getTeam());
        $this->assertInstanceOf(Team::class, $res);
        $this->assertEquals($user->getTeamId(), $res->getId());
    }
}
