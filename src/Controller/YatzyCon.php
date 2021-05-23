<?php

declare(strict_types=1);

namespace Mos\Controller;

use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Http\Message\ResponseInterface;
use function Mos\Functions\destroySession;
use function Mos\Functions\renderView;
use function Mos\Functions\url;
use gusu20\Dice\Yatzy;

class YatzyCon
{
    public function play(): ResponseInterface
    {
        $data = [
            "header" => "Yatzy",
            "message" => "Spela Yatzy med 1-6:or!"
        ];
        $body = renderView("layout/yatzy.php", $data);

        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(200)
            ->withBody($psr17Factory->createStream($body));
    }

    public function buttonRoll(): ResponseInterface
    {
        $hand = new Yatzy();
        $_SESSION["slots"] = $_POST["dice"] ?? array();
        $_SESSION["values"] = $_SESSION["values"] ?? array();
        $_SESSION["rolls"] = $_SESSION["rolls"] ?? 0;
        $_SESSION["tries"] = $_SESSION["tries"] ?? 4;
        $_SESSION["rounds"] = $_SESSION["rounds"] ?? 1;
        $_SESSION["sum"] = $_SESSION["sum"] ?? 0;
        $_SESSION["check"] = $_SESSION["check"] = 0;

        $hand->rollYatzy();
        $hand->getRounds();
        
        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/yatzy/play"));
    }

    public function buttonReset(): ResponseInterface
    {
        destroySession();
        $psr17Factory = new Psr17Factory();
        return $psr17Factory
            ->createResponse(301)
            ->withHeader("Location", url("/yatzy/play"));
    }
}
