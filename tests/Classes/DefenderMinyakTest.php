<?php

namespace App\Tests\Classes;

use App\Classes\DefenderMinyak;
use PHPUnit\Framework\TestCase;

class DefenderMinyakTest extends TestCase
{
    private $defenderMinyak;
    private $damage;

    protected function setUp(): void 
    {
        $this->defenderMinyak = new DefenderMinyak(60, 40, 80, 70);
        $this->damage = $this->defenderMinyak->getDamage(1);
    }

    public function testDamageIsNotDividedToHalf()
    {
        $this->assertEquals(20, $this->damage);
    }

    public function testHealthIsCorrectSubtracted()
    {
        $health = $this->defenderMinyak->getHealth();

        $this->assertEquals(60, $health);
    }
}
