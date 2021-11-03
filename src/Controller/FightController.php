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
    private static function add(): void
    {
        $currentWinner = '$winner';
        $fightManager = new FightManager();
        $fightManager->insert($currentWinner);
    }

    public function index(): string
    {
        $fightManager = new FightManager();
        $fights = $fightManager->selectAll('date');

        return $this->twig->render('Fight/index.html.twig', ['fights' => $fights]);
    }

    public function initiateFighter()
    {
        $fighterManager = new FighterManager();

        $fighter1AsArray = $fighterManager->selectOneById(1);
        $fighter2AsArray = $fighterManager->selectOneById(2);

        $_SESSION['player1'] = new Fighter(
            $fighter1AsArray['name'],
            $fighter1AsArray['attack'],
            $fighter1AsArray['defense'],
            $fighter1AsArray['image']
        );

        $_SESSION['player2'] = new Fighter(
            $fighter2AsArray['name'],
            $fighter2AsArray['attack'],
            $fighter2AsArray['defense'],
            $fighter2AsArray['image']
        );
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
             self::add();
        } else {
             $winner = $fighter2;
             $loser = $fighter1;
             self::add();
        }

        return $this->twig->render(
            'Fight/fight.html.twig',
            ['winner' => $winner, 'loser' => $loser, 'round' => $nbRound]
        );
    }
}
