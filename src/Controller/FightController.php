<?php

namespace App\Controller;

use App\Model\FightManager;

public function index()
{
    return $this->twig->render('View/Fight/fight.html.twig', ['']);
}
