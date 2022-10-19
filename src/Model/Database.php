<?php

namespace App\Model;

use App\Model\Util;
use App\Model\User;
use App\Model\Unicorne;
use App\Model\Attack;
use App\Model\RelUnicorneAttack;
use OndraM\CiDetector\Ci\AbstractCi;

class Database
{
    private \PDO $connection;
    private Util $util;

    public function __construct()
    {
        $this->util = new Util();
        try {
            $this->connection = new \PDO(APP_DB_HOST . ";dbname=" . APP_DB_NAME, APP_DB_USER, APP_DB_PASSWORD);
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Connection : <br>" . $err->getMessage());
        }
    }

    public function getConnect(): \PDO
    {
        return $this->connection;
    }

    /*getUsers peut être lancer avec ou sans parametre, 

        examples :
         getUsers() : select * from user;
         getUsers([name,email]) : select name,email from user;
         
    */

    public function getAll(string $tableSql, string $class, array $columns = null): array|false
    {
        $users = array();

        $colToRetrieve = "";
        $filterSql = "";
        if ($columns)
            for ($i = 0; $i < count($columns); $i++)
                $colToRetrieve .= ($i > 0 ? "," : "") . $columns[$i];
        if ($colToRetrieve === "")
            $colToRetrieve = "*";

        try {
            $query = "SELECT" . $colToRetrieve . " FROM yuy";
            $statement = $this->connection->query($query);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($result as $res)
                $users[] = AbstractModel::mapToObject($res, $class); /*utilisation fonction static de abstract model*/
            return $users;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get User By Id : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }


    public function getUserById(int $id): User|false
    {
        try {
            $query = "SELECT * FROM user WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $id, \PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $user = new User("", "");
            $user->mapToObject($result);
            return $user;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get User By Id : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getUserByName(string $name): User|false
    {
        try {

            $query = "SELECT * FROM user WHERE name = :name;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":name", $name, \PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $user = new User("", "");
            User::mapToObject($result, $user);
            return $user;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get User By Name : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function addUser(User $user): User|false
    {
        try {

            $query = "INSERT INTO user (name,email,avatar,description,score) values (:name, :email, :avatar, :description, :score);";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":name", $user->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), \PDO::PARAM_STR);
            $statement->bindValue(":avatar", $user->getAvatar(), \PDO::PARAM_STR);
            $statement->bindValue(":description", $user->getDescription(), \PDO::PARAM_STR);
            $statement->bindValue(":score", $user->getScore(), \PDO::PARAM_INT);
            $statement->execute();
            $user->setId($this->connection->lastInsertId());
            return $user;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Add User : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function updateUser(User $user): bool
    {
        try {
            $query = "UPDATE user set name = :name, email = :email, avatar = :avatar, description = :description, score = :score WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $user->getId(), \PDO::PARAM_INT);
            $statement->bindValue(":name", $user->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":email", $user->getEmail(), \PDO::PARAM_STR);
            $statement->bindValue(":avatar", $user->getAvatar(), \PDO::PARAM_STR);
            $statement->bindValue(":description", $user->getDescription(), \PDO::PARAM_STR);
            $statement->bindValue(":score", $user->getScore(), \PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Update User : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function deleteUser(User $user): bool
    {
        try {
            $query = "DELETE FROM user WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $user->getId(), \PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Delete User : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }


    public function getUnicornById(int $id): Unicorne|false
    {
        try {
            $query = "SELECT * FROM unicorne WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $id, \PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $unicorne = new Unicorne("", "");
            $unicorne->mapToObject($result);
            return $unicorne;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get Unicorne By Id : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getUnicorneByName(string $name): Unicorne|false
    {
        try {

            $query = "SELECT * FROM unicorne WHERE name = :name;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":name", $name, \PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $unicorne = new Unicorne("", "");
            $unicorne->mapToObject($result);
            return $unicorne;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get Unicorne By Name: <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }


    public function addUnicorne(Unicorne $unicorne): Unicorne|false
    {
        try {
            $query = "INSERT INTO unicorne (name,avatar,score,fights,won_fights,lost_fights,ko_fights) VALUES (:name,:avatar,:score,:fights,:won_fights,:lost_fights,:ko_fights);";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":name", $unicorne->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":avatar", $unicorne->getAvatar(), \PDO::PARAM_STR);
            $statement->bindValue(":score", $unicorne->getScore(), \PDO::PARAM_INT);
            $statement->bindValue(":fights", $unicorne->getFights(), \PDO::PARAM_INT);
            $statement->bindValue(":won_fights", $unicorne->getWon_fights(), \PDO::PARAM_INT);
            $statement->bindValue(":lost_fights", $unicorne->getLost_fights(), \PDO::PARAM_INT);
            $statement->bindValue(":ko_fights", $unicorne->getKo_fights(), \PDO::PARAM_INT);
            $statement->execute();
            $unicorne->setId($this->connection->lastInsertId());
            return $unicorne;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Add Unicorne : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function updateUnicorne(Unicorne $unicorne): bool
    {
        try {
            $query = "UPDATE user set name = :name, avatar = :avatar, fights = :fights, lost_fights = :lost_fights, won_fights = :won_fights, ko_fights = :ko_fights WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $unicorne->getId(), \PDO::PARAM_INT);
            $statement->bindValue(":name", $unicorne->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":avatar", $unicorne->getAvatar(), \PDO::PARAM_STR);
            $statement->bindValue(":fights", $unicorne->getFights(), \PDO::PARAM_INT);
            $statement->bindValue(":ko_fights", $unicorne->getKo_fights(), \PDO::PARAM_INT);
            $statement->bindValue(":won_fights", $unicorne->getWon_fights(), \PDO::PARAM_INT);
            $statement->bindValue(":lost_fights", $unicorne->getLost_fights(), \PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Update Unicorne : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function deleteUnicorne(Unicorne $unicorne): bool
    {
        try {
            $query = "DELETE FROM unicorne WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $unicorne->getId(), \PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Delete Unicorne : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }


    public function getAttackById(int $id): Attack|false
    {
        try {
            $query = "SELECT * FROM unicorne WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $id, \PDO::PARAM_INT);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $attack = new Attack("", "");
            $attack->mapToObject($result);
            return $attack;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get Attack By Id : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getAttackByName(string $name): Attack|false
    {
        try {

            $query = "SELECT * FROM attack WHERE name = :name;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":name", $name, \PDO::PARAM_STR);
            $statement->execute();
            $result = $statement->fetch(\PDO::FETCH_ASSOC);
            $attack = new Attack("", "");
            $attack->mapToObject($result);
            return $attack;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get Attack By Name: <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function addAttack(Attack $attack): Attack|false
    {
        try {
            $query = "INSERT INTO attack (name , avatar, cost, gain, succes_rate) values (:name, :avatar, :cost, :gain, :succes_rate);";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":name", $attack->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":avatar", $attack->getAvatar(), \PDO::PARAM_STR);
            $statement->bindValue(":cost", $attack->getCost(), \PDO::PARAM_INT);
            $statement->bindValue(":gain", $attack->getGain(), \PDO::PARAM_INT);
            $statement->bindValue(":succes_rate", $attack->getSucces_rate());

            $statement->execute();
            $attack->setId($this->connection->lastInsertId());
            return $attack;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Add Attack : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function updateAttack(Attack $attack): bool
    {
        try {
            $query = "UPDATE attack set name = :name, avatar = :avatar, cost = :cost, gain = :gain, succes_rate = :succes_rate WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $attack->getId(), \PDO::PARAM_INT);
            $statement->bindValue(":name", $attack->getName(), \PDO::PARAM_STR);
            $statement->bindValue(":avatar", $attack->getAvatar(), \PDO::PARAM_STR);
            $statement->bindValue(":cost", $attack->getCost(), \PDO::PARAM_INT);
            $statement->bindValue(":gain", $attack->getGain(), \PDO::PARAM_INT);
            $statement->bindValue(":succes_rate", $attack->getSucces_rate());
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Update Attack : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function deleteAttack(Attack $attack): bool
    {
        try {
            $query = "DELETE FROM attack WHERE id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $attack->getId(), \PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Delete Attack : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function getRelUnicorneAttackByUnicorneId(int $unicorne_id): array|false
    {
        try {
            $query = "SELECT * FROM unicorne_attack WHERE unicorne_id = :id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":id", $unicorne_id, \PDO::PARAM_INT);
            $statement->execute();
            $results = $statement->fetchAll(\PDO::FETCH_ASSOC);
            $relsUniAtt = array();
            foreach ($results as $result) {
                $rel = new RelUnicorneAttack();
                $rel->mapToObject($result);
                $relsUniAtt[] = $rel;
            }
            return $relsUniAtt;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Get RelUnicorneAttacks By Unicorne_Id : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function addRelUnicorneAttack(RelUnicorneAttack $RelUnicorneAttack): RelUnicorneAttack|false
    {
        try {
            $query = "INSERT INTO unicorne_attack (unicorne_id, attack_id) values (:unicorne_id, :attack_id);";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":unicorne_id", $RelUnicorneAttack->getUnicorne_id(), \PDO::PARAM_INT);
            $statement->bindValue(":attack_id", $RelUnicorneAttack->getAttack_id(), \PDO::PARAM_INT);
            $statement->execute();
            return $RelUnicorneAttack;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Add Attack : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }

    public function deleteRelUnicorneAttack(RelUnicorneAttack $relUnicorneAttack): bool
    {
        try {
            $query = "DELETE FROM unicorne_attack WHERE unicorne_id = :unicorne_id AND attack_id = :attack_id;";
            $statement = $this->connection->prepare($query);
            $statement->bindValue(":unicorne_id", $relUnicorneAttack->getUnicorne_id(), \PDO::PARAM_INT);
            $statement->bindValue(":attack_id", $relUnicorneAttack->getAttack_id(), \PDO::PARAM_INT);
            $statement->execute();
            return true;
        } catch (\PDOException $err) {
            $this->util->writeLog("Error DB Update Attack : <br>" . $err->getMessage() . "<br>");
        }
        return false;
    }
}
