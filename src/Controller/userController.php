<?php

namespace App\Controller;

use App\Model\UserDb;
use App\Model\User;
use App\Model\Util;

class UserController extends AbstractController
{
    /**
     * List users
     */
    public function userIndex(): string
    {
        $userDB = new UserDb(); //creation de connection DB specif. User
        $users = $userDB->getAllUsers(); //recuperation d'un tableau d'objets User pret à l'emploi
        $userDB = null; //destruction de la connection

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    /**
     * Show informations for a specific item
     */
    public function showUser(int $id): string
    {
        $userDb = new UserDb(); //creation de connection DB specif. User
        $user = $userDb->getUserById($id); //recupperation de l'objet User prêt à l'emploi
        $userDb = null; //destruction de la connection

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }


    /* *
     * Add a new item
     **/
    public function addUser(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();  // creation d'un objet User
            $user->arrayToUser($_POST); // mappage array POST vers User
            // TODO validations (length, format...)
            // if validation is ok, insert and redirection
            $userDB = new UserDb(); //creation de connection DB specif. User
            $userDB->addUser($user); // add de objet user en DB renvoie un booleen
            $userDB = null; //destruction de la connection
            header('Location:/users/show?id=' . $user->getId()); // on embraye pour l'instant sur page show
            return null;
        }

        return $this->twig->render('User/addUser.html.twig');
    }



    /**
     * Edit a specific item
     */
    public function editUser(int $id): ?string
    {
        $userDb = new UserDb();
        $user = $userDb->getUserById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data


            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $user->arrayToUser($_POST);
            $userDb->updateUser($user);
            header('Location: /users/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
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
            $id = trim($_POST['id']);
            $userDb = new UserDb();
            $userDb->deleteUserById((int)$id);
            header('Location:/users');
        }
    }
}
