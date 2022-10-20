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
    public function userShow(int $id): string
    {
        $userDb = new UserDB(); //creation de connection DB specif. User
        $user = $userDb->getUserById($id); //recupperation de l'objet User prêt à l'emploi
        $userDb = null; //destruction de la connection

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }


    /* *
     * Add a new item
     **/
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user = new User();  // creation d'un objet User
            $user->arrayToUser($_POST); // mappage array POST vers User
            // TODO validations (length, format...)
            // if validation is ok, insert and redirection
            $userDB = new UserDb(); //creation de connection DB specif. User
            $userDB->addUser($user); // add de objet user en DB renvoie un booleen
            $userDB = null; //destruction de la connection
            header('Location:/users/'); // pour l'instant on revient sur index de home
            return null;
        }

        return $this->twig->render('User/addUser.html.twig');
    }



    /**
     * Edit a specific item
     *
    public function edit(int $id): ?string
    {
        $itemManager = new ItemManager();
        $item = $itemManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $item = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $itemManager->update($item);

            header('Location: /items/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }

        return $this->twig->render('Item/edit.html.twig', [
            'item' => $item,
        ]);
    }
     **
     * Delete a specific item
     *
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $itemManager = new ItemManager();
            $itemManager->delete((int)$id);

            header('Location:/items');
        }
    }
     */
}
