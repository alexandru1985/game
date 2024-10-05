<?php

namespace App\Warriors;

use App\Stats\CommonStats;

class Orderus extends CommonStats 
{
    public function __construct(
        public bool $rapidStrike = false,
        public bool $magicShield = false,
        public int $chanceRapidStrike = 0,
        public int $chanceMagicShield = 0
    ) {
        $this->chanceRapidStrike = rand(1, 10);
        $this->chanceMagicShield = rand(1, 5);
    }

    public function rapidStrike(): bool 
    {
        if ($this->chanceRapidStrike == 1) {
            $this->rapidStrike = true;
        }

        return $this->rapidStrike;
    }

    public function magicShield(): bool 
    {
        if ($this->chanceMagicShield == 1) {
            $this->magicShield = true;
        }
        
        return $this->magicShield;
    }
}
