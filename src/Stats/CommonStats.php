<?php

namespace App\Stats;

class CommonStats 
{
    protected int $health;
    protected int $strength;
    protected int $defence;
    protected int $speed;
    protected int $luck;

    public function setHealth(int $min, int $max): static  
    {
        $this->health = rand($min, $max);

        return $this;
    }

    public function getHealth(): int  
    {
        return $this->health;
    }
    
    public function setStrength(int $min, int $max): static 
    {
        $this->strength = rand($min, $max);

        return $this;
    }

    public function getStrength(): int 
    {
        return $this->strength;
    }

    public function setDefence(int $min, int $max): static
    {
        $this->defence = rand($min, $max);

        return $this;
    }

    public function getDefence(): int
    {
        return $this->defence;
    }

    public function setSpeed(int $min, int $max): static
    {
        $this->speed = rand($min, $max);

        return $this;
    }

    public function getSpeed(): int
    {
        return $this->speed;
    }

    public function setLuck(int $min, int $max): static
    {
        $this->luck = rand($min, $max);

        return $this;
    }

    public function getLuck(): int
    {
        return $this->luck;
    }
}
