<?php

namespace App\Model;

use PDOException;
use App\Model\User;

class UserDb extends Database
{
    public function getAllUsers()
    {
        $this->getAll("App\Model\User", "user");
    }

    public function getUserById(int $id)
    {
        $this->getRowById("App\Model\User", "user", $id);
    }

    public function getUserByName(string $name)
    {
        $this->getRowByName("App\Model\User", "user", $name);
    }

    public function addUser(User $user): bool
    {
        $columnsValues = $user->objectToArray("App\Model\User");
        $check = $this->addRow("user", $columnsValues);
        if ($check) {
            try {
                $user->setId($this->getConnect()->lastInsertId());
                return true;
            } catch (PDOException $err) {
                $this->util->writeLog($err);
            }
        }
        return false;
    }

    public function deleteUserById(int $id): bool
    {
        return $this->deleteRow("user", "id", $id);
    }

    public function deleteUser(User $user): bool
    {
        return $this->deleteUserById($user->getId());
    }

    public function updateUser(User $user): bool
    {
        $columnsValues = $user->objectToArray("App\Model\User");
        return $this->updateRow("user", $columnsValues, "id", $user->getId());
    }
}
