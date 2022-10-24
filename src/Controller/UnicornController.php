<?php

namespace App\Controller;

use App\Model\DatabaseUnicorn;
use App\Model\UnicornModel;
use App\Model\Util;

class UnicornController extends AbstractController
{
    /**
     * List users
     */
    public function unicornIndex(): string
    {
        $unicornDB = new DatabaseUnicorn(); //creation de connection DB specif. Unicorn
        $unicorns = $unicornDB->getModels(['score' => 'DESC', 'name' => 'ASC']); //recuperation
        $unicornDB = null; //d'un tableau d'objets Unicorn pret à l'emploi
        //destruction de la connection
        return $this->twig->render('Unicorn/index.html.twig', ['unicorns' => $unicorns]);
    }

    /* *
     * Add a new item
     **/
    public function addUnicorn(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = Util::cleanParam($_POST);
            if ($data) {
                // TODO validations (length, format...)
                $unicorn = new UnicornModel();  // creation d'un objet UnicornModel
                $unicorn->arrayToObject($data); // mappage array POST vers UnicornModel
                $unicornDB = new DatabaseUnicorn(); //creation de connection DB specif. Unicorn
                $unicornDB->addModel($unicorn); // add de objet user en DB renvoie un booleen
                $unicornDB = null; //destruction de la connection
                header('Location:/unicorns/show?id=' . $unicorn->getId()); // on embraye pour l'instant sur page show
                return null;
            }
        }

        return $this->twig->render('Unicorn/addUnicorn.html.twig');
    }
}
