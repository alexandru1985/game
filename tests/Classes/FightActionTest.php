<?php

namespace App\Tests\Classes;

use App\Classes\FightAction;

use PHPUnit\Framework\TestCase;

class FightActionTest extends TestCase
{
    public function testWarriorsActionsAreSet()
    {
        $OrderusSpeed = rand(40, 50); 
        $OrderusLuck = rand(10, 30);  
        $MinyakSpeed = rand(40, 60);  
        $MinyakLuck = rand(25,40); 

        $fightAction = new FightAction();
        $fightAction->setAction($OrderusSpeed, $OrderusLuck, $MinyakSpeed, $MinyakLuck);
        $OrderusAction = $fightAction->getOrderusAction();
        $MinyakAction = $fightAction->getMinyakAction();

        $this->assertContains($OrderusAction, ['attack', 'defend']);
        $this->assertContains($MinyakAction, ['attack', 'defend']);
    }
}
