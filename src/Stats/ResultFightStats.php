<?php

namespace App\Stats;

abstract class ResultFightStats 
{
    abstract public function getDamage(int $divideDamage): int|float;
    abstract public function getHealth(): int|float;
}

