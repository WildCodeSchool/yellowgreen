<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    /**
     * Insert new user in database
     */
    public function insert(array $user): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (`firstname`, `lastname`, `nickname`, `email`, `avatar`, `description`) VALUES (:firstname, :lastname, :nickname, :email, :avatar, :description)");
        $statement->bindValue('firstname', $user['firstname'], PDO::PARAM_STR);
        $statement->bindValue('lastname', $user['lastname'], PDO::PARAM_STR);
        $statement->bindValue('nickname', $user['nickname'], PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue('avatar', $user['avatar'], PDO::PARAM_STR);
        $statement->bindValue('description', $user['description'], PDO::PARAM_STR);


        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    /**
     * Update user in database
     */
    public function update(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET `title` = :title WHERE id=:id");
        $statement->bindValue('id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue('title', $user['title'], PDO::PARAM_STR);

        return $statement->execute();
    }
}
