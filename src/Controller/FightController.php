<?php

namespace App\Controller;

use App\Model\Fighter;

class FightController extends Fighter
{
    public function fight(){
        $playerOne->fightRound($playerTwo);
    }


}
