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


class Message
{
    private $text;

    private $iconEmoji = null;

    private $iconUrl = null;

    private $threadTs = null;

    private $username;

    public static function simpleMessage(string $text, string $username): Message
    {
        $i = new static();
        $i->text = $text;
        $i->username = $username;

        return $i;
    }

    public static function responseMessage(string $text, string $username, $threadTs): Message
    {
        $i = new static();
        $i->text = $text;
        $i->username = $username;
        $i->threadTs = $threadTs;

        return $i;
    }

    public function getMessage(): array
    {
        $res = [
            'text' => $this->text,
            'username' => $this->username
        ];

        if ($this->iconEmoji) {
            $res['icon_emoji'] = $this->iconEmoji;
        }

        if ($this->iconUrl) {
            $res['icon_url'] = $this->iconUrl;
        }

        if ($this->threadTs) {
            $res['thread_ts'] = $this->threadTs;
        }

        return $res;
    }
}