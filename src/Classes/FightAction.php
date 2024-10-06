<?php

namespace App\Classes;

class FightAction
{
    public string $Orderus;
    public string $Minyak;

    public function setAction(
        int $OrderusSpeed, 
        int $OrderusLuck, 
        int $MinyakSpeed, 
        int $MinyakLuck
    ): void {
        if ($OrderusSpeed > $MinyakSpeed) {
            $this->Orderus = "attack";
            $this->Minyak = "defend";
        } else {
            $this->Orderus = "defend";
            $this->Minyak = "attack";
            if ($OrderusSpeed == $MinyakSpeed) {
                if ($OrderusLuck > $MinyakLuck) {
                    $this->Orderus = "attack";
                    $this->Minyak = "defend";
                } else {
                    $this->Orderus = "defend";
                    $this->Minyak = "attack";
                }
            }
        }
    }

    public function getOrderusAction(): string 
    {
        return $this->Orderus;
    }

    public function getMinyakAction(): string 
    {
        return $this->Minyak;
    }
}
