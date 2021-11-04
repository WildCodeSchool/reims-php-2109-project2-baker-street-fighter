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

    public function initiateFighters()
    {
        $fighterManager = new FighterManager();

        $_SESSION['player1'] = $fighterManager->selectOneById(1);
        $_SESSION['player2'] = $fighterManager->selectOneById(2);

        $_SESSION['currentAttacker'] = $_SESSION['player1'];
    }

    public function fight(): string
    {
        $fighterManager = new FighterManager();

        $fighter1 = $fighterManager->selectOneById(1);
        $fighter2 = $fighterManager->selectOneById(2);

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
