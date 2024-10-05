<?php

namespace App\Classes;

use App\Classes\DefenderMinyak;
use App\Classes\DefenderOrderus;
use App\Exceptions\WarriorNotFound;

class DefenderFactory 
{
    public static function createDefender(
        string $attacker,
        int $warriorStrength, 
        int $warriorDefence, 
        int|float $warriorHealth
    ): DefenderMinyak|DefenderOrderus {
        $defender = match ($attacker) {
            'Orderus' => new DefenderMinyak($warriorStrength, $warriorDefence, $warriorHealth),
            'Minyak' => new DefenderOrderus($warriorStrength, $warriorDefence, $warriorHealth),
            default => WarriorNotFound::getException()
        };

        return $defender;
    }
}
