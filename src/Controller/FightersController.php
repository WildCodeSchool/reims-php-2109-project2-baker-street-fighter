<?php

namespace App\Controller;

use App\Model\FighterManager;

class FightersController extends AbstractController
{
    public function index(): string
    {
        $fighters = new FighterManager();
        $fighters = $fighters->selectAll('name');

        return $this->twig->render('Fighters/fighterslist.html.twig', ['fighters' => $fighters]);
    }

    public function pick(): string
    {
        // set fighters

        $fighterManager = new FighterManager();
        $fighters = $fighterManager->selectAll('id');

        if (isset($_SESSION['player1']) && isset($_SESSION['player2'])) {
            header('Location: /fight/attack');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_SESSION['player1'])) {
                $_SESSION['player1'] = $fighterManager->selectOneById($_POST['selected_fighter']);
                header('Location: /fight/pick');
            } elseif (!isset($_SESSION['player2'])) {
                $_SESSION['player2'] = $fighterManager->selectOneById($_POST['selected_fighter']);
                header('Location: /fight/attack');
            }
        }

        // initiate fighters

        $player1 = $_SESSION['player1'] ?? null;
        $player2 = $_SESSION['player2'] ?? null;

        $_SESSION['player1'] = $player1;
        $_SESSION['player2'] = $player2;
        $currentAttacker = $player1;
        $_SESSION['currentAttacker'] = $currentAttacker;

        return $this->twig->render('fight/pickFighter.html.twig', ['fighters' => $fighters]);
    }
}
