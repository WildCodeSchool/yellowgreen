<?php

namespace App\Model;

use App\Model\UserModel;
use App\Model\DatabaseModel;

class DatabaseUser extends DatabaseModel
{
    public function __construct()
    {
        parent::__construct("App\Model\UserModel", "user", [
            "name" => "id",
            "getter" => "getId",
            "setter" => "setId"
        ]);
    }

    public function deleteModelById(int $id): bool
    {
        return $this->deleteModelByProp("id", $id);
    }

    public function deleteModel(UserModel $user): bool
    {
        return $this->deleteModelById($user->getId());
    }
}
