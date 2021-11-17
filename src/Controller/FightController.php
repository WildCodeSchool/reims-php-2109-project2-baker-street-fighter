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
    public function initiate()
    {
        // initiatecurrentDamage
        if (!isset($_SESSION['currentDamage'])) {
            $_SESSION['currentDamage'] = 0;
        }
        // initiatecurrentAttack
        if (!isset($_SESSION['currentAttack'])) {
            $_SESSION['currentAttack'] = 'default';
        }
        // initiatecurrentRecoil
        if (!isset($_SESSION['currentRecoil'])) {
            $_SESSION['currentRecoil'] = 0;
        }
    }
    public function pick()
    {
        // set fighters
        $fighterManager = new FighterManager();
        $fighters = $fighterManager->selectAll('id');
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_fighter'])) {
            if (!isset($_SESSION['player1'])) {
                $_SESSION['player1'] = $fighterManager->selectOneById($_POST['selected_fighter']);
            } elseif (!isset($_SESSION['player2'])) {
                $_SESSION['player2'] = $fighterManager->selectOneById($_POST['selected_fighter']);
                $_SESSION['currentAttacker'] = $_SESSION['player1'];
            }
        }
        if (isset($_SESSION['player1']) && isset($_SESSION['player2'])) {
            new FightController();
            return $this->statusFight();
        }
        return $this->twig->render('Fight/pickFighter.html.twig', ['fighters' => $fighters]);
    }
    public function statusFight()
    {
        // choose fighters
        if (!isset($_SESSION['player1']) || !isset($_SESSION['player2'])) {
            return $this->pick();
        }
        // initiateFight
        $player1 = $_SESSION['player1'];
        $player2 = $_SESSION['player2'];
        $currentAttacker = $_SESSION['currentAttacker'];
        // initiatenbRound
        $nbRound = $_SESSION['nbRound'] ?? null;
        if (!isset($nbRound)) {
            $nbRound = 1;
            $_SESSION['nbRound'] = $nbRound;
        }
        $nbRound = $_SESSION['nbRound'];
        $this->initiate();
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
                    'damage' => $_SESSION['currentDamage'],
                    'currentAttack' => $_SESSION['currentAttack'],
                    'recoil' => $_SESSION['currentRecoil']]
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
                    'currentAttack' => $_SESSION['currentAttack'],
                    'damage' => $_SESSION['currentDamage'],
                    'recoil' => $_SESSION['currentRecoil']]
                );
            } else {
                throw new Exception();
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
                session_destroy();
                header('Location: /');
        } else {
            return $this->winner();
        }
    }
    public function winner()
    {
        if ($_SESSION['player1']->isAlive()) {
            $winner = $_SESSION['player1'];
            $loser = $_SESSION['player2'];
        } else {
            $winner = $_SESSION['player2'];
            $loser = $_SESSION['player1'];
        }
        $nbRound = $_SESSION['nbRound'];
        $fightManager = new FightManager();
        $fightManager->insert($winner);

        return $this->twig->render(
            'Fight/fight.html.twig',
            ['winner' => $winner, 'loser' => $loser, 'round' => $nbRound]
        );
    }
    public function punch()
    {
        new FightController();
        if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
            $adversary = $_SESSION['player2'];
            $_SESSION['currentAttacker']->fightPunch($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player2'];
            return $this->statusFight();
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $adversary = $_SESSION['player1'];
            $_SESSION['currentAttacker']->fightPunch($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player1'];
            return $this->statusFight();
        }
    }
    public function kick()
    {
        new FightController();
        if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
            $adversary = $_SESSION['player2'];
            $_SESSION['currentAttacker']->fightKick($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player2'];
            return $this->statusFight();
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $adversary = $_SESSION['player1'];
            $_SESSION['currentAttacker']->fightKick($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player1'];
            return $this->statusFight();
        }
    }
    public function headbutt()
    {
        new FightController();
        if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
            $adversary = $_SESSION['player2'];
            $_SESSION['currentAttacker']->fightHeadbutt($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player2'];
            return $this->statusFight();
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $adversary = $_SESSION['player1'];
            $_SESSION['currentAttacker']->fightHeadbutt($adversary);
            $_SESSION['currentAttacker'] = $_SESSION['player1'];
            return $this->statusFight();
        }
    }
    public function teatime()
    {
        new FightController();
        if ($_SESSION['currentAttacker'] === $_SESSION['player1']) {
            $_SESSION['currentAttacker']->fightTeatime();
            $_SESSION['currentAttacker'] = $_SESSION['player2'];
            return $this->statusFight();
        } elseif ($_SESSION['currentAttacker'] === $_SESSION['player2']) {
            $_SESSION['currentAttacker']->fightTeatime();
            $_SESSION['currentAttacker'] = $_SESSION['player1'];
            return $this->statusFight();
        }
    }
}
