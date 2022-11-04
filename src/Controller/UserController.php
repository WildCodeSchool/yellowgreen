<?php

namespace App\Controller;

use App\Model\UserManager;
use PDOException;

class UserController extends AbstractController
{
    /**
     * List users
     */
    public function index(): string
    {
        $userManager = new UserManager();
        $users = $userManager->selectAll("score", "desc");

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
                $nameFile = $_FILES['avatar']['name'];
                $tmpName = $_FILES['avatar']['tmp_name'];
                $name = $_FILES['avatar']['name'];
                // $size = $_FILES['avatar']['size'];
                // $error = $_FILES['avatar']['error'];
                move_uploaded_file($tmpName, 'assets/images/profile/' . $name);
                $_POST['avatar'] = $nameFile;
            }

            // clean $_POST data
            $user = array_map('trim', $_POST);
            $user = $this->cleanParam($user);

            if ($user) {
                $errors = $this->checkData($user);
            } else {
                $errors[] = "Entrées avec format invalide";
            }

            if (empty($errors)) {
                try {
                    $userManager->update($user);
                } catch (PDOException $err) {
                    $errors[] = $err->getMessage();
                }
            }
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

    public function checkName(string $key, mixed $value): array
    {
        $errors = array();
        if (!isset($value) || $value === '') {
            $errors[] = $key . " is required";
        } elseif (strlen($value) > 45 || strlen($value) < 2) {
            $errors[] = "Your " . $key . " must be between 2 and 45 characters";
        }
        return $errors;
    }

    public function checkEmail(mixed $value): array
    {
        $errors = array();
        if ($value === '') {
            $errors[] = "Email is required";
        } else {
            $value = filter_var($value, FILTER_VALIDATE_EMAIL);
            if (!$value) {
                $errors[] = $value . "is not a valid email address";
            }
        }
        return $errors;
    }

    public function checkPassword(mixed $value): array
    {
        $errors = array();
        if (!isset($value) || $value === '') {
            $errors[] = "Password is required";
        } elseif (strlen($value) > 45 || strlen($value) < 9) {
            $errors[] = "Your password must be between 8 and 45 characters";
        } else {
            $value = password_hash($value, PASSWORD_ARGON2ID);
        }
        return $errors;
    }

    public function checkData(array $user): array
    {
        $errors = array();
        foreach ($user as $key => $value) {
            switch ($key) {
                case 'firstName':
                case 'lastName':
                case 'nickName':
                    $errors = array_merge($errors, $this->checkName($key, $value));
                    break;
                case 'email':
                    $errors = array_merge($errors, $this->checkEmail($value));
                    break;
                case 'passWord':
                    $errors = array_merge($errors, $this->checkPassword($value));
                    break;
                default:
            }
        }
        return $errors;
    }
    /**
     * Add a new user
     */
    public function add(): ?string
    {
        $errors = array();
        $user = array();
        $id = -1;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['avatar'])) {
                $nameFile = $_FILES['avatar']['name'];
                $tmpName = $_FILES['avatar']['tmp_name'];
                $name = $_FILES['avatar']['name'];
                // $size = $_FILES['avatar']['size'];
                // $error = $_FILES['avatar']['error'];
                move_uploaded_file($tmpName, 'assets/images/profile/' . $name);
                if ($_FILES['avatar']['name'] === '') {
                    $_POST['avatar'] = 'img_avatar.png';
                } else {
                    $_POST['avatar'] = $nameFile;
                }
            }

            $user = array_map('trim', $_POST);
            $user = $this->cleanParam($user);
            if ($user) {
                $errors = $this->checkData($user);
            } else {
                $errors[] = "Entreè(s) avec format invalide";
            }
            // if validation is ok, insert and redirection
            $userManager = new UserManager();
            if (empty($errors)) {
                try {
                    $id = $userManager->insert($user);
                } catch (PDOException $err) {
                    $errors[] = $err->getMessage();
                }
            }
        }

        if (!empty($errors)) {
            return $this->twig->render('Rules/index.html.twig', ["errors" => $errors, "user" => $user]);
        } else {
            $_SESSION['userId'] = $id;
            header('Location:/users/show?id=' . $id);
            return null;
        }
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
