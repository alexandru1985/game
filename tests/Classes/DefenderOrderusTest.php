<?php

namespace App\Tests\Classes;

use App\Classes\DefenderOrderus;
use PHPUnit\Framework\TestCase;

class DefenderOrderusTest extends TestCase
{
    private $defenderOrderus;
    private $damage;

    protected function setUp(): void 
    {
        $this->defenderOrderus = new DefenderOrderus(70, 50, 90, 80);
        $this->damage = $this->defenderOrderus->getDamage(2);
    }

    public function testDamageIsCorrectDividedToHalf()
    {
        $this->assertEquals(10, $this->damage);
    }

    public function testHealthIsCorrectSubtracted()
    {
        $health = $this->defenderOrderus->getHealth();
        
        $this->assertEquals(80, $health);
    }
}
