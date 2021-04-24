<?php

declare(strict_types=1);

namespace Mos\Functions;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

use gusu20\Dice\DiceHand;

/**
 * Functions.
 */


/**
 * Get the route path representing the page being requested.
 *
 * @return string with the route path requested.
 */
function getRoutePath(): string
{
    $offset = strlen(dirname($_SERVER["SCRIPT_NAME"]));
    $path   = substr($_SERVER["REQUEST_URI"], $offset);

    return $path;
}



/**
 * Render the view and return its rendered content.
 *
 * @param string $template to use when rendering the view.
 * @param array  $data     send to as variables to the view.
 *
 * @return string with the route path requested.
 */
function renderView(
    string $template,
    array $data = []
): string {
    extract($data);

    ob_start();
    require INSTALL_PATH . "/view/$template";
    $content = ob_get_contents();
    ob_end_clean();

    return ($content ? $content : "");
}



/**
 * Use Twig to render a view and return its rendered content.
 *
 * @param string $template to use when rendering the view.
 * @param array  $data     send to as variables to the view.
 *
 * @return string with the route path requested.
 */
function renderTwigView(
    string $template,
    array $data = []
): string {
    static $loader = null;
    static $twig = null;

    if (is_null($twig)) {
        $loader = new FilesystemLoader(
            INSTALL_PATH . "/view/twig"
        );
        // $twig = new \Twig\Environment($loader, [
        //     "cache" => INSTALL_PATH . "/cache/twig",
        // ]);
        $twig = new Environment($loader);
    }

    return $twig->render($template, $data);
}



/**
 * Send a response to the client.
 *
 * @param int    $status   HTTP status code to send to client.
 *
 * @return void
 */
function sendResponse(string $body, int $status = 200): void
{
    http_response_code($status);
    echo $body;
}



/**
 * Redirect to an url.
 *
 * @param string $url where to redirect.
 *
 * @return void
 */
function redirectTo(string $url): void
{
    http_response_code(200);
    header("Location: $url");
}



/**
 * Create an url into the website using the path and prepend the baseurl
 * to the current website.
 *
 * @param string $path to use to create the url.
 *
 * @return string with the route path requested.
 */
function url(string $path): string
{
    return getBaseUrl() . $path;
}



/**
 * Get the base url from the request, relative to the htdoc/ directory.
 *
 * @return string as the base url.
 */
function getBaseUrl()
{
    static $baseUrl = null;

    if ($baseUrl) {
        return $baseUrl;
    }

    $scriptName = rawurldecode($_SERVER["SCRIPT_NAME"]);
    $path = rtrim(dirname($scriptName), "/");

    // Prepare to create baseUrl by using currentUrl
    $parts = parse_url(getCurrentUrl());

    // Build the base url from its parts
    $siteUrl = "{$parts["scheme"]}://{$parts["host"]}"
        . (isset($parts["port"])
            ? ":{$parts["port"]}"
            : "");
    $baseUrl = $siteUrl . $path;

    return $baseUrl;
}



/**
 * Get the current url of the request.
 *
 * @return string as current url.
 */
function getCurrentUrl(): string
{
    $scheme = $_SERVER["REQUEST_SCHEME"];
    $server = $_SERVER["SERVER_NAME"];

    $port  = $_SERVER["SERVER_PORT"];
    $port  = ($port === "80")
        ? ""
        : (($port === 443 && $_SERVER["HTTPS"] === "on")
            ? ""
            : ":" . $port);

    $uri = rtrim(rawurldecode($_SERVER["REQUEST_URI"]), "/");

    $url  = htmlspecialchars($scheme) . "://";
    $url .= htmlspecialchars($server)
        . $port . htmlspecialchars(rawurldecode($uri));

    return $url;
}



/**
 * Destroy the session.
 *
 * @return void
 */
function destroySession(): void
{
    $_SESSION = [];

    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }

    session_destroy();
}

function initGame21() : void
{
    $_SESSION["playerSum"] = 0;
    $_SESSION["comSum"] = 0;
    $_SESSION["playerWins"] = 0;
    $_SESSION["comWins"] = 0;
    $_SESSION["stop"] = false;
    $_SESSION["stats"] = "";
}

function buttonRoll() : void
{
    if (!$_SESSION["stop"] && $_SESSION["playerSum"] < 21)
    {
        $player = new DiceHand($_SESSION["diceAmount"]);
        $player->rollDices();
        $player->getDicesValue();
        $sum = $player->getDiceSum();
        $_SESSION["playerSum"] += $sum;
        $dices = $player->getDicesGraphic();
        $_SESSION["playerDices"] = $dices;

        if ($_SESSION["playerSum"] == 21)
        {
            $_SESSION["stats"] = "Du vann!";
            $_SESSION["playerWins"] += 1;
        } else if ($_SESSION["playerSum"] > 21)
        {
            $_SESSION["stats"] = "Datorn vann!";
            $_SESSION["comWins"] += 1;
        }
    }
}

function buttonStop(): void
{
    $_SESSION["stop"] = true;
    while ($_SESSION["comSum"] < $_SESSION["playerSum"])
    {
        $com = new DiceHand($_SESSION["diceAmount"]);
        $com->rollDices();
        $com->getDicesValue();
        $_SESSION["comSum"] += $com->getDiceSum();

        if($_SESSION["comSum"] > $_SESSION["playerSum"] && $_SESSION["comSum"] < 21 || $_SESSION["comSum"] == 21)
        {
            $_SESSION["comWins"] += 1;
            $_SESSION["stats"] = "Datorn vann!";   
        } else if($_SESSION["comSum"] > 21)
        {
            $_SESSION["stats"] = "Du vann!";
            $_SESSION["playerWins"] += 1;
        } else if ($_SESSION["playerSum"] == $_SESSION["comSum"])
        {
            $_SESSION["stats"] = "Oavgjort!";
        }
    }
}

function buttonReset() : void
{
    $_SESSION["playerSum"] = 0;
    $_SESSION["comSum"] = 0;
    $_SESSION["stop"] = false;
    $_SESSION["stats"] = "";
}