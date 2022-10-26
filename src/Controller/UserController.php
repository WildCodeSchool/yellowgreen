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
        $users = $userManager->selectAll('nickName');

        return $this->twig->render('User/index.html.twig', ['users' => $users]);
    }

    /**
     * Show informations for a specific user
     */
    public function show(int $id): string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        return $this->twig->render('User/show.html.twig', ['user' => $user]);
    }

    /**
     * Edit a specific user
     */
    public function edit(int $id): ?string
    {
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['avatar'])) {
                // $content_dir = 'images/';
                // $tmp_file = $_FILES['avatar']['tmp_name'];
                $nameFile = $_FILES['avatar']['name'];
                $tmpName = $_FILES['avatar']['tmp_name'];
                $name = $_FILES['avatar']['name'];
                // $size = $_FILES['avatar']['size'];
                // $error = $_FILES['avatar']['error'];
                move_uploaded_file($tmpName, 'assets/images/' . $name);

                $_POST['avatar'] = $nameFile;
            }
                 // clean $_POST data
                    $user = array_map('trim', $_POST);
                $userManager->update($user);
                header('Location: /users/show?id=' . $id);
                    return null;
            // TODO validations (length, format...
            // if validation is ok, update and redirection
            // we are redirecting so we don't want any content rendered
        }

        return $this->twig->render('User/editUser.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * Add a new user
     */
    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['avatar'])) {
                $nameFile = $_FILES['avatar']['name'];
                $tmpName = $_FILES['avatar']['tmp_name'];
                $name = $_FILES['avatar']['name'];
                // $size = $_FILES['avatar']['size'];
                // $error = $_FILES['avatar']['error'];
                move_uploaded_file($tmpName, 'assets/images/' . $name);
                if ($_FILES['avatar']['name'] === '') {
                    $_POST['avatar'] = 'img_avatar.png';
                } else {
                    $_POST['avatar'] = $nameFile;
                }
            }

            $user = array_map('trim', $_POST);
            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $userManager = new UserManager();
            $id = $userManager->insert($user);

            header('Location:/users/show?id=' . $id);
            return null;
        }

        return $this->twig->render('User/addUser.html.twig');
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
