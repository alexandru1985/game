<?php

namespace App\Classes;

use App\Warriors\Orderus;
use App\Warriors\Minyak;
use App\Classes\DefenderMinyak;
use App\Classes\DefenderOrderus;
use App\Classes\Labels;
use App\Classes\Data;

class Fight
{
    public function __construct(
        private Orderus $Orderus,
        private Minyak $Minyak,
        private Data $data,
        private ?string $OrderusAction = null,
        private ?string $MinyakAction = null,
        private ?string $firstAttacker = null
    ) {
    }

    public function initializeWarriorsHealth(): array
    {
        $this->data->dataFight['Orderus']['health'] = $this->Orderus->getHealth();
        $this->data->dataFight['Minyak']['health'] = $this->Minyak->getHealth();

        return $this->data->dataFight;
    }

    public function setFirstAttacker(): void
    {
        // Get warriors params to determine first attack

        $OrderusSpeed = $this->Orderus->getSpeed();
        $OrderusLuck = $this->Orderus->getLuck();
        $MinyakSpeed = $this->Minyak->getSpeed();
        $MinyakLuck = $this->Minyak->getLuck();

        $this->setFightAction($OrderusSpeed, $OrderusLuck, $MinyakSpeed, $MinyakLuck);
        $OrderusAction = $this->getOrderusAction();

        // Set first attacker

        $this->firstAttacker = $OrderusAction == 'attack' ? 'Orderus' : 'Minyak';
        $this->data->dataFight['attacker'] = $this->firstAttacker;
    }

    public function setFightAction(
        int $OrderusSpeed, 
        int $OrderusLuck, 
        int $MinyakSpeed, 
        int $MinyakLuck
    ): void {
        if ($OrderusSpeed > $MinyakSpeed) {
            $this->OrderusAction = "attack";
            $this->MinyakAction = "defend";
        } else {
            $this->OrderusAction = "defend";
            $this->MinyakAction = "attack";
            if ($OrderusSpeed == $MinyakSpeed) {
                if ($OrderusLuck > $MinyakLuck) {
                    $this->OrderusAction = "attack";
                    $this->MinyakAction = "defend";
                } else {
                    $this->OrderusAction = "defend";
                    $this->MinyakAction = "attack";
                }
            }
        }
    }

    public function getDefender(
        int|float $OrderusHealth, 
        int|float $MinyakHealth, 
        string $attacker
    ): DefenderMinyak|DefenderOrderus {

        // Set params to calculate damage for last attack

        $OrderusStrength = $this->Orderus->getStrength();
        $OrderusDefence = $this->Orderus->getDefence();

        $MinyakStrength = $this->Minyak->getStrength();
        $MinyakDefence = $this->Minyak->getDefence();

        // Set warrior which is in defend

        $defender = match ($attacker) {
            'Orderus' => DefenderFactory::createDefender(
                $attacker,
                $OrderusStrength,
                $MinyakDefence,
                $MinyakHealth
            ),
            'Minyak' => DefenderFactory::createDefender(
                $attacker,
                $MinyakStrength,
                $OrderusDefence,
                $OrderusHealth
            )
        };

        return $defender;
    }

    public function magicShield(string $attacker): bool
    {
        $magicShield = $this->Orderus->magicShield();
    
        if ($magicShield == true && $attacker == 'Minyak') {
            return true;
        } 

        return false; 
    }

    public function rapidStrike(string $attacker): bool
    {
        $rapidStrike = $this->Orderus->rapidStrike();
    
        if ($rapidStrike == true && $attacker == 'Minyak') {
            return true;
        } 

        return false; 
    }

    public function switchAttacker(string $attacker): string 
    {
        $attacker = match ($attacker) {
            'Orderus' => 'Minyak',
            'Minyak' => 'Orderus',
        };

        return $attacker;
    }

    public function getOrderusAction(): string 
    {
        return $this->OrderusAction;
    }

    public function getMinyakAction(): string 
    {
        return $this->MinyakAction;
    }

    public function getFirstAttacker(): string 
    {
        return $this->firstAttacker;
    }
}