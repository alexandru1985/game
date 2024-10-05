<?php

namespace App\Stats;

use App\Interfaces\CommonStatsInterface;
use App\Warriors\Orderus;

class OrderusStatsBuilder implements CommonStatsInterface 
{
    public function __construct(
        private ?object $Orderus = null
    ) {
        $this->Orderus = new Orderus();
    }

    public function setHealth(): static
    {
        $this->Orderus->setHealth(70, 100);

        return $this;
    }

    public function setStrength(): static
    {
        $this->Orderus->setStrength(70, 80);

        return $this;
    }

    public function setDefence(): static
    {
        $this->Orderus->setDefence(45, 55);

        return $this;
    }

    public function setSpeed(): static
    {
        $this->Orderus->setSpeed(40, 50);

        return $this;
    }
    
    public function setLuck(): static
    {
        $this->Orderus->setLuck(10, 30);

        return $this;
    }

    public function build(): Orderus 
    {
        return $this->Orderus;
    }
}
