<?php

namespace App\Model;

use App\Model\AttackModel;
use App\Model\DatabaseModel;

class DatabaseAttack extends DatabaseModel
{
    public function __construct()
    {
        parent::__construct("App\Model\AttackModel", "attack", [
            "name" => "id",
            "getter" => "getId",
            "setter" => "setId"
        ]);
    }

    public function deleteModelById(int $id): bool
    {
        return $this->deleteModelByProp("id", $id);
    }

    public function deleteModel(AttackModel $attack): bool
    {
        return $this->deleteModelById($attack->getId());
    }
}
