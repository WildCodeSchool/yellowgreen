<?php

namespace App\Model;

use App\Model\Util;
use App\Model\AbstractModel;
use PDO;
use PDOException;

class Database
{
    private \PDO $connection;
    private Util $util;

    public function __construct()
    {
        $this->util = new Util();
        try {
            $this->connection = new PDO(APP_DB_HOST . ";dbname=" . APP_DB_NAME, APP_DB_USER, APP_DB_PASSWORD);
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }

    public function getConnect(): \PDO
    {
        return $this->connection;
    }

    /** getAll peut être lancer avec ou sans 3e parametre,
     *    examples :
     *     getUsers() : select * from user;
     *     getUsers('user', 'User',[name,email]) : select name,email from user;
     */

    public function getAll(string $tableSql, string $class, array $columns = null): array|false
    {
        $users = array();

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
                $users[] = AbstractModel::mapToObject($res, $class); /*utilisation fonction static de abstract model*/
            }
            return $users;
        } catch (PDOException $err) {
            $this->util->writeLog("Error DB Get User By Id : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }
}
