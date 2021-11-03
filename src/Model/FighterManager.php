<?php

namespace App\Model;

use App\Entity\Fighter;

class FighterManager extends AbstractManager
{
    public const TABLE = "fighter";
    public const ENTITY = Fighter::class;
}
