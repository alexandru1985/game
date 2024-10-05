<?php

namespace App\Classes;

use App\Stats\ResultFightStats;

class DefenderMinyak extends ResultFightStats 
{
    public function __construct(
        private int $strength, 
        private int $defence, 
        private int $initialHealth,
        private int|float|null $health = null,
        private int|float|null $damage = null
    ) {
    }

    public function getDamage(int $divideDamage): int|float
    {
        return $this->damage = ($this->strength - $this->defence) / $divideDamage;
    }

    public function getHealth(): int|float
    {
        return $this->health = $this->initialHealth - $this->damage;
    }
}
