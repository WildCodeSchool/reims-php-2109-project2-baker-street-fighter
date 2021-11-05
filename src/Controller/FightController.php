<?php

namespace App\Controller;

use App\Model\FighterManager;
use App\Model\FightManager;
use App\Entity\Fighter;
use Exception;

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
    public function statusFight()
    {
        // initiateFighters
        $player1 = $_SESSION['player1'] ?? null;
        $player2 = $_SESSION['player2'] ?? null;
        if (!$player1 && !$player2) {
            $fighterManager = new FighterManager();

            $player1 = $fighterManager->selectOneById(1);
            $player2 = $fighterManager->selectOneById(2);

            $_SESSION['player1'] = $player1;
            $_SESSION['player2'] = $player2;
            $currentAttacker = $player1;
            $_SESSION['currentAttacker'] = $currentAttacker;
        }
        // initiateFight
        $currentAttacker = $_SESSION['currentAttacker'];

        $nbRound = $_SESSION['nbRound'] ?? null;
        if (!isset($nbRound)) {
            $nbRound = 1;
            $_SESSION['nbRound'] = $nbRound;
        }
        // statusFight
        if ($player1->isAlive() && $player2->isAlive()) {
            if ($currentAttacker === $_SESSION['player1']) {
                $nbRound++;
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound, 'player1' => $player1, 'player2' => $player2]
                );
            } elseif ($currentAttacker === $_SESSION['player2']) {
                $nbRound++;
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound, 'player1' => $player1, 'player2' => $player2]
                );
            } else {
                throw new Exception();
            }
        } else {
            $winner = '';
            $loser = '';
            if ($player1->isAlive()) {
                $winner = $player1;
                $loser = $player2;
                self::add();
            } elseif ($player2->isAlive()) {
                $winner = $player2;
                $loser = $player1;
                self::add();
            } else {
                throw new Exception();
            }
            return $this->twig->render(
                'Fight/fight.html.twig',
                ['winner' => $winner, 'loser' => $loser, 'round' => $nbRound]
            );
        }
    }
    public function attack()
    {
        var_dump($_SESSION['currentAttacker']);
        var_dump($_SESSION['player1']);
        var_dump($_SESSION['player2']);
        if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
            $adversary = $_SESSION['player2'];
            $_SESSION['currentAttacker']->fightRound($adversary);
            $this->statusFight();
            $_SESSION['currentAttacker'] = $_SESSION['player2'];
            header('Location: /fight/attack');
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $adversary = $_SESSION['player1'];
            $_SESSION['currentAttacker']->fightRound($adversary);
            $this->statusFight();
            $_SESSION['currentAttacker'] = $_SESSION['player1'];
            header('Location: /fight/attack');
        }
    }
}
