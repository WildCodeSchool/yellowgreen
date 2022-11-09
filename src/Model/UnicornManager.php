<?php

namespace App\Model;

class UnicornManager extends AbstractManager
{
    public const TABLE = 'unicorn';

    public function selectAll(string $orderBy = '', string $direction = 'ASC'): array
    {
        $query = 'SELECT unicorn.id AS unicornId, att.name AS attName, unicorn.name AS unicornName, 
        unicorn.avatar AS unicornAvatar, att.avatar AS attAvatar,
        att.cost AS attCost, att.gain AS attGain, att.successRate AS attSuccessRate FROM ' . static::TABLE . '
        JOIN unicorn_attack AS ua ON ua.unicorn_id=unicorn.id
        JOIN attack AS att ON att.id=ua.attack_id';

        if ($orderBy) {
            $query .= ' ORDER BY ' . $orderBy . ' ' . $direction;
        }
        return $this->pdo->query($query)->fetchAll();
    }

    public function selectUnicornWithAttacksById(int $unicornID): array | false
    {
        $statement = $this->pdo->prepare("SELECT att.name AS attName, unicorn.name AS unicornName,
        att.avatar AS attAvatar, att.cost AS attCost, att.gain AS attGain, att.successRate AS attSuccessRate
        FROM " . static::TABLE . "
        JOIN unicorn_attack AS ua ON ua.unicorn_id=:unicornID
        JOIN attack AS att ON att.id=ua.attack_id");
        $statement->bindValue(':unicornID', $unicornID, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
