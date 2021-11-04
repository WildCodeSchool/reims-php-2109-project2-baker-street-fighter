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
    public function statusFight()
    {
        $nbRound = 1;
        if (($_SESSION['player1']->isAlive) && ($_SESSION['player2']->isAlive)) {
            if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
                $nbRound++;
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound]
                );
            } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
                $nbRound++;
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound]
                );
            } else {
                header('Location:/');
            }
        } elseif ((!$_SESSION['player1']->isAlive()) || (!$_SESSION['player2']->isAlive())) {
            $winner = '';
            $loser = '';
            if ($_SESSION['player1']->isAlive()) {
                $winner = $_SESSION['player1'];
                $loser = $_SESSION['player2'];
                self::add();
            } elseif ($_SESSION['player1']->isAlive()) {
                $winner = $_SESSION['player2'];
                $loser = $_SESSION['player1'];
                self::add();
            } else {
                header('Location:/');
            }
            return $this->twig->render(
                'Fight/fight.html.twig',
                ['winner' => $winner, 'loser' => $loser, 'round' => $nbRound]
            );
        } else {
            header('Location:/');
        }
    }
    public function attack()
    {
        if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
            $adversary = $_SESSION['player2'];
            $_SESSION['currentAttacker']->fightRound($adversary);
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $adversary = $_SESSION['player1'];
            $_SESSION['currentAttacker']->fightRound($adversary);
        }
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
