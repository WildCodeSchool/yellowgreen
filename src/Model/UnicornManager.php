<?php

namespace App\Model;

use PDO;

class UnicornManager extends AbstractManager
{
    public const TABLE = 'unicorn';

    public function selectUnicornWithAttacksById(int $unicornID): array | false
    {
        $statement = $this->pdo->prepare("SELECT att.name AS attName, unicorn.name AS unicornName,
        att.avatar AS attAvatar, att.cost AS attCost, att.gain AS attGain,
        att.successRate AS attSuccessRate FROM " . static::TABLE . "
        JOIN unicorn_attack AS ua ON ua.unicorn_id=:unicornID 
        JOIN attack AS att ON att.id=ua.attack_id");
        $statement->bindValue(':unicornID', $unicornID, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
