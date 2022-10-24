<?php

namespace App\Controller;

use App\Model\DatabaseAttack;
use App\Model\AttackModel;
use App\Model\Util;

class AttackController extends AbstractController
{
    /**
     * List attacks
     */
    public function attackIndex(): string
    {
        $attackDB = new DatabaseAttack(); //creation de connection DB specif. AttackModel
        $attacks = $attackDB->getModels(['gain' => 'DESC', 'name' => 'ASC']); //recuperation
        $attackDB = null;   //d'un tableau d'objets AttackModel pret à l'emploi
        //destruction de la connection
        return $this->twig->render('Attack/index.html.twig', ['attacks' => $attacks]);
    }

    /* *
     * Add a new attack
     **/
    public function addAttack(): ?string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = Util::cleanParam($_POST);
            if ($data) {
                // TODO validations (length, format...)
                $attack = new AttackModel();  // creation d'un objet AttackModel
                $attack->arrayToObject($data); // mappage array POST vers AttackModel
                $attackDb = new DatabaseAttack(); //creation de connection DB specif. AttackModel
                $attackDb->addModel($attack); // add de objet user en DB renvoie un booleen
                $attackDb = null; //destruction de la connection
                header('Location:/attacks/show?id=' . $attack->getId()); // on embraye pour l'instant sur page show
                return null;
            }
        }

        return $this->twig->render('Attack/addAttack.html.twig');
    }
}
