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
        $minAttack = intval($this->getAttack() / 2);
        $damage = rand($minAttack, $this->getAttack() / 1.4) - rand(1, $adversary->getDefense());
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $_SESSION['currentDamage'] = $damage;
        $_SESSION['currentAttack'] = 'punch';
    }

    public function fightKick(Fighter $adversary): void
    {
        $maxAttack = intval($this->getAttack() * 1.2);
        $damage = rand(0, $maxAttack) - rand(1, $adversary->getDefense());
        if ($damage < 0) {
            $damage = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $_SESSION['currentDamage'] = $damage;
        $_SESSION['currentAttack'] = 'kick';
    }

    public function fightHeadbutt(Fighter $adversary): void
    {
        $minAttack = intval($this->getAttack() / 2);
        $maxAttack = intval($this->getAttack() * 1.5);
        $attackPower = rand($minAttack, $maxAttack);
        $damage =  $attackPower - rand(1, $adversary->getDefense());
        $recoil = intval($damage / 2.5);
        if ($damage < 0) {
            $damage = 0;
        }
        if ($recoil < 0) {
            $recoil = 0;
        }
        $adversary->setLife($adversary->getLife() - $damage);
        $this->setLife($this->getLife() - $recoil);
        $_SESSION['currentDamage'] = $damage;
        $_SESSION['currentRecoil'] = $recoil;
        $_SESSION['currentAttack'] = 'headbutt';
    }

    public function fightTeatime(): void
    {
        $heal = rand(5, 15);
        $this->setLife($this->getLife() + $heal);
        if ($this->getLife() > 100) {
            $this->setLife(100);
        }
        $_SESSION['currentHeal'] = $heal;
        $_SESSION['currentAttack'] = 'teatime';
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
