<?php

namespace App\Classes;

use App\Classes\Data;

class Labels extends Data 
{
    public string $actionOrderus = 'Attack';
    public string $actionMinyak = 'Defend';
    public string $lastAttackOrderus = 'No';
    public string $lastAttackMinyak = 'No';
    public int|float $damageOrderus = 0;
    public int|float $damageMinyak = 0;
    public string $OrderusHealth;
    public string $MinyakHealth;
    public string $rapidStrike = 'No';
    public string $magicShield = 'No';
    public int $fights = 0;
    public string $winner;
    public array $actions = [
        'attack' => [
            'Orderus' => 'Attack',
            'Minyak' => 'Attack'
        ],
        'defend' => [
            'Orderus' => 'Defend',
            'Minyak' => 'Defend' 
        ]
    ];

    public function setLabels(
        string $attacker,
        int|float $OrderusHealth,  
        int|float $MinyakHealth, 
        int|float|null $healthAfterDamage = null, 
        int|float|null $damage = null
    ): void {

        // Set initial health before first attack

        $this->OrderusHealth = $OrderusHealth;
        $this->MinyakHealth = $MinyakHealth;

        switch ($attacker) {
            case 'Orderus':
                $this->actionOrderus = $this->actions['attack']['Orderus'];
                $this->actionMinyak = $this->actions['defend']['Minyak'];
                $this->OrderusHealth = $OrderusHealth;
                
                // Change default labels after first attack

                if ($damage != null) {
                    $this->actionOrderus = $this->actions['defend']['Orderus'];
                    $this->actionMinyak = $this->actions['attack']['Minyak'];
                    $this->lastAttackOrderus = "Attack";
                    $this->lastAttackMinyak = "Defend";
                    $this->damageOrderus = $damage;


                    if ($healthAfterDamage > 0) {
                        $this->MinyakHealth = $healthAfterDamage;
                    } else {
                        $this->MinyakHealth = "<span style='color:red;'>" . $healthAfterDamage . "</span>";
                    }

                    // Save subtracted health on data array

                    $this->data['Minyak']['health'] = $healthAfterDamage;
                }
                break;
            case 'Minyak':   
                $this->actionOrderus = $this->actions['defend']['Orderus'];
                $this->actionMinyak = $this->actions['attack']['Minyak'];
                $this->MinyakHealth = $MinyakHealth;
                
                // Change default labels after first attack

                if ($damage != null) {
                    $this->actionOrderus = $this->actions['attack']['Orderus'];
                    $this->actionMinyak = $this->actions['defend']['Minyak'];
                    $this->lastAttackOrderus = 'Defend';
                    $this->lastAttackMinyak = 'Attack';
                    $this->damageMinyak = $damage;

                    if ($healthAfterDamage > 0) {
                        $this->OrderusHealth = $healthAfterDamage;
                    } else {
                        $this->OrderusHealth = "<span style='color:red;'>" . $healthAfterDamage . "</span>";
                    }

                    // Save subtracted health on data array

                    $this->data['Orderus']['health'] = $healthAfterDamage;
                }
                break;
        }
    }

    public function getWinner(): void 
    {
        // Set game over and winner label

        if (($this->data['Orderus']['health'] > 0) && ($this->data['Minyak']['health'] <= 0)) {
            $this->winner = 'Orderus Wins';
            $this->data['gameOver'] = true;
        }

        if (($this->data['Orderus']['health'] <= 0) && ($this->data['Minyak']['health'] > 0)) {
            $this->winner = 'Minyak Wins';
            $this->data['gameOver'] = true;
        }

        if ($this->data['countFights'] > 20) {
            $this->data['gameOver'] = true;
            if ($this->data['Orderus']['health'] > $this->data['Minyak']['health']) {
                $this->winner = 'Orderus Wins';
            } else {
                $this->winner = 'Minyak Wins';
            }
        }
    }
}
