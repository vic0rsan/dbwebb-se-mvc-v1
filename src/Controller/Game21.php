<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use gusu20\Dice\DiceHand;
use function Mos\Functions\destroySession;
use function Mos\Functions\renderView;
use function Mos\Functions\url;

class Game21
{
    public function init(): ResponseInterface
    {
        destroySession();
        $data = [
            "header" => "Game21",
            "message" => "Spela game21 mot datorn.",
            "action" => url("/game21/process")
        ];
        $body = renderView("layout/game21start.php", $data);

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function process(): ResponseInterface
    {
        $data = [
            "header" => "Game21",
            "message" => "Regler: Försök att få en summa närmast 21, men ej större."
        ];
        $_SESSION["diceAmount"] = (int)$_POST["dices"];
        $_SESSION["playerSum"] = 0;
        $_SESSION["comSum"] = 0;
        $_SESSION["playerWins"] = 0;
        $_SESSION["comWins"] = 0;
        $_SESSION["stop"] = false;

        $body = renderView("layout/game21.php", $data);

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function play(): ResponseInterface
    {
        $data = [
            "header" => "Game21",
            "message" => "Regler: Försök att få en summa närmast 21, men ej större."
        ];
        $body = renderView("layout/game21.php", $data);

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function buttonRoll() : ResponseInterface
    {
        $player = new DiceHand($_SESSION["diceAmount"]);
        $player->rollDices();
        $player->getDicesValue();
        $sum = $player->getDiceSum();
        $_SESSION["playerSum"] += $sum;
        $dices = $player->getDicesGraphic();
        $_SESSION["playerDices"] = $dices;

        if ($_SESSION["playerSum"] == 21) {
            $_SESSION["stats"] = "Du vann!";
            $_SESSION["playerWins"] += 1;
        } else if ($_SESSION["playerSum"] > 21) {
            $_SESSION["stats"] = "Datorn vann!";
            $_SESSION["comWins"] += 1;
        }
        
        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/game21/play"));
    }

    public function buttonStop(): ResponseInterface
    {
        $_SESSION["stop"] = true;
        while ($_SESSION["comSum"] <= $_SESSION["playerSum"]) {
            $com = new DiceHand($_SESSION["diceAmount"]);
            $com->rollDices();
            $com->getDicesValue();
            $sum = $com->getDiceSum();
            $_SESSION["comSum"] += $sum;

            if ((int)$_SESSION["comSum"] > $_SESSION["playerSum"] && (int)$_SESSION["comSum"] < 21 || (int)$_SESSION["comSum"] == 21) {
                $_SESSION["comWins"] += 1;
                $_SESSION["stats"] = "Datorn vann!";   
            } else if ((int)$_SESSION["comSum"] > 21) {
                $_SESSION["stats"] = "Du vann!";
                $_SESSION["playerWins"] += 1;
            } else if ($_SESSION["playerSum"] == $_SESSION["comSum"]) {
                $_SESSION["stats"] = "Oavgjort!";
            }
        }
        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/game21/play"));
    }

    public function buttonReset() : ResponseInterface
    {
        $_SESSION["playerSum"] = 0;
        $_SESSION["comSum"] = 0;
        $_SESSION["stop"] = false;
        $_SESSION["playerDices"] = "";
        $_SESSION["stats"] = "";

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/game21/play"));
    }
}
