<?php

namespace App\Controller;

use App\Model\FighterManager;
use App\Model\FightManager;
use App\Entity\Fighter;

class FightController extends AbstractController
{
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
        var_dump($fighter1AsArray);
        $fighter1 = null;
        $fighter2AsArray = $fighterManager->selectOneById(2);
        var_dump($fighter2AsArray);
        $fighter2 = null;

        $fighter1 = new Fighter($fighter1AsArray['name'], $fighter1AsArray['attack'], $fighter1AsArray['defense'], $fighter1AsArray['image']);
        var_dump($fighter1);

        $fighter2 = new Fighter($fighter2AsArray['name'], $fighter2AsArray['attack'], $fighter2AsArray['defense'], $fighter2AsArray['image']);
        var_dump($fighter2);

        // while ($fighter1->isAlive() && $fighter2->isAlive()) {
        //     $fighter1->fight($fighter2);
        //     $fighter2->fight($fighter1);
        // }

        // if ($fighter1->isAlive()) {
        //     $winner = $fighter1;
        //     $loser = $fighter2;
        // } else {
        //     $winner = $fighter2;
        //     $loser = $fighter1;
        // }

        return $this->twig->render('fight/fight.html.twig', ['winner' => $winner, 'loser' => $loser]);
        return "let's fight";
    }
}
