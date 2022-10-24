<?php

namespace App\Controller;

use App\Model\DatabaseUser;

class UserControllerBis extends AbstractController
{
    /**
     * List users
     */
    public function userIndex(): string
    {
        $userDB = new DatabaseUser(); //creation de connection DB specif. User
        $users = $userDB->getModels(['score' => 'DESC', 'name' => 'ASC']); //recuperation
        $userDB = null;  //d'un tableau d'objets User pret à l'emploi et destruction de la connection

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }
}
