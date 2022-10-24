<?php

namespace App\Model;

use App\Model\UnicornModel;
use App\Model\DatabaseModel;

class DatabaseUnicorn extends DatabaseModel
{
    public function __construct()
    {
        parent::__construct("App\Model\UnicornModel", "unicorn", [
            "name" => "id",
            "getter" => "getId",
            "setter" => "setId"
        ]);
    }

    public function deleteModelById(int $id): bool
    {
        return $this->deleteModelByProp("id", $id);
    }

    public function deleteModel(UnicornModel $unicorn): bool
    {
        return $this->deleteModelById($unicorn->getId());
    }
}
