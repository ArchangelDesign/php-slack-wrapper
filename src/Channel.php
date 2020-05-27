<?php


namespace RaffMartinez\Slack;

/**
 * Class Channel
 * @package RaffMartinez\Slack
 */
class Channel
{

    private $id;

    private $name;

    private $normalizedName;

    private $isIm;

    private $isMpim;

    private $isOpen;

    public static function fromArray(array $rawChannel): Channel
    {
        $i = new static();
        $i->id = $rawChannel['id'];
        $i->name = $rawChannel['name'];
        $i->normalizedName = $rawChannel['name_normalized'];
        $i->isIm = $rawChannel['is_im'];
        $i->isMpim = $rawChannel['is_mpim'];

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
    public function getNormalizedName()
    {
        return $this->normalizedName;
    }

    /**
     * @return mixed
     */
    public function getIsIm()
    {
        return $this->isIm;
    }

    /**
     * @return mixed
     */
    public function getIsMpim()
    {
        return $this->isMpim;
    }

    /**
     * @return mixed
     */
    public function getIsOpen()
    {
        return $this->isOpen;
    }
}