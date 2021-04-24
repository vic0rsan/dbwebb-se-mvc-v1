<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\{
    url,
    buttonRoll
};

$actionRoll = url("/game21/roll");
$actionStop = url("/game21/stop");
$actionReset = url("/game21/reset");

?>

<h1><?= $header ?></h1>

<p><?= $message?></p>

<b><?= $_SESSION["stats"] ?></b>

<p>Din summa: <?= $_SESSION["playerSum"]?></p>
<?php if($_SESSION["stop"]) : ?>
    <p>Datorns summa: <?= $_SESSION["comSum"] ?></p>
<?php endif; ?>

<?php if($_SESSION["playerSum"] < 21) : ?>
    <?php if(!$_SESSION["stop"]) : ?>
        <?php foreach($_SESSION["playerDices"] as $value) : ?>
            <span class="<?= $value ?> dice"></span>
        <?php endforeach; ?>
        <form action="<?= $actionRoll?>" method="POST">
            <input type="submit" value="Kasta">
        </form>
        <form action="<?= $actionStop?>" method="POST">
            <input type="submit" value="Stanna">
        </form>
    <?php endif; ?>
<?php endif; ?>

<form action="<?= $actionReset?>" method="POST">
  <input type="submit" value="Nollställ">
</form>

<b>Vinster:</b>
<p>Spelaren: <?= $_SESSION["playerWins"]?></p>
<p>Datorn: <?= $_SESSION["comWins"]?></p>