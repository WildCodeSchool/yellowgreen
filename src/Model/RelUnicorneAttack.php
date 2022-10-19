<?php

namespace App\Model;

class RelUnicorneAttack
{
    private int $unicorne_id;
    private int $attack_id;

    public function __construct(int $unicorne_id = 0, int $attack_id = 0)
    {
        $this->unicorne_id = $unicorne_id;
        $this->attack_id = $attack_id;
    }

    /**
     * Get the value of unicorne_id
     */
    public function getUnicorne_id()
    {
        return $this->unicorne_id;
    }

    /**
     * Set the value of unicorne_id
     *
     * @return  self
     */
    public function setUnicorne_id($unicorne_id)
    {
        $this->unicorne_id = $unicorne_id;

        return $this;
    }

    /**
     * Get the value of attack_id
     */
    public function getAttack_id()
    {
        return $this->attack_id;
    }

    /**
     * Set the value of attack_id
     *
     * @return  self
     */
    public function setAttack_id($attack_id)
    {
        $this->attack_id = $attack_id;

        return $this;
    }

    function mapToObject(array $arrayToMap): void
    {
        $this->unicorne_id = $arrayToMap['unicorne_id'];
        $this->attack_id = $arrayToMap['attack_id'];
    }
}
