<?php

namespace App\Controller;

use App\Model\FightManager;

class FightController extends AbstractController
{
    public function index(): string
    {
        $fightManager = new FightManager();
        $fights = $fightManager->selectAll('date');

        return $this->twig->render('fight/index.html.twig', ['fights' => $fights]);
    }
}
