<?php
// Application middleware

// e.g: $app->add(new \Slim\Csrf\Guard);


use Tuupola\Middleware\Cors;
use Gofabian\Negotiation\NegotiationMiddleware;
use Micheh\Cache\CacheUtil;

$app->add(new Cors([
    "origin" => ["*"],
    "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
    "headers.allow" => [],
    "headers.expose" => [],
    "credentials" => false,
    "cache" => 0,
]));