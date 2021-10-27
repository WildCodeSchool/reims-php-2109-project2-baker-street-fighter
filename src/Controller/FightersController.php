<?php

namespace App\Controller;

use App\Model\FighterManager;

class FightersController extends AbstractController
{
    public function index(): string
    {
        $listFighters = new FighterManager();
        $listFighters = $listFighters->selectAll('name');

        return $this->twig->render('Fighters/fighterslist.html.twig', ['listFighters' => $listFighters]);
    }
}
