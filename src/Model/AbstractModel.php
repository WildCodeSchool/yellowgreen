<?php

namespace App\Model;

abstract class AbstractModel
{


    /*recupere les proprietes de l'objet User et ssi elles existent dans 
        $arrayToMap elles y sont affectées*/
    static function mapToObject(array $arrayToMap, string $class): object
    {
        $model = new $class();
        $properties = get_object_vars($model);
        foreach ($properties as $key => $val)
            $model->$key = isset($arrayToMap[$key]) ? $arrayToMap[$key] : $val;
        return $model;
    }
}
