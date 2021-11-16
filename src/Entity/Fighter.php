<?php

namespace App\Entity;

use App\Controller\FightController;

class Fighter
{
    public const MAX_LIFE = 100;

    private int $id;
    private string $name;
    private int $attack;
    private int $defense;
    private string $image = '/assets/images/placeholder.png';
    private int $life = self::MAX_LIFE;

    /*public function __construct(
        string $name,
        int $attack,
        int $defense,
        string $image
    ) {
        $this->name = $name;
        $this->attack = $attack;
        $this->defense = $defense;
        $this->image = $image;
    }*/

    public function getName()
    {
        return $this->name;
    }


    public function getLife()
    {
        return $this->life;
    }

    /**
     * Set the value of life
     *
     * @return  self
     */
    public function setLife($life)
    {
        if ($life < 0) {
            $life = 0;
        }
        $this->life = $life;

        return $this;
    }

    public function getAttack()
    {
        return $this->attack;
    }

    public function setAttack($attack)
    {
        $this->attack = $attack;

        return $this;
    }

    public function getDefense()
    {
        return $this->defense;
    }

    public function setDefense($defense)
    {
        $this->defense = $defense;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    public function isAlive(): bool
    {
        return $this->getLife() > 0;
    }

    public function fightRound(Fighter $adversary): void
    {
        $damage = rand(1, $this->getAttack()) - rand(1, $adversary->getDefense());
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $_SESSION['currentDamage'] = $damage;
    }

    public function fightPunch(Fighter $adversary): void
    {
        $damage = rand(round(($this->getAttack() / 2)), $this->getAttack()) - rand(1, $adversary->getDefense());
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $_SESSION['currentDamage'] = $damage;
    }

    public function fightKick(Fighter $adversary): void
    {
        $damage = rand(0, round(($this->getAttack() * 1.5))) - rand(1, $adversary->getDefense());
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $_SESSION['currentDamage'] = $damage;
    }

    public function fightHeadbutt(Fighter $adversary): void
    {
        $damage = rand(round(($this->getAttack() / 2)), round(($this->getAttack() * 1.5))) - rand(1, $adversary->getDefense());
        $recoil = round($damage / 2);
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $this->setLife($this->getLife() - $recoil);
        $_SESSION['currentDamage'] = $damage;
        $_SESSION['currentRecoil'] = $recoil;
    }

    public function teaTime(): void
    {
        $heal = 15;
        $this->setLife($this->getLife + $heal);
        $_SESSION['currentHeal'] = $heal;
    }

    /**
     * Get the value of id
     *
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param int $id
     *
     * @return self
     */
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
