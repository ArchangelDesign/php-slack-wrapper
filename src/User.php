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
 * Class User
 * @package RaffMartinez\Slack
 */
class User
{
    private $id;
    private $team_id;
    private $name;
    private $deleted;
    private $color;
    private $real_name;
    private $tz;
    private $tz_label;
    private $tz_offset;
    private $is_admin;
    private $is_owner;
    private $is_primary_owner;
    private $is_restricted;
    private $is_ultra_restricted;
    private $is_bot;
    private $updated;
    private $is_app_user;
    private $has_2fa;
    /** @var UserProfile */
    private $profile;

    public static function fromArray(array $input): User
    {
        $i = new static();

        foreach ($input as $name => $value) {
            if (property_exists($i, $name)) {
                $i->$name = $value;
            }
        }

        $i->profile = UserProfile::fromArray($input['profile']);

        return $i;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTeamId()
    {
        return $this->team_id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
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
    public function getTz()
    {
        return $this->tz;
    }

    /**
     * @return mixed
     */
    public function getTzLabel()
    {
        return $this->tz_label;
    }

    /**
     * @return mixed
     */
    public function getTzOffset()
    {
        return $this->tz_offset;
    }

    /**
     * @return mixed
     */
    public function getIsAdmin()
    {
        return $this->is_admin;
    }

    /**
     * @return mixed
     */
    public function getIsOwner()
    {
        return $this->is_owner;
    }

    /**
     * @return mixed
     */
    public function getIsPrimaryOwner()
    {
        return $this->is_primary_owner;
    }

    /**
     * @return mixed
     */
    public function getIsRestricted()
    {
        return $this->is_restricted;
    }

    /**
     * @return mixed
     */
    public function getIsUltraRestricted()
    {
        return $this->is_ultra_restricted;
    }

    /**
     * @return mixed
     */
    public function getIsBot()
    {
        return $this->is_bot;
    }

    /**
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * @return mixed
     */
    public function getIsAppUser()
    {
        return $this->is_app_user;
    }

    /**
     * @return mixed
     */
    public function getHas2fa()
    {
        return $this->has_2fa;
    }

    /**
     * @return UserProfile
     */
    public function getProfile(): UserProfile
    {
        return $this->profile;
    }
}