<?php

/**
 * Standard view template to generate a simple web page, or part of a web page.
 */

declare(strict_types=1);

use function Mos\Functions\url;

?>

<h1><?= $header ?></h1>

<p><?= $message ?></p>

<form action="<?= $action ?>" method="POST">
  <input type="radio" name="dices" value="1" required>
  <label for="dices">1</label><br>
  <input type="radio" name="dices" value="2" required>
  <label for="dices">2</label><br>
  <input type="submit" value="Starta">
</form>

