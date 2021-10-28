<?php

namespace App\Controller;

use App\Model\FighterManager;
use App\Model\FightManager;
use App\Entity\Fighter;

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

    public function fight(): string
    {
        $fighterManager = new FighterManager();

        $fighter1AsArray = $fighterManager->selectOneById(1);
        $fighter1 = null;
        $fighter2AsArray = $fighterManager->selectOneById(2);
        $fighter2 = null;

        $fighter1 = new Fighter(
            $fighter1AsArray['name'],
            $fighter1AsArray['attack'],
            $fighter1AsArray['defense'],
            $fighter1AsArray['image']
        );

        $fighter2 = new Fighter(
            $fighter2AsArray['name'],
            $fighter2AsArray['attack'],
            $fighter2AsArray['defense'],
            $fighter2AsArray['image']
        );

        $nbRound = 1;

        while ($fighter1->isAlive() && $fighter2->isAlive()) {
             $fighter1->fightRound($fighter2);
             $fighter2->fightRound($fighter1);
             $nbRound++;
        }

        if ($fighter1->isAlive()) {
             $winner = $fighter1;
             $loser = $fighter2;
        } else {
             $winner = $fighter2;
             $loser = $fighter1;
        }

        return $this->twig->render('fight/fight.html.twig', ['winner' => $winner, 'loser' => $loser, 'round' => $nbRound], );
    }
}
