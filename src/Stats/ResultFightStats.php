<?php

namespace App\Stats;

abstract class ResultFightStats 
{
    abstract public function setDamage(): void;
    abstract public function getDamage(): int|float;
    abstract public function setHealth(): void;
    abstract public function getHealth(): int|float;
}

