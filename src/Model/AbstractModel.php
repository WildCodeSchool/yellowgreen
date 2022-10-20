<?php

namespace App\Model;

abstract class AbstractModel
{
    /* * recupere les proprietes de l'objet User et ssi elles existent dans
     *   $arrayToMap elles y sont affectées
     *
     *  */
    public function arrayToObject(array $arrayToMap): object
    {
        $properties = get_object_vars($this);
        foreach ($properties as $key => $val) {
            $this->$key = isset($arrayToMap[$key]) ? $arrayToMap[$key] : $val;
        }
        return $this;
    }

    public function objectToArray(array $restricts): array
    {
        $columnsValues = array();
        $properties = get_object_vars($this);
        foreach ($properties as $key => $val) {
            if (!in_array($key, $restricts)) {
                $columnsValues[$key] = $val;
            }
        }
        return $columnsValues;
    }
}
