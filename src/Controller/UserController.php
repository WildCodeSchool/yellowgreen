<?php

namespace App\Controller;

use App\Model\DatabaseUserModel;
use App\Model\UserModel;
use App\Model\Util;

class UserController extends AbstractController
{
    /**
     * List users
     */
    public function userIndex(): string
    {
        $userDB = new DatabaseUserModel(); //creation de connection DB specif. User
        $users = $userDB->getAllUsers(['score' => 'DESC', 'name' => 'ASC']); //recuperation
        $userDB = null; //d'un tableau d'objets User pret à l'emploi et destruction de la connection

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    /**
     * Show informations for a specific item
     */
    public function showUser(int $id): string
    {
        $userDb = new DatabaseUserModel(); //creation de connection DB specif. User
        $user = $userDb->getUserById((int)$id); //recupperation de l'objet User prêt à l'emploi
        $userDb = null; //destruction de la connection

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }


    /* *
     * Add a new item
     **/
    public function addUser(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = Util::cleanParam($_POST);
            if ($data) {
                // TODO validations (length, format...)
                $user = new UserModel();  // creation d'un objet User
                $user->arrayToUser($data); // mappage array POST vers User
                $userDB = new DatabaseUserModel(); //creation de connection DB specif. User
                $userDB->addUser($user); // add de objet user en DB renvoie un booleen
                $userDB = null; //destruction de la connection
                header('Location:/users/show?id=' . $user->getId()); // on embraye pour l'instant sur page show
                return null;
            }
        }

        return $this->twig->render('User/addUser.html.twig');
    }



    /**
     * Edit a specific item
     */
    public function editUser(int $id): ?string
    {
        $userDb = new DatabaseUserModel();
        $user = $userDb->getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = Util::cleanParam($_POST);
            if ($data) {
                // TODO validations (length, format...)
                $user->arrayToUser($_POST);
                $userDb->updateUser($user);
                header('Location: /users/show?id=' . $id);
                // we are redirecting so we don't want any content rendered
            }
            return null;
        }

        return $this->twig->render('User/editUser.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Delete a specific item
     */
    public function deleteUser(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = Util::cleanParam($_POST);
            if ($data) {
                $userDb = new DatabaseUserModel();
                $userDb->deleteUserById((int)($data['id']));
                header('Location:/users');
            }
        }
    }
}
