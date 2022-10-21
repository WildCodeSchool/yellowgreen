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
        try {
            $this->connection = new PDO(APP_DB_HOST . ";dbname=" . APP_DB_NAME, APP_DB_USER, APP_DB_PASSWORD);
        } catch (PDOException $err) {
            Util::writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }

    public function getConnect(): PDO
    {
        return $this->connection;
    }

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

    /** getAll peut être lancer avec ou sans 3e parametre,
     *    examples :
     *     getUsers() : select * from user;
     *     getUsers('user', 'User',[name,email]) : select name,email from user;
     */

    public function getAll(
        string $class,
        string $tableSql,
        ?array $columns = [],
        ?string $columnOrder = "",
        ?string $directionOrder = "ASC"
    ): array|false {
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
        $query = "SELECT" . $colToRetrieve . " FROM " . $tableSql;
        if ($columnOrder) {
            $query .= ' ORDER BY ' . $columnOrder . ' ' . $directionOrder;
        }
        try {
            $statement = $this->connection->query($query);
            $result = $statement->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $res) {
                $all[] = (new $class())->arrayToObject($res);
            }
            return $all;
        } catch (PDOException $err) {
            Util::writeLog("Error DB Get All Rows : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getRowByProp(string $class, string $tableSql, string $col, mixed $value): object|false
    {
        try {
            $query = "SELECT * FROM " . $tableSql . " WHERE " . $col . " = :" .  $col . ";";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(':' . $col, $value, $this->getParamBind($value));
            $statement->execute();
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $row = ($result ? (new $class())->arrayToObject($result) : false); //utilisation fonction de abstract model
            return $row;
        } catch (PDOException $err) {
            Util::writeLog("Error DB Get Row By Prop : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getRowByName(string $class, string $tableSql, string $name): AbstractModel|false
    {
        return $this->getRowByProp($class, $tableSql, 'name', $name);
    }

    public function getRowById(string $class, string $tableSql, int $id): AbstractModel|false
    {
        return $this->getRowByProp($class, $tableSql, 'id', $id);
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
