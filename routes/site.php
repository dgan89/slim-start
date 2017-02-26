<?php

$app->get('/', function ($request, $response, $args) {
    return $this->renderer->render($response, 'site/index.phtml', ['title' => 'API for Arduino to send SMS']);
});
