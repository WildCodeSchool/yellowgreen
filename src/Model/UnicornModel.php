<?php

namespace App\Model;

use App\Model\AbstractModel;

class UnicornModel extends AbstractModel
{
    protected int $id;
    protected string $name;
    protected string $avatar;
    protected int $score = 0;
    protected int $fights = 0;
    protected int $wonFights = 0;
    protected int $lostFights = 0;
    protected int $koFights = 0;

    public function __construct(
        string $name = "name",
        string $avatar = "",
    ) {
        $this->id = -1;
        $this->name = $name;
        $this->avatar = $avatar;
    }


    /**
     * Get the value of id
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }


    /**
     * Get the value of avatar
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of avatar
     *
     * @return  self
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get the value of name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }


    /**
     * Get the value of score
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * Set the value of score
     *
     * @return  self
     */
    public function setScore($score)
    {
        $this->score = $score;

        return $this;
    }

    /**
     * Get the value of fights
     */
    public function getFights()
    {
        return $this->fights;
    }

    /**
     * Set the value of fights
     *
     * @return  self
     */
    public function setFights($fights)
    {
        $this->fights = $fights;

        return $this;
    }


    /**
     * Get the value of koFights
     */
    public function getKoFights()
    {
        return $this->koFights;
    }

    /**
     * Set the value of koFights
     *
     * @return  self
     */
    public function setKoFights($koFights)
    {
        $this->koFights = $koFights;

        return $this;
    }

    /**
     * Get the value of wonFights
     */
    public function getWonFights()
    {
        return $this->wonFights;
    }

    /**
     * Set the value of wonFights
     *
     * @return  self
     */
    public function setWonFights($wonFights)
    {
        $this->wonFights = $wonFights;

        return $this;
    }

    /**
     * Get the value of lostFights
     */
    public function getLostFights()
    {
        return $this->lostFights;
    }

    /**
     * Set the value of lostFights
     *
     * @return  self
     */
    public function setLostFights($lostFights)
    {
        $this->lostFights = $lostFights;

        return $this;
    }
}
