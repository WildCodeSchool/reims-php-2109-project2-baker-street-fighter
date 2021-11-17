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
}
