<?php

namespace App\Model;

use App\Model\AbstractModel;

class AttackModel extends AbstractModel
{
    protected int $id;
    protected string $name;
    protected string $avatar;
    protected int $cost = 0;
    protected int $gain = 0;
    protected int $successRate = 50;


    public function __construct(
        string $name = "name",
        string $avatar = "",
        ?int $cost = 0,
        ?int $gain = 0,
        ?int $successRate = 0,
    ) {
        $this->id = -1;
        $this->name = $name;
        $this->avatar = $avatar;
        $this->cost = $cost;
        $this->gain = $gain;
        $this->successRate = $successRate;
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
     * Get the value of successRate
     */
    public function getSuccessRate()
    {
        return $this->successRate;
    }

    /**
     * Set the value of successRate
     *
     * @return  self
     */
    public function setSuccessRate($successRate)
    {
        $this->successRate = $successRate;

        return $this;
    }
}
