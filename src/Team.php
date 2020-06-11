<?php


namespace RaffMartinez\Slack;


class Team
{
    private $id;

    private $name;

    private $domain;

    private $emailDomain;

    public static function fromArray(array $input): Team
    {
        $i = new static();
        $i->name = $input['name'];
        $i->id = $input['id'];
        $i->domain = $input['domain'];
        $i->emailDomain = $input['email_domain'];

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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getDomain()
    {
        return $this->domain;
    }

    /**
     * @return mixed
     */
    public function getEmailDomain()
    {
        return $this->emailDomain;
    }
}