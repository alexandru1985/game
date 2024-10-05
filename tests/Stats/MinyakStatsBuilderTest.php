<?php

namespace App\Tests\Stats;

use App\Stats\MinyakStatsBuilder;
use App\Warriors\Minyak;
use PHPUnit\Framework\TestCase;

class MinyakStatsBuilderTest extends TestCase
{
    public function testMinyakIsCreatedAndPropertyValuesAreCorrectSet()
    {
        $MinyakStatsBuilder = new MinyakStatsBuilder();
        $Minyak = $MinyakStatsBuilder
            ->setHealth()
            ->setStrength()
            ->setDefence()
            ->setSpeed()
            ->setLuck()
            ->build();

        $this->assertGreaterThanOrEqual(60, $Minyak->getHealth()); 
        $this->assertLessThanOrEqual(90, $Minyak->getHealth());

        $this->assertGreaterThanOrEqual(60, $Minyak->getStrength()); 
        $this->assertLessThanOrEqual(90, $Minyak->getStrength());

        $this->assertGreaterThanOrEqual(40, $Minyak->getDefence()); 
        $this->assertLessThanOrEqual(60, $Minyak->getDefence());

        $this->assertGreaterThanOrEqual(40, $Minyak->getSpeed()); 
        $this->assertLessThanOrEqual(60, $Minyak->getSpeed());

        $this->assertGreaterThanOrEqual(25, $Minyak->getLuck()); 
        $this->assertLessThanOrEqual(40, $Minyak->getLuck());

        $this->assertInstanceOf(Minyak::class, $Minyak);
    }
}
