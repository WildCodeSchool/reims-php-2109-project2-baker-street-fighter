<?php

namespace App\Controller;

use App\Model\FightManager;

class FightController extends AbstractController
{
    /**
     * Add a new fight
     */
    public function add(): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // clean $_POST data
            $fight = array_map('trim', $_POST);

            // TODO validations (length, format...)

            // if validation is ok, insert and redirection
            $fightManager = new FightManager();
            $id = $fightManager->insert($fight);
            header('Location:/fights/show?id=' . $id);
        }
        return $this->twig->render('Fight/add.html.twig');
     }

    public function index(): string
    {
        $fightManager = new FightManager();
        $fights = $fightManager->selectAll('date');

        return $this->twig->render('fight/index.html.twig', ['fights' => $fights]);
    }
}
