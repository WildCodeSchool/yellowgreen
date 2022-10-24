<?php

namespace App\Model;

use PDOException;
use App\Model\UserModel;
use App\Model\Util;

class DatabaseUserModel extends AbstractDatabase
{
    private static string $tableSql = "user";
    private static string $classPath = "App\Model\UserModel";


    public function getAllUsers(?array $columnsDirectsOrder = array()): array | false
    {
        return $this->getAll(self::$classPath, self::$tableSql, [], $columnsDirectsOrder);
    }

    public function getUserById(int $id): UserModel|false
    {
        return $this->getRowByProp(self::$classPath, self::$tableSql, 'id', $id);
    }

    public function getUserByProp(string $property, mixed $value): UserModel|false
    {
        return $this->getRowByProp(self::$classPath, self::$tableSql, $property, $value);
    }

    public function addUser(UserModel $user): bool
    {
        $columnsValues = $user->userToArray(['id']);


        $check = $this->addRow(self::$tableSql, $columnsValues);
        if ($check) {
            try {
                $id = $this->getConnect()->lastInsertId();
                $user->setId((int)$id);
                return true;
            } catch (PDOException $err) {
                Util::writeLog($err);
            }
        }
        return false;
    }

    public function deleteUserById(int $id): bool
    {
        return $this->deleteRow(self::$tableSql, "id", $id);
    }

    public function deleteUser(UserModel $user): bool
    {
        return $this->deleteUserById($user->getId());
    }

    public function updateUser(UserModel $user): bool
    {
        $columnsValues = $user->userToArray(['id']);
        return $this->updateRow(self::$tableSql, $columnsValues, "id", $user->getId());
    }
}
