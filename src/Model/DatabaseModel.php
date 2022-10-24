<?php

namespace App\Model;

use PDOException;
use App\Model\AbstractModel;
use App\Model\Util;

class DatabaseModel extends AbstractDatabase
{
    private string $tableSql = "";   //table name in the mySql database
    private string $classModel = ""; // model must extend AbstractModel
    private array $restrictProperty; // property to not send or to retrieve
    //  after insert it should be in practice only for the auto increment id
    //  ['name' => 'propertyName' , 'getter' => 'getterName', "setter" => "setterName"]
    // in practice with id autoincrement
    // ['name' => "id", "getter" =>"getId", "setter" => "setId"]
    public function __construct(string $classModel, string $tableSql, array $restrictProperty)
    {
        $this->classModel = $classModel;
        $this->tableSql = $tableSql;
        $this->restrictProperty = $restrictProperty;
        parent::__construct();
    }

    public function getModels(?array $columnsDirectsOrder = array()): array | false
    {
        return $this->getAll($this->classModel, $this->tableSql, [], $columnsDirectsOrder);
    }

    public function getModelbBProp(string $property, mixed $value): AbstractModel|false
    {
        return $this->getRowByProp($this->classModel, $this->tableSql, $property, $value);
    }

    public function addModel(AbstractModel $model): bool
    {
        $columnsValues = $model->objectToArray(['id']);


        $check = $this->addRow($this->tableSql, $columnsValues);
        if ($check && $this->restrictProperty) {
            try {
                $id = (int) $this->getConnect()->lastInsertId();
                $setter = $this->restrictProperty['setter'];
                $model->$setter($id);
                return true;
            } catch (PDOException $err) {
                Util::writeLog($err);
            }
        }
        return false;
    }

    public function deleteModelByProp(string $property, mixed $value): bool
    {
        return $this->deleteRow($this->tableSql, $property, $value);
    }

    public function updateModel(AbstractModel $model): bool
    {
        $restrictProp = $this->restrictProperty['name'];
        $columnsValues = $model->objectToArray([$restrictProp]);
        $getter = $this->restrictProperty['getter'];
        return $this->updateRow(
            $this->tableSql,
            $columnsValues,
            $restrictProp,
            $model->$getter()
        );
    }
}
