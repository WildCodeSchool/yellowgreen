<?php

namespace App\Model;

use App\Model\Util;
use App\Model\AbstractModel;
use PDO;
use PDOException;

abstract class Database
{
    private PDO $connection;
    protected Util $util;

    public function __construct()
    {
        $this->util = new Util();
        try {
            $this->connection = new PDO(APP_DB_HOST . ";dbname=" . APP_DB_NAME, APP_DB_USER, APP_DB_PASSWORD);
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }

    public function getConnect(): PDO
    {
        return $this->connection;
    }

    private function getParamBind(mixed $value): null|int
    {
        switch (gettype($value)) {
            case "boolean":
                return PDO::PARAM_BOOL;
            case "integer":
                return PDO::PARAM_INT;
            case "string":
                return PDO::PARAM_STR;
            default:
                return null;
        }
    }

    /** getAll peut être lancer avec ou sans 3e parametre,
     *    examples :
     *     getUsers() : select * from user;
     *     getUsers('user', 'User',[name,email]) : select name,email from user;
     */

    public function getAll(string $class, string $tableSql, array $columns = null): array|false
    {
        $all = array();

        $colToRetrieve = "";
        $count = count($columns);
        if ($columns) {
            for ($i = 0; $i < $count; $i++) {
                $colToRetrieve .= ($i > 0 ? "," : "") . $columns[$i];
            }
        }
        if ($colToRetrieve === "") {
            $colToRetrieve = "*";
        }

        try {
            $query = "SELECT" . $colToRetrieve . " FROM " . $tableSql;
            $statement = $this->connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $res) {
                $all[] = AbstractModel::arrayToObject($res, $class); /*utilisation fonction static de abstract model*/
            }
            return $all;
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Get All Rows : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getRowByProp(string $class, string $tableSql, string $col, mixed $value): AbstractModel|false
    {
        try {
            $query = "SELECT * FROM " . $tableSql . " WHERE " . $col . " = :" .  $col . ";";
            $statement = $this->connection->prepare($query);

            $statement->bindValue(':' . $col, $value, $this->getParamBind($value));
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $row = AbstractModel::arrayToObject($result, $class); /*utilisation fonction static de abstract model*/
            return $row;
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Get Row By Prop : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getRowByName(string $class, string $tableSql, string $name): AbstractModel|false
    {
        return $this->getRowByProp($tableSql, $class, 'name', $name);
    }

    public function getRowById(string $class, string $tableSql, int $id): AbstractModel|false
    {
        return $this->getRowByProp($tableSql, $class, 'name', $id);
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
            $this->util->writeLog("Error DB Add Row : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function deleteRow(string $tableSql, string $column, mixed $value): bool
    {
        try {
            $query = "DELETE FROM " . $tableSql . " WHERE " . $column . " = :" . $column . ");";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":" . $column, $value, $this->getParamBind($value));
            $statement->execute();
            return true;
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Add Row : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function updateRow(
        string $tableSql,
        array $columnsValues,
        string $columnTarget,
        string $valueTarget
    ): bool {
        try {
            $setStr = "";
            foreach ($columnsValues as $col => $val) {
                $setStr .= ($setStr != "" ? ", " : "") . $col . " = " . $val;
            }
            $query = "UPDATE INTO " . $tableSql . " SET " . $setStr . " WHERE " .
                $columnTarget . " = :" . $columnTarget . ";";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":" . $columnTarget, $valueTarget, $this->getParamBind($valueTarget));
            $statement->execute();
            return true;
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Add Row : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }
}
