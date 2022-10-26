<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig');
    }

    public function add(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $user = array_map('trim', $_POST);
            //img upload



            if(isset($_FILES['avatar'])){
                $name_file = $_FILES['avatar']['name'];
                $tmpName = $_FILES['avatar']['tmp_name'];
                $name = $_FILES['avatar']['name'];
                // $size = $_FILES['avatar']['size'];
                // $error = $_FILES['avatar']['error'];
                move_uploaded_file($tmpName, 'assets/images/'.$name);

                $_POST['avatar'] = $name_file;
            }

            $userManager = new UserManager();
            $id = $userManager->insert($user);

            header('Location:/users/show?id=' . $id);
            return null;
        }

        return $this->twig->render('User/addUser.html.twig');
    }
}
