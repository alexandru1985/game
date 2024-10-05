<?php

namespace App\Tests\Stats;

use App\Stats\OrderusStatsBuilder;
use App\Warriors\Orderus;
use PHPUnit\Framework\TestCase;

class OrderusStatsBuilderTest extends TestCase
{
    public function testOrderusIsCreatedAndPropertyValuesAreCorrectSet()
    {
        $OrderusStatsBuilder = new OrderusStatsBuilder();
        $Orderus = $OrderusStatsBuilder
            ->setHealth()
            ->setStrength()
            ->setDefence()
            ->setSpeed()
            ->setLuck()
            ->build();

        $this->assertGreaterThanOrEqual(70, $Orderus->getHealth()); 
        $this->assertLessThanOrEqual(100, $Orderus->getHealth());

        $this->assertGreaterThanOrEqual(70, $Orderus->getStrength()); 
        $this->assertLessThanOrEqual(80, $Orderus->getStrength());

        $this->assertGreaterThanOrEqual(45, $Orderus->getDefence()); 
        $this->assertLessThanOrEqual(55, $Orderus->getDefence());

        $this->assertGreaterThanOrEqual(40, $Orderus->getSpeed()); 
        $this->assertLessThanOrEqual(50, $Orderus->getSpeed());

        $this->assertGreaterThanOrEqual(10, $Orderus->getLuck()); 
        $this->assertLessThanOrEqual(30, $Orderus->getLuck());

        $this->assertIsBool($Orderus->magicShield());
        $this->assertIsBool($Orderus->rapidStrike());

        $this->assertInstanceOf(Orderus::class, $Orderus);
    }
}
