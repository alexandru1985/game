<?php

namespace App\Tests\Classes;

use App\Classes\DefenderOrderus;
use PHPUnit\Framework\TestCase;

class DefenderOrderusTest extends TestCase
{
    private $defenderOrderus;

    protected function setUp(): void 
    {
        $this->defenderOrderus = new DefenderOrderus(70, 50, 90, 80);
        $this->defenderOrderus->setDamage();
        $this->defenderOrderus->applyDividedDamage();
        $this->defenderOrderus->setHealth();
    }

    public function testDamageIsCorrectDividedToHalf()
    {
        $this->assertEquals(10, $this->defenderOrderus->getDamage());
    }

    public function testHealthIsCorrectSubtracted()
    {
        $health = $this->defenderOrderus->getHealth();
        
        $this->assertEquals(80, $health);
    }
}
