<?php


namespace RaffMartinez\Slack;


class Message
{
    private $text;

    private $iconEmoji = null;

    private $iconUrl = null;

    private $threadTs = null;

    private $username;

    public static function simpleMessage(string $text, string $username)
    {
        $i = new static();
        $i->text = $text;
        $i->username = $username;

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