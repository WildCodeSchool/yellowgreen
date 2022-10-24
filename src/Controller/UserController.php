<?php

namespace App\Controller;

use App\Model\UserManager;

class UserController extends AbstractController
{
    /**
     * List users
     */
    public function index(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll('title');

        return $this->twig->render('user/index.html.twig', ['users' => $users]);
    }

    /**
     * Show informations for a specific user
     */
    public function show(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * Edit a specific user
     */
    public function edit(int $id): ?string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, update and redirection
            $userManager->update($user);

            header('Location: /users/show?id=' . $id);

            // we are redirecting so we don't want any content rendered
            return null;
        }

        return $this->twig->render('user/edit.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Add a new user
     */
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $userManager = new UserManager();
            // $id = $userManager->insert($user);
            $userManager->insert($user);

            //header('Location:/users/show?id=' . $id);
            header('Location: /');
            return null;
        }

        return $this->twig->render('user/add.html.twig');
    }

    /**
     * Delete a specific user
     */
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = trim($_POST['id']);
            $userManager = new UserManager();
            $userManager->delete((int)$id);

            header('Location:/users');
        }
    }
}
