<?php

namespace App\Model;

use PDO;

class UserManager extends AbstractManager
{
    public const TABLE = 'user';

    /**
     * Insert new user in database and retrieve the id
     */
    public function insert(array $user): int|array
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (firstName, lastName, nickName, email,
        passWord, avatar, description) VALUES (:firstName, :lastName, :nickName,
        :email, :passWord, :avatar, :description)");
        $statement->bindValue('firstName', $user['firstName'], PDO::PARAM_STR);
        $statement->bindValue('lastName', $user['lastName'], PDO::PARAM_STR);
        $statement->bindValue('nickName', $user['nickName'], PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue('passWord', $user['passWord'], PDO::PARAM_STR);
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
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET firstName = :firstName, lastName = :lastName,
                nickName = :nickName, email = :email, avatar = :avatar,
                description = :description, score = :score WHERE id=:id");
        $statement->bindValue('id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue('firstName', $user['firstName'], PDO::PARAM_STR);
        $statement->bindValue('lastName', $user['lastName'], PDO::PARAM_STR);
        $statement->bindValue('nickName', $user['nickName'], PDO::PARAM_STR);
        $statement->bindValue('email', $user['email'], PDO::PARAM_STR);
        $statement->bindValue('avatar', $user['avatar'], PDO::PARAM_STR);
        $statement->bindValue('description', $user['description'], PDO::PARAM_STR);
        $statement->bindValue('score', $user['score'], PDO::PARAM_INT);
        return $statement->execute();
    }

    public function updateScore(array $user): bool
    {
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE . " SET score = :score WHERE id=:id");
        $statement->bindValue('id', $user['id'], PDO::PARAM_INT);
        $statement->bindValue('score', $user['score'], PDO::PARAM_INT);
        return $statement->execute();
    }

    public function selectOneByEmail(string $email): array | false
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE email=:email");
        $statement->bindValue(':email', $email, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }

    public function selectRandomUsers(int $userId): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE .
            " WHERE id <> " . $userId  . " ORDER BY RAND() LIMIT 5");
        $statement->execute();
        return $statement->fetchAll();
    }

    public function delete(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue(':id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
