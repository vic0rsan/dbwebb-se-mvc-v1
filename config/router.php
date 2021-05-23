<?php

/**
 * Load the routes into the router, this file is included from
 * `htdocs/index.php` during the bootstrapping to prepare for the request to
 * be handled.
 */

declare(strict_types=1);

use FastRoute\RouteCollector;

$router = $router ?? null;

$router->addRoute("GET", "/test", function () {
    // A quick and dirty way to test the router or the request.
    return "Testing response";
});

$router->addRoute("GET", "/", "\Mos\Controller\Index");
$router->addRoute("GET", "/debug", "\Mos\Controller\Debug");
$router->addRoute("GET", "/twig", "\Mos\Controller\TwigView");

$router->addGroup("/session", function (RouteCollector $router) {
    $router->addRoute("GET", "", ["\Mos\Controller\Session", "index"]);
    $router->addRoute("GET", "/destroy", ["\Mos\Controller\Session", "destroy"]);
});

$router->addGroup("/some", function (RouteCollector $router) {
    $router->addRoute("GET", "/where", ["\Mos\Controller\Sample", "where"]);
});

$router->addGroup("/form", function (RouteCollector $router) {
    $router->addRoute("GET", "/view", ["\Mos\Controller\Form", "view"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Form", "process"]);
});

$router->addGroup("/game21", function (RouteCollector $router) {
    $router->addRoute("GET", "/init", ["\Mos\Controller\Game21Con", "init"]);
    $router->addRoute("POST", "/process", ["\Mos\Controller\Game21Con", "process"]);
    $router->addRoute("GET", "/play", ["\Mos\Controller\Game21Con", "play"]);
    $router->addRoute("POST", "/roll", ["\Mos\Controller\Game21Con", "buttonRoll"]);
    $router->addRoute("POST", "/stop", ["\Mos\Controller\Game21Con", "buttonStop"]);
    $router->addRoute("POST", "/reset", ["\Mos\Controller\Game21Con", "buttonReset"]);
});

$router->addGroup("/yatzy", function (RouteCollector $router) {
    $router->addRoute("GET", "/play", ["\Mos\Controller\YatzyCon", "play"]);
    $router->addRoute("POST", "/roll", ["\Mos\Controller\YatzyCon", "buttonRoll"]);
    $router->addRoute("POST", "/reset", ["\Mos\Controller\YatzyCon", "buttonReset"]);
});
