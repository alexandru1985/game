<?php

require 'vendor/autoload.php';

use App\Warriors\Orderus;
use App\Warriors\Minyak;
use App\Stats\OrderusStatsBuilder;
use App\Stats\MinyakStatsBuilder;
use App\Classes\DefenderFactory;
use App\Classes\Labels;
use App\Classes\Fight;
use App\Classes\Data;

$OrderusStatsBuilder = new OrderusStatsBuilder();
$Orderus = $OrderusStatsBuilder
    ->setHealth()
    ->setStrength()
    ->setDefence()
    ->setSpeed()
    ->setLuck()
    ->build();

$MinyakStatsBuilder = new MinyakStatsBuilder();
$Minyak = $MinyakStatsBuilder
    ->setHealth()
    ->setStrength()
    ->setDefence()
    ->setSpeed()
    ->setLuck()
    ->build();

$data = new Data();
$label = new Labels($data);
$fight = new Fight($Orderus, $Minyak, $data);

// Set stats before first attack

if (!isset($_POST['playGame'])) {

    $fight->initializeWarriorsHealth();
    $fight->setFirstAttacker();
    $label->setLabels(
        $fight->getFirstAttacker(),
        $data->dataFight['Orderus']['health'],
        $data->dataFight['Minyak']['health']
    );
    
    $data->save($data->dataFight);
}

// Set stats after fight is started

if (isset($_POST['playGame'])) {
    
    $data->dataFight = $data->getData();

    // Get next attacker

    $attacker = $data->dataFight['attacker'];

    // Keep initial health of warriors 

    $OrderusHealth = $data->dataFight['Orderus']['health'];
    $MinyakHealth = $data->dataFight['Minyak']['health'];

    // Get defender of fight

    $defender = $fight->getDefender($OrderusHealth, $MinyakHealth, $attacker);

    // Set damage of defender

    $defender->setDamage();

    // There are 20% chances to reduce Minyak damage with a half

    $magicShield = $fight->magicShield($attacker);

    if ($magicShield) {
        $defender->applyDividedDamage();
        $label->setLabels(magicShield: $magicShield);
    }

    // Set health for defender 

    $defender->setHealth();

    // Get health and damage for defender

    $healthAfterDamage = $defender->getHealth();
    $damage = $defender->getDamage();

    // Set labels after last attack
    
    $label->setLabels($attacker, $OrderusHealth, $MinyakHealth, $healthAfterDamage, $damage);

    // Switch attacks between Orderus and Minyak after last attack

    $attacker = $fight->switchAttacker($attacker);

    // Set attacker for next attack

    $data->dataFight['attacker'] = $attacker;

    // There are 10% chances as Orderus makes an attack again

    $rapidStrike = $fight->rapidStrike($attacker);

    if ($rapidStrike) {
        $attacker = 'Orderus';
        $data->dataFight['attacker'] = $attacker;
        $label->setLabels(rapidStrike: $rapidStrike);
    }
    
    // Set count fights

    $label->countFights();
    
    // Get winner of fight

    $label->getWinner();

    // Save data after last attack 

    $data->save($data->dataFight);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Game</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>
    <body>
        <div class="container">
            <div class="row justify-content-center pt-5">
                <table class="table table-bordered table-striped custom-table">
                    <tr>
                        <th>Stats</th>
                        <th>Orderus</th>
                        <th>Minyak</th>
                    </tr>
                    <tr>
                        <td>Next Attack</td>
                        <td><?php echo $label->actionOrderus; ?></td>
                        <td><?php echo $label->actionMinyak; ?></td>
                    </tr>
                    <tr>
                        <td>Next Attack Rapid Strike</td>
                        <td><?php echo $label->rapidStrike; ?></td>
                        <td>No</td>
                    </tr>
                    <tr>
                        <td>Last Attack Magic Shield</td>
                        <td><?php echo $label->magicShield; ?></td>
                        <td>No</td>
                    </tr>
                    <tr>
                        <td>Last Attack</td>
                        <td><?php echo $label->lastAttackOrderus; ?></td>
                        <td><?php echo $label->lastAttackMinyak; ?></td>
                    </tr>
                    <tr>
                        <td>Last Attack Damage</td>
                        <td><?php echo $label->damageOrderus; ?></td>
                        <td><?php echo $label->damageMinyak; ?></td>
                    </tr>

                    <tr>
                        <td>Health </td>
                        <td><?php echo $label->OrderusHealth; ?></td>
                        <td><?php echo $label->MinyakHealth; ?></td>
                    </tr>
                    <tr>
                        <td>Fights </td>
                        <td><?php echo $label->fights; ?></td>
                        <td></td>
                    </tr>
                    <caption>           
                    <?php if ($data->dataFight['gameOver'] == false) { ?>
                            <form action="index.php" method="post">
                                <input type="hidden" name="playGame" value="1">
                                <input type="submit" class="btn btn-primary" value="Play">
                            </form>
                        <?php
                        } else {
                        ?>
                            <div class="row">
                                <span class="col-4">
                                    <form action="index.php" name="playGame" method="post">
                                        <input type="submit" class="btn btn-primary" value="Restart Game">
                                    </form>
                                </span>
                                <span style="padding-top:6px;color:#212529;"><b><?php echo $label->winner; ?></b></span>
                    <?php } ?>
                        </div>
                    </caption>
                </table>
            </div>
        </div>
    </body>
</html>
