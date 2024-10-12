<?php

namespace App\Tests\Classes;

use App\Classes\Fight;
use PHPUnit\Framework\TestCase;
use App\Stats\OrderusStatsBuilder;
use App\Stats\MinyakStatsBuilder;
use App\Classes\DefenderMinyak;
use App\Classes\DefenderOrderus;
use App\Classes\Data;

class FightTest extends TestCase
{
    private $Orderus;
    private $Minyak;
    private $data;
    private $fight;

    protected function setUp(): void 
    {
        $OrderusStatsBuilder = new OrderusStatsBuilder();
        $this->Orderus = $OrderusStatsBuilder
            ->setHealth()
            ->setStrength()
            ->setDefence()
            ->setSpeed()
            ->setLuck()
            ->build();
        
        $MinyakStatsBuilder = new MinyakStatsBuilder();
        $this->Minyak = $MinyakStatsBuilder
            ->setHealth()
            ->setStrength()
            ->setDefence()
            ->setSpeed()
            ->setLuck()
            ->build();

        $this->data = new Data();
        $this->fight = new Fight($this->Orderus, $this->Minyak, $this->data);
    }

    public function testInitializeWarriorsHealth()
    {
        $data = $this->fight->initializeWarriorsHealth();
        $OrderusHealth = $data['Orderus']['health'];
        $MinyakHealth = $data['Minyak']['health'];

        $this->assertGreaterThan(0, $OrderusHealth); 
        $this->assertGreaterThan(0, $MinyakHealth); 
    }

    public function testWarriorsActionsAreSet()
    {
        $this->fight->setFightAction(
            $this->Orderus->getSpeed(),
            $this->Orderus->getLuck(),
            $this->Minyak->getSpeed(), 
            $this->Minyak->getLuck()
        );
        $OrderusAction = $this->fight->getOrderusAction();
        $MinyakAction = $this->fight->getMinyakAction();

        $this->assertContains($OrderusAction, ['attack', 'defend']);
        $this->assertContains($MinyakAction, ['attack', 'defend']);
    }

    public function testFirstAttackerIsSet() 
    {
        $this->fight->setFirstAttacker();

        $this->assertContains($this->fight->getFirstAttacker(), ['Orderus', 'Minyak']);
    }

    public function testDefenderIsSet()
    {
        $warriors = ['Orderus', 'Minyak'];
        $defender = $this->fight->getDefender(80, 70, $warriors[rand(0, 1)]);

        $this->assertContains(
            $defender::class, 
            [
                DefenderOrderus::class,
                DefenderMinyak::class
            ]
        );
    }

    public function testMagicShieldIsSet() 
    {
        $magicShield = $this->fight->magicShield('Minyak');

        $this->assertIsBool($magicShield);
    }

    public function testRapidStrikeIsSet() 
    {
        $rapidStrike = $this->fight->rapidStrike('Minyak');

        $this->assertIsBool($rapidStrike);
    }

    public function testSwitchAttackerIsSet()
    {
        $warriors = ['Orderus', 'Minyak'];
        $switchAttacker = $this->fight->switchAttacker($warriors[rand(0, 1)]);

        $this->assertContains($switchAttacker, ['Orderus', 'Minyak']);
    }
}
