<?php

namespace App\Model;

abstract class AbstractModel
{
    /* * recupere les proprietes de l'objet User et ssi elles existent dans
     *   $arrayToMap elles y sont affectées
     *
     *  */
    public static function arrayToObject(array $arrayToMap, string $class): object
    {
        $model = new $class();
        $properties = get_object_vars($model);
        foreach ($properties as $key => $val) {
            $model->$key = isset($arrayToMap[$key]) ? $arrayToMap[$key] : $val;
        }
        return $model;
    }

    public static function objectToArray(string $class): array
    {
        $columnsValues = array();
        $properties = get_class_vars($class);
        foreach ($properties as $key => $val) {
            $columnsValues[$key] = $val;
        }
        return $columnsValues;
    }
}
