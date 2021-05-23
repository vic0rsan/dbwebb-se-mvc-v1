<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;

use function Mos\Functions\renderView;
use function Mos\Functions\url;

use gusu20\Dice\Game21;

class Game21Con
{
    public function init(): ResponseInterface
    {
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
        $_SESSION["diceAmount"] = (int)$_POST["dices"] ?? 0;
        $_SESSION["playerSum"] = 0;
        $_SESSION["playerWins"] = 0;
        $_SESSION["comWins"] = 0;
        $_SESSION["stop"] = false;
        $_SESSION["stats"] = null;

        $player = new Game21();
        $player->player();

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
        $player = new Game21();
        $player->player();

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/game21/play"));
    }

    public function buttonStop(): ResponseInterface
    {
        $com = new Game21();
        $com->com();

        $_SESSION["stop"] = true;

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/game21/play"));
    }

    public function buttonReset(): ResponseInterface
    {
        $_SESSION["playerSum"] = 0;
        $_SESSION["comSum"] = 0;
        $_SESSION["stop"] = false;
        $_SESSION["playerDices"] = "";
        $_SESSION["stats"] = "";

        $player = new Game21();
        $player->player();

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/game21/play"));
    }
}
