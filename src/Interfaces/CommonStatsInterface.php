<?php

namespace App\Interfaces;

interface CommonStatsInterface 
{
    public function setHealth(): static;

    public function setStrength(): static; 

    public function setDefence(): static; 

    public function setSpeed(): static;

    public function setLuck(): static; 
}
