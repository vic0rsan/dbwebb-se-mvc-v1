<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);
use function Mos\Functions\url;

$actionRoll = url("/yatzy/roll");
$actionReset = url("/yatzy/reset");

?>

<h1><?= $header ?></h1>

<?php if (($_SESSION["rounds"] ?? 0) > 6) : ?>
    <h2>Game over!</h2>
    <h3>Din totala summa är: <b><?= $_SESSION["sum"] ?></b>.</h3>
    <form action="<?= $actionReset ?>" method="POST">
        <input class="submit" type="submit" value="Nollställ">
    </form>
<?php endif; ?>

<?php if (($_SESSION["rounds"] ?? 0) <= 6) : ?>
    <p><?= $message?></p>
    <?php if ($_SESSION["yatzyDices"] ?? null) : ?>
        <p>Du ska sammla på <b><?= $_SESSION["rounds"] ?>:or.</b></p>
        <p>Antal försök: <b><?= $_SESSION["tries"] ?>.</b></p>
        <p>Nuvarande summa: <b><?= $_SESSION["sum"] ?>.</b></p>
    <?php endif; ?>

    <form action="<?= $actionRoll ?>" method="POST">
        <?php if ($_SESSION["yatzyDices"] ?? null) : ?>
            <?php $i = -1; ?>
            <?php foreach ($_SESSION["yatzyDices"] as $value) : ?>
                <div class="diceCell">
                <?php $i++; ?>
                    <span class="<?= $value ?> dice"></span>
                    <br>
                    <?php if ($_SESSION["tries"] != 3) : ?>
                        <input class="diceSel" type="checkbox" name="dice[]" value="<?= (string)$i; ?>" <?php if (in_array((string)$i, $_SESSION["slots"])) {
                            echo "checked='checked'"; 
                                                                                    } ?>)>
                    <?php endif ?>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
        <input class="submit" type="submit" value="Kasta">
    </form>
<?php endif; ?>
