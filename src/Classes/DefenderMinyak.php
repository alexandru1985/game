<?php

namespace App\Classes;

use App\Stats\ResultFightStats;

class DefenderMinyak extends ResultFightStats 
{
    public function __construct(
        private int $strength, 
        private int $defence, 
        private int|float $initialHealth,
        private int|float|null $health = null,
        private int|float|null $damage = null
    ) {
    }

    public function setDamage(): void
    {
        $this->damage = $this->strength - $this->defence;
    }

    public function getDamage(): int|float
    {
        return $this->damage;
    }

    public function setHealth(): void 
    {
        $this->health = $this->initialHealth - $this->damage;
    }

    public function getHealth(): int|float 
    {
        return $this->health;
    }
}
