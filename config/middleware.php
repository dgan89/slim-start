<?php
/*
 * This file is part of the Slim API skeleton package
 *
 * Copyright (c) 2016-2017 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   https://github.com/tuupola/slim-api-skeleton
 *
 */

use Slim\Middleware\JwtAuthentication;
use Slim\Middleware\HttpBasicAuthentication;
use Tuupola\Middleware\Cors;
use Gofabian\Negotiation\NegotiationMiddleware;

$container = $app->getContainer();

$params = require ('params.php');

$container["HttpBasicAuthentication"] = function ($container) use ($params) {
    return new HttpBasicAuthentication([
        "path" => ["/personal", "/admin"],
        //"passthrough" => ["/smska/list"],
        "relaxed" => ["smska.razmik.ru"],
        "realm" => "Protected",
        "secure" => true,
        "users" => $params['BasicAuthUseres'],
        "error" => function ($request, $response, $arguments) {
            $data = [];
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        }
    ]);
};

$container["JwtAuthentication"] = function ($container) use ($params) {
    return new JwtAuthentication([
        "path" => "/api",
        "secure" => true,
        "relaxed" => ["smska.razmik.ru"],
        "secret" => $params['JwtAuthSecret']
    ]);
};
$container["Cors"] = function ($container) {
    return new Cors([
        "origin" => ["*"],
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE"],
        "headers.allow" => ["Authorization", "If-Match", "If-Unmodified-Since"],
        "headers.expose" => ["Etag"],
        "credentials" => true,
        "cache" => 86400
    ]);
};
$container["Negotiation"] = function ($container) {
    return new NegotiationMiddleware([
        "accept" => ["application/json"]
    ]);
};

$app->add("HttpBasicAuthentication");
$app->add("JwtAuthentication");
$app->add("Cors");
$app->add("Negotiation");
