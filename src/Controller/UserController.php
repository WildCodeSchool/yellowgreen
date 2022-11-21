<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Utils\UserUtils;
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
        $errors = array();
        $user = array();
        $userManager = new UserManager();
        $user = $userManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_FILES['avatar']['name'] !== '') {
                $uploadDir = 'assets/images/profile/';
                $tempName = explode(".", $_FILES["avatar"]["name"]);
                $newName = round(microtime(true)) . '.' . end($tempName);
                $uploadFile = $uploadDir . $newName;

                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);

                if ($_FILES['avatar']['name'] == '') {
                    $_POST['avatar'] = 'img_avatar.png';
                } else {
                    $_POST['avatar'] = $newName;
                    $user['avatar'] = $newName;
                }
            }

            $_POST['avatar'] = $user['avatar'];
            $user = array_map('trim', $_POST);
            $user = $this->cleanParam($user);
            if ($user) {
                $result = UserUtils::checkData($user);
                $user = $result['user'];
                $errors = $result['errors'];
            } else {
                $errors[] = "Entrées avec format invalide";
            }

            if (empty($errors)) {
                try {
                    $userManager->update($user);
                    $_SESSION['nickName'] = $user['nickName'];
                    // $_SESSION['passWord'] = $user['passWord'];
                    header('Location:/users/show?id=' . $id);
                    return null;
                } catch (PDOException $err) {
                    $errors[] = $err->getMessage();
                }
            }
        }

        return $this->twig->render('User/editUser.html.twig', ['errors' => $errors, 'user' => $user]);
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
                $uploadDir = 'assets/images/profile/';
                $tempName = explode(".", $_FILES["avatar"]["name"]);
                $newName = round(microtime(true)) . '.' . end($tempName);
                $uploadFile = $uploadDir . $newName;

                move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadFile);
                if ($_FILES['avatar']['name'] === '') {
                    $_POST['avatar'] = 'img_avatar.png';
                } else {
                    $_POST['avatar'] = $newName;
                }
            }

            $user = array_map('trim', $_POST);
            $user = $this->cleanParam($user);
            if ($user) {
                $result = UserUtils::checkData($user);
                $errors = $result['errors'];
                $user = $result['user'];
            } else {
                $errors[] = "Entrée(s) avec format invalide";
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
            $_SESSION['nickName'] = $user['nickName'];
            $_SESSION['passWord'] = $user['passWord'];
            header('Location:/users');
            return null;
        }
    }

    /**
     * Delete a specific user
     */
    public function delete(): void
    {
        $id = $_SESSION['userId'];
        $userManager = new UserManager();
        $userManager->delete((int)$id);
        session_destroy();
        header("location: /");
    }

    public function login(): string
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $cleanValue = htmlentities(trim($_POST["email"]));
            if (filter_var($cleanValue, FILTER_VALIDATE_EMAIL)) {
                $userManager = new UserManager();
                $user = $userManager->selectOneByEmail($_POST["email"]);
                if ($user && password_verify($_POST["passWord"], $user["passWord"])) {
                    $_SESSION['userId'] = $user["id"];
                    $_SESSION['nickName'] = $user["nickName"];
                    $_SESSION['passWord'] = $user['passWord'];
                    header("location: /rules");
                }
            }
        }
        return $this->twig->render('Home/index.html.twig');
    }

    public function logout()
    {
        session_destroy();
        header("location: /");
    }
}
