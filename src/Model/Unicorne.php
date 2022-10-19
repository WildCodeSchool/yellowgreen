<?php

namespace App\Model;

class Unicorne
{
    private int $id;
    private string $name;
    private string $avatar;
    private int $score = 0;
    private int $fights = 0;
    private int $won_fights = 0;
    private int $lost_fights = 0;
    private int $ko_fights = 0;

    public function __construct(string $name, string $avatar = "")
    {
        $this->name = $name;
        $this->avatar = $avatar;
    }


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

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
     * Get the value of won_fights
     */
    public function getWon_fights()
    {
        return $this->won_fights;
    }

    /**
     * Set the value of won_fights
     *
     * @return  self
     */
    public function setWon_fights($won_fights)
    {
        $this->won_fights = $won_fights;

        return $this;
    }

    /**
     * Get the value of lost_fights
     */
    public function getLost_fights()
    {
        return $this->lost_fights;
    }

    /**
     * Set the value of lost_fights
     *
     * @return  self
     */
    public function setLost_fights($lost_fights)
    {
        $this->lost_fights = $lost_fights;

        return $this;
    }

    /**
     * Get the value of ko_fights
     */
    public function getKo_fights()
    {
        return $this->ko_fights;
    }

    /**
     * Set the value of ko_fights
     *
     * @return  self
     */
    public function setKo_fights($ko_fights)
    {
        $this->ko_fights = $ko_fights;

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

    function mapToObject(array $arrayToMap): void
    {
        $this->id = $arrayToMap['id'];
        $this->name = $arrayToMap['name'];
        $this->avatar = $arrayToMap['avatar'];
        $this->score = $arrayToMap['score'];
        $this->fights = $arrayToMap['fights'];
        $this->won_fights = $arrayToMap['won_fights'];
        $this->lost_fights = $arrayToMap['lost_fights'];
        $this->ko_fights = $arrayToMap['ko_fights'];
    }
}
