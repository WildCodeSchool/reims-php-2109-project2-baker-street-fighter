<?php

namespace App\Model;

use App\Entities\Fighter;

class FightManager extends Fighter
{
    public function roundA(){
        return $playerOne->fightRound($playerTwo);
    }

    public function roundB(){
        return $playerTwo->fightRound($playerOne);
    }

    public function isWinner(){
        $winner = $this->playerOne->getName();
        if($this->playerTwo->getLifeValue() > $this->playerOne->getLifeValue()) 
        {
        $winner = $this->playerTwo->getName();
        }
        return $winner;
    }
}
