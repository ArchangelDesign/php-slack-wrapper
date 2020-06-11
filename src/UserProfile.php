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
 * Class UserProfile
 * @package RaffMartinez\Slack
 */
class UserProfile
{
    private $avatar_hash;
    private $status_text;
    private $status_emoji;
    private $real_name;
    private $display_name;
    private $real_name_normalized;
    private $display_name_normalized;
    private $email;
    private $image_24;
    private $image_32;
    private $image_48;
    private $image_72;
    private $image_192;
    private $image_512;
    private $team;

    public static function fromArray(array $input): UserProfile
    {
        $i = new static();

        foreach ($input as $name => $value) {
            if (property_exists($i, $name)) {
                $i->$name = $value;
            }
        }

        return $i;
    }

    /**
     * @return mixed
     */
    public function getAvatarHash()
    {
        return $this->avatar_hash;
    }

    /**
     * @return mixed
     */
    public function getStatusText()
    {
        return $this->status_text;
    }

    /**
     * @return mixed
     */
    public function getStatusEmoji()
    {
        return $this->status_emoji;
    }

    /**
     * @return mixed
     */
    public function getRealName()
    {
        return $this->real_name;
    }

    /**
     * @return mixed
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * @return mixed
     */
    public function getRealNameNormalized()
    {
        return $this->real_name_normalized;
    }

    /**
     * @return mixed
     */
    public function getDisplayNameNormalized()
    {
        return $this->display_name_normalized;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getImage24()
    {
        return $this->image_24;
    }

    /**
     * @return mixed
     */
    public function getImage32()
    {
        return $this->image_32;
    }

    /**
     * @return mixed
     */
    public function getImage48()
    {
        return $this->image_48;
    }

    /**
     * @return mixed
     */
    public function getImage72()
    {
        return $this->image_72;
    }

    /**
     * @return mixed
     */
    public function getImage192()
    {
        return $this->image_192;
    }

    /**
     * @return mixed
     */
    public function getImage512()
    {
        return $this->image_512;
    }

    /**
     * @return mixed
     */
    public function getTeam()
    {
        return $this->team;
    }
}