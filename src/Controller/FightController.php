<?php

namespace App\Controller;

use App\Model\FighterManager;
use App\Model\FightManager;
use App\Entity\Fighter;
use App\Controller\FightersController;
use Exception;

class FightController extends AbstractController
{
    /**
     * Add a new fight
     */
    public function index(): string
    {
        $fightManager = new FightManager();
        $fights = $fightManager->selectAll('date', 'DESC');

        return $this->twig->render('Fight/index.html.twig', ['fights' => $fights]);
    }

    public function statusFight()
    {
        
        // choose fighters
        if (!isset($_SESSION['player1']) || !isset($_SESSION['player2'])) {
            $fightersController = new FightersController();
            return $fightersController->pick();
        }
        
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
        // initiatecurrentDamage
        if (!isset($_SESSION['currentDamage'])) {
            $_SESSION['currentDamage'] = 0;
        }
        // statusFight
        if ($player1->isAlive() && $player2->isAlive()) {
            if ($currentAttacker === $_SESSION['player1']) {
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound,
                    'player1' => $player1,
                    'player2' => $player2,
                    'adversary' => $currentAttacker,
                    'currentAttacker' => $player2,
                    'damage' => $_SESSION['currentDamage']]
                );
            } elseif ($currentAttacker === $_SESSION['player2']) {
                $_SESSION['nbRound']++;
                return $this->twig->render(
                    'Fight/attack.html.twig',
                    ['round' => $nbRound,
                    'player1' => $player1,
                    'player2' => $player2,
                    'adversary' => $currentAttacker,
                    'currentAttacker' => $player1,
                    'damage' => $_SESSION['currentDamage']]
                );
            } else {
                throw new Exception();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                session_destroy();
                header('Location: /');
        } else {
            if ($_SESSION['player1']->isAlive()) {
                $winner = $_SESSION['player1'];
                $loser = $_SESSION['player2'];
            } else {
                $winner = $_SESSION['player2'];
                $loser = $_SESSION['player1'];
            }

            $fightManager = new FightManager();
            $fightManager->insert($winner);

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
            $_SESSION['currentAttacker'] = $_SESSION['player2'];
            header('Location: /fight');
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $adversary = $_SESSION['player1'];
            $_SESSION['currentAttacker']->fightRound($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player1'];
            header('Location: /fight');
        }
    }
}
