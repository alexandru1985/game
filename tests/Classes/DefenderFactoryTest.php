<?php

namespace App\Tests\Classes;

use App\Classes\DefenderFactory;
use App\Classes\DefenderMinyak;
use App\Classes\DefenderOrderus;
use PHPUnit\Framework\TestCase;

class DefenderFactoryTest extends TestCase
{
    public function testDefenderOrderusIsCreated()
    {
        $defenderOrderus = DefenderFactory::createDefender('Minyak', 90, 60, 80);

        $this->assertInstanceOf(DefenderOrderus::class, $defenderOrderus);
    }

    public function testDefenderMinyakIsCreated()
    {
        $defenderMinyak = DefenderFactory::createDefender('Orderus', 80, 50, 70);

        $this->assertInstanceOf(DefenderMinyak::class, $defenderMinyak);
    }
}
