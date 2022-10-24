<?php

namespace App\Model;

use App\Model\Util;
use App\Model\AbstractModel;
use PDO;
use PDOException;

abstract class AbstractDatabase
{
    private PDO $connection;

    public function __construct()
    {
        try { // connection database avec constantes definies dans config.php
            $this->connection = new PDO(DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD);
        } catch (PDOException $err) {
            Util::writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }

    public function getConnect(): PDO
    {
        return $this->connection;
    }


    /** getParamBind(mixed $value)
     *
     *  $value to bind
     *
     *  return an integer PDO flag for the bindValue
     *         PDO function
     *
     */
    private function getParamBind(mixed $value): int
    {
        switch (gettype($value)) {
            case "boolean":
                return PDO::PARAM_BOOL;
            case "integer":
                return PDO::PARAM_INT;
            case "string":
                return PDO::PARAM_STR;
            default:
                return 0;
        }
    }

    /** getAll peut être lancer avec ou sans 3e, 4e 5e parametre,
     *    examples :
     *     getAll() : select * from user;
     *     getAll('user', 'User',[name,email]) : select name,email from user;
     *     getAll('user', 'User',[],['score' => 'DESC', 'name' => 'ASC' ]) :
     *           select * from user ORDER BY score 'DESC', name 'DESC';
     *
     */

    private function getSortString(array $columnsDirectsOrder): string
    {
        $sortStr  = "";
        if ($columnsDirectsOrder) {  //build of optionnal string for sorting the result of SELECT
            // we use the array $columnsDirectsOrder to build this string
            foreach ($columnsDirectsOrder as $column => $direction) {
                $assert = ($sortStr === "" ? " ORDER BY " : ", ") . $column;
                $assert .= " " . ($direction != 'DESC' ? 'ASC' : 'DESC');
                $sortStr .= $assert;
            }
        }
        return $sortStr;
    }

    public function getAll(
        string $class,
        string $tableSql,
        ?array $columns = [],
        ?array $columnsDirectsOrder = [],
    ): array|false {
        $colToRetrieve = "";
        if ($columns) { // build a string with columns if they exist
            foreach ($columns as $col) {
                $colToRetrieve .= ($colToRetrieve ? "," : "") . $col;
            }
        } else //if this string is empty
        {
            $colToRetrieve = "*";
        }
        $query = "SELECT " . $colToRetrieve . " FROM " . $tableSql; //build of string $query

        $query .= $this->getSortString($columnsDirectsOrder);
        Util::writeLog($query);
        $all = array();
        try {
            $statement = $this->connection->query($query);      //execute the query
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);   //fetch all rows of select
            foreach ($result as $res) {         //for each row we build an object of $class
                $model = new $class();          // this object must extend the
                $all[] = $model->arrayToObject($res);   // AbstractModel and we use
            }                                           // arrayToObject to map values from
            return $all;                                // array $res to object model
        } catch (PDOException $err) {
            Util::writeLog("Error DB Get All Rows : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getRowByProp(string $class, string $tableSql, string $column, mixed $value): object|false
    {
        try { //we build query select with table $tableSql and param to bind :$column
            $query = "SELECT * FROM " . $tableSql . " WHERE " . $column . " = :" .  $column . ";";
            $statement = $this->connection->prepare($query); //prepare to execute
            $statement->bindValue(':' . $column, $value, $this->getParamBind($value));  // bind the $value to :$column
            $statement->execute();                                                      // using getParamBind method
            $result = $statement->fetch(PDO::FETCH_ASSOC);                              // returning the BDO::PARAM_???
            $model = ($result ? (new $class())->arrayToObject($result) : false); //use method of AbstractModel
            return $model;                                                       // to build $model
        } catch (PDOException $err) {
            Util::writeLog("Error DB Get Row By Prop : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function addRow(string $tableSql, array $columnsValues): bool
    {
        try {
            if (!$columnsValues) {
                return false;
            }
            $columnsStr = "";
            $valuesStr = "";

            foreach ($columnsValues as $col => $val) {
                $columnsStr .= ($columnsStr != "" ? "," : "") . $col;
                $valuesStr .= ($valuesStr != "" ? ", :" : ":") . $col;
            }
            $query = "INSERT INTO " . $tableSql . " (" . $columnsStr . ") VALUES (" . $valuesStr . ");";
            $statement = $this->connection->prepare($query);
            foreach ($columnsValues as $col => $val) {
                $statement->bindValue(":" . $col, $val, $this->getParamBind($val));
            }
            $statement->execute();
            return true;
        } catch (PDOException $err) {
            Util::writeLog("Error DB Add Row : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function deleteRow(string $tableSql, string $column, mixed $value): bool
    {
        try {
            $query = "DELETE FROM " . $tableSql . " WHERE " . $column . " = :" . $column . ";";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":" . $column, $value, $this->getParamBind($value));
            $statement->execute();
            return true;
        } catch (PDOException $err) {
            Util::writeLog("Error DB Add Row : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function updateRow(
        string $tableSql,
        array $columnsValues,
        string $columnTarget,
        mixed $valueTarget
    ): bool {
        try {
            $setStr = "";
            foreach ($columnsValues as $col => $val) {
                if ($val !== "") {
                    $setStr .= ($setStr != "" ? ", " : "") . $col . " = :" . $col;
                }
            }
            $query = "UPDATE " . $tableSql . " SET " . $setStr . " WHERE " .
                $columnTarget . " = :" . $columnTarget . ";";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":" . $columnTarget, $valueTarget, $this->getParamBind($valueTarget));
            foreach ($columnsValues as $col => $val) {
                if ($val !== "") {
                    $statement->bindValue(":" . $col, $val, $this->getParamBind($val));
                }
            }
            $statement->execute();
            return true;
        } catch (PDOException $err) {
            Util::writeLog("Error DB Add Row : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }
}
