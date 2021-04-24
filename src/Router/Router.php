<?php

declare(strict_types=1);

namespace Mos\Router;

use function Mos\Functions\{
    destroySession,
    redirectTo,
    renderView,
    renderTwigView,
    sendResponse,
    url,
    initGame21,
    buttonRoll,
    buttonStop,
    buttonReset
};

/**
 * Class Router.
 */
class Router
{
    public static function dispatch(string $method, string $path): void
    {
        if ($method === "GET" && $path === "/") {
            $data = [
                "header" => "Index page",
                "message" => "Hello, this is the index page, rendered as a layout.",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session") {
            $body = renderView("layout/session.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/session/destroy") {
            destroySession();
            redirectTo(url("/session"));
            return;
        } else if ($method === "GET" && $path === "/debug") {
            $body = renderView("layout/debug.php");
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/twig") {
            $data = [
                "header" => "Twig page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderTwigView("index.html", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/some/where") {
            $data = [
                "header" => "Rainbow page",
                "message" => "Hey, edit this to do it youreself!",
            ];
            $body = renderView("layout/page.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "GET" && $path === "/form/view") {
            $data = [
                "header" => "Form",
                "message" => "Press submit to send the message to the result page.",
                "action" => url("/form/process"),
                "output" => $_SESSION["output"] ?? null,
            ];
            $body = renderView("layout/form.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "POST" && $path === "/form/process") {
            $_SESSION["output"] = $_POST["content"] ?? null;
            redirectTo(url("/form/view"));
            return;
        } else if ($method === "GET" && $path === "/game21start") {
            $data = [
                "header" => "Game21",
                "message" => "Spela game21 mot datorn.",
                "action" => url("/game21start/process")
            ];
            $body = renderView("layout/game21start.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "POST" && $path === "/game21start/process") {
            $_SESSION["diceAmount"] = (int)$_POST["dices"];
            initGame21();
            buttonRoll();
            redirectTo(url("/game21"));
            return;
        } else if ($method === "GET" && $path === "/game21") {
            $data = [
                "header" => "Game21",
                "message" => "Reger: Försök att få en summa närmast 21, men ej större."
            ];
            $body = renderView("layout/game21.php", $data);
            sendResponse($body);
            return;
        } else if ($method === "POST" && $path === "/game21/roll") {
            buttonRoll();
            redirectTo(url("/game21"));
            return;
        } else if ($method === "POST" && $path === "/game21/stop") {
            buttonStop();
            redirectTo(url("/game21"));
            return;
        } else if ($method === "POST" && $path === "/game21/reset") {
            buttonReset();
            buttonRoll();
            redirectTo(url("/game21"));
            return;
        }
        $data = [
            "header" => "404",
            "message" => "The page you are requesting is not here. You may also checkout the HTTP response code, it should be 404.",
        ];
        $body = renderView("layout/page.php", $data);
        sendResponse($body, 404);
    }
}
