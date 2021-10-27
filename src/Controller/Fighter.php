<?php

namespace App\Controller;

class Fighter
{
    public const MAX_LIFE = 100;

    private string $name;
    private int $strength;
    private int $defense;
    private string $image;
    private int $life = self::MAX_LIFE;

    public function __construct(
        string $name,
        int $strength = 20,
        int $defense = 15,
        string $image = '.png'
    ) {
        $this->name = $name;
        $this->strength = $strength;
        $this->defense = $defense;
        $this->image = $image;
    }

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
        $this->life = $life;

        return $this;
    }

    public function getStrength()
    {
        return $this->strength;
    }

    public function setStrength($strength)
    {
        $this->strength = $strength;

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
}
