<?php

namespace App\Stats;

use App\Interfaces\CommonStatsInterface;
use App\Warriors\Minyak;

class MinyakStatsBuilder implements CommonStatsInterface 
{
    public function __construct(
        private ?object $Minyak = null
    ) {
        $this->Minyak = new Minyak();
    }

    public function setHealth(): static
    {
        $this->Minyak->setHealth(60, 90);

        return $this;
    }

    public function setStrength(): static
    {
        $this->Minyak->setStrength(60, 90);

        return $this;
    }

    public function setDefence(): static
    {
        $this->Minyak->setDefence(40, 60);

        return $this;
    }

    public function setSpeed(): static
    {
        $this->Minyak->setSpeed(40, 60);

        return $this;
    }

    public function setLuck(): static 
    {
        $this->Minyak->setLuck(25, 40);

        return $this;
    }

    public function build(): Minyak 
    {
        return $this->Minyak;
    }
}
