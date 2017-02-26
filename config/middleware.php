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

$container["HttpBasicAuthentication"] = function ($container) {
    return new HttpBasicAuthentication([
        "path" => ["/personal", "/admin"],
        //"passthrough" => ["/smska/list"],
        "relaxed" => ["smska.razmik.ru"],
        "realm" => "Protected",
        "secure" => true,
        "users" => [
            "admin-ilyha" => "dgan1989",
            "testik" => "testik",
        ],
        "error" => function ($request, $response, $arguments) {
            $data = [];
            $data["status"] = "error";
            $data["message"] = $arguments["message"];
            return $response->write(json_encode($data, JSON_UNESCAPED_SLASHES));
        }
    ]);
};

$container["JwtAuthentication"] = function ($container) {
    return new JwtAuthentication([
        "path" => "/api",
        "secure" => true,
        "relaxed" => ["smska.razmik.ru"],
        "secret" => "apismskakey", //eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJPbmxpbmUgSldUIEJ1aWxkZXIiLCJpYXQiOjE0ODUzNzI0MjQsImV4cCI6MTUxNjkwODQyNCwiYXVkIjoid3d3LmV4YW1wbGUuY29tIiwic3ViIjoianJvY2tldEBleGFtcGxlLmNvbSIsIkdpdmVuTmFtZSI6IkpvaG5ueSIsIlN1cm5hbWUiOiJSb2NrZXQiLCJFbWFpbCI6Impyb2NrZXRAZXhhbXBsZS5jb20iLCJSb2xlIjpbIk1hbmFnZXIiLCJQcm9qZWN0IEFkbWluaXN0cmF0b3IiXX0.orry5RaasdoKV3XZauJi708TWtRpYpWwk-w0oVwY6E0
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
