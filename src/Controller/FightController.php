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
        // initiateFight
        $player1 = $_SESSION['player1'];
        $player2 = $_SESSION['player2'];
        $currentAttacker = $_SESSION['currentAttacker'];

        $nbRound = $_SESSION['nbRound'] ?? null;
        if (!isset($nbRound)) {
            $nbRound = 1;
            $_SESSION['nbRound'] = $nbRound;
        }
        $nbRound = $_SESSION['nbRound'];
        // statusFight
        if ($player1->isAlive() && $player2->isAlive()) {
            if ($currentAttacker === $_SESSION['player1']) {
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound, 'player1' => $player1, 'player2' => $player2]
                );
            } elseif ($currentAttacker === $_SESSION['player2']) {
                $_SESSION['nbRound'] = $nbRound + 0.5;
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound, 'player1' => $player1, 'player2' => $player2]
                );
            } else {
                throw new Exception();
            }
        } else {
            self::winner();
            return $this->twig->render(
                'Fight/fight.html.twig',
                ['winner' => $_SESSION['winner'], 'loser' => $_SESSION['loser'], 'round' => $nbRound]
            );
        }
    }
    public static function winner()
    {
        if ($_SESSION['player1']->isAlive()) {
            $winner = $_SESSION['player1'];
            $loser = $_SESSION['player2'];
            self::add();
        } elseif ($_SESSION['player2']->isAlive()) {
            $winner = $_SESSION['player2'];
            $loser = $_SESSION['player1'];
            self::add();
        } else {
            throw new Exception();
        }
        $_SESSION['winner'] = $winner;
        $_SESSION['loser'] = $loser;
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
