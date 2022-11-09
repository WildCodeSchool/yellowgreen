<?php

namespace App\Model;

use PDO;

class AttackManager extends AbstractManager
{
    public const TABLE = 'attack';

    public function selectUnicornWithAttacksById(int $unicornID): array | false
    {
        $statement = $this->pdo->prepare("SELECT att.name AS attName, 
    att.avatar AS attAvatar, att.cost AS attCost, att.gain AS attGain, att.id AS attId,
    att.successRate AS attSuccessRate FROM " . static::TABLE . " as att " .
            "JOIN unicorn_attack AS ua ON ua.unicorn_id=:unicornID and ua.attack_id = att.id");
        $statement->bindValue(':unicornID', $unicornID, \PDO::PARAM_INT);
        $statement->execute();
        return $statement->fetchAll();
    }
}
