<?php

require 'vendor/autoload.php';

use App\Warriors\Orderus;
use App\Warriors\Minyak;
use App\Stats\OrderusStatsBuilder;
use App\Stats\MinyakStatsBuilder;
use App\Classes\FightAction;
use App\Classes\DefenderFactory;
use App\Classes\Labels;

$destination = 'data/savedData.txt';

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

$label = new Labels();
$fightAction = new FightAction();

if (!isset($_POST['playGame'])) {

    // Get and save initial health for warriors

    $label->data['Orderus']['health'] = $Orderus->getHealth();
    $label->data['Minyak']['health'] = $Minyak->getHealth();

    // Get warriors params to determine first attack

    $OrderusSpeed = $Orderus->getSpeed();
    $OrderusLuck = $Orderus->getLuck();
    $MinyakSpeed = $Minyak->getSpeed();
    $MinyakLuck = $Minyak->getLuck();

    $fightAction->setAction($OrderusSpeed, $OrderusLuck, $MinyakSpeed, $MinyakLuck);
    $OrderusAction = $fightAction->getOrderusAction();
    
    // Set first attacker

    $attacker = $OrderusAction == 'attack' ? 'Orderus' : 'Minyak';
    $label->data['attacker'] = $attacker;

    // Set labels before first attack
    
    $label->setLabels($attacker, $label->data['Orderus']['health'], $label->data['Minyak']['health']);
  
    // Save initial data

    $saveData = file_put_contents($destination, serialize($label->data));
}


if (isset($_POST['playGame'])) {
    
    $data = file_get_contents($destination);
    $label->data = unserialize($data);

    // Get next attacker

    $attacker = $label->data['attacker'];

    // Keep initial health of warriors 

    $OrderusHealth = $label->data['Orderus']['health'];
    $MinyakHealth = $label->data['Minyak']['health'];

    // Set params to calculate damage for last attack

    $OrderusStrength = $Orderus->getStrength();
    $OrderusDefence = $Orderus->getDefence();

    $MinyakStrength = $Minyak->getStrength();
    $MinyakDefence = $Minyak->getDefence();

    // Set warrior which is in defend

    $defender = match ($attacker) {
        'Orderus' => DefenderFactory::createDefender(
            $attacker,
            $OrderusStrength,
            $MinyakDefence,
            $MinyakHealth
        ),
        'Minyak' => DefenderFactory::createDefender(
            $attacker,
            $MinyakStrength,
            $OrderusDefence,
            $OrderusHealth
        )
    };

    // There are 20% chances to reduce Minyak damage with a half

    $divideDamage = 1;
    $magicShield = $Orderus->magicShield();

    if ($magicShield == true && $attacker == 'Minyak') {
        $label->magicShield = "<span style='color:red;'>Yes</span>";
        $divideDamage = 2;
    } 

    $damage = $defender->getDamage($divideDamage);
    $healthAfterDamage = $defender->getHealth();

    // Set labels after Last attack
    
    $label->setLabels($attacker, $OrderusHealth, $MinyakHealth, $healthAfterDamage, $damage);

    // Get winner of fight
    
    $label->getWinner();
    
    // Switch attacks between Orderus and Minyak after last attack

    $attacker = match ($label->data['attacker']) {
        'Orderus' => 'Minyak',
        'Minyak' => 'Orderus',
    };

    // Set attacker for next attack

    $label->data['attacker'] = $attacker;

    // There are 10% chances as Orderus makes an attack again

    $rapidStrike = $Orderus->rapidStrike();

    if ($rapidStrike == true && $attacker == 'Minyak') {
        $attacker = 'Orderus';
        $label->data['attacker'] = $attacker;
        $label->actionOrderus = 'Attack';
        $label->actionMinyak = 'Defend';
        $label->rapidStrike = "<span style='color:red;'>Yes</span>";
    }
    
    $label->data['countFights'] += 1;
    $label->fights = $label->data['countFights'];
    
    // Save data after last attack 
    
    $saveData = file_put_contents($destination, serialize($label->data));
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
                    <?php if ($label->data['gameOver'] == false) { ?>
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
