<?php

namespace App\Model;

class Attack
{
    private int $id;
    private string $name;
    private string $avatar;
    private int $cost;
    private int $gain;
    private float $succes_rate;

    public function __construct(string $name, string $avatar = "", int $cost = 0, int $gain = 0, float $success = 0)
    {
        $this->name = $name;
        $this->avatar = $avatar;
        $this->cost = $cost;
        $this->gain = $gain;
        $this->succes_rate = $success;
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
     * Get the value of cost
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * Set the value of cost
     *
     * @return  self
     */
    public function setCost($cost)
    {
        $this->cost = $cost;

        return $this;
    }

    /**
     * Get the value of gain
     */
    public function getGain()
    {
        return $this->gain;
    }

    /**
     * Set the value of gain
     *
     * @return  self
     */
    public function setGain($gain)
    {
        $this->gain = $gain;

        return $this;
    }

    /**
     * Get the value of succes_rate
     */
    public function getSucces_rate()
    {
        return $this->succes_rate;
    }

    /**
     * Set the value of succes_rate
     *
     * @return  self
     */
    public function setSucces_rate($succes_rate)
    {
        $this->succes_rate = $succes_rate;

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
        $this->cost = $arrayToMap['cost'];
        $this->gain = $arrayToMap['gain'];
        $this->succes_rate = $arrayToMap['succes_rate'];
    }
}
