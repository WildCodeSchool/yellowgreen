<?php

namespace App\Model;

use PDOException;
use App\Model\User;

class UserDb extends Database
{
    private static string $tableSql = "user";
    private static string $classPath = "App\Model\User";

    public function getAllUsers(): array | false
    {
        return $this->getAll(self::$classPath, self::$tableSql);
    }

    public function getUserById(int $id): AbstractModel|false
    {
        return $this->getRowByProp(self::$classPath, self::$tableSql, 'id', $id);
    }

    public function getUserByName(string $name): AbstractModel|false
    {
        return $this->getRowByName(self::$classPath, self::$tableSql, $name);
    }

    public function addUser(User $user): bool
    {
        $columnsValues = $user->userToArray(['id']);


        $check = $this->addRow(self::$tableSql, $columnsValues);
        if ($check) {
            try {
                $id = $this->getConnect()->lastInsertId();
                $user->setId($id);
                return true;
            } catch (PDOException $err) {
                $this->util->writeLog($err);
            }
        }
        return false;
    }

    public function deleteUserById(int $id): bool
    {
        return $this->deleteRow(self::$tableSql, "id", $id);
    }

    public function deleteUser(User $user): bool
    {
        return $this->deleteUserById($user->getId());
    }

    public function updateUser(User $user): bool
    {
        $columnsValues = $user->userToArray(['id']);
        return $this->updateRow(self::$tableSql, $columnsValues, "id", $user->getId());
    }
}
