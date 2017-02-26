<?php
// DIC configuration

$container = $app->getContainer();


$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard(); 
};
// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $renderer = new Components\PhpRenderer($settings['template_path']);
    $renderer->addAttribute('siteName', $c->get('settings')['siteName']);
    
    $csrf = (object)[
        'keys' => (object)[
            'name' => $c->csrf->getTokenNameKey(),
            'value' => $c->csrf->getTokenValueKey()
        ],
        'name' => $c->csrf->getTokenName(),
        'value' => $c->csrf->getTokenValue()
    ];
    $renderer->addAttribute('csrf', $csrf);
    
    return $renderer;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

// spot
$container['spot'] = function ($c) {
    $settings = $c->get('settings')['db'];
    
    $cfg = new \Spot\Config();
  
    $cfg->addConnection('mysql', [
      'dbname' => $settings['dbase'],
      'user' => $settings['login'],
      'password' => $settings['password'],
      'host' => 'localhost',
      'driver' => 'pdo_mysql',
      'charset' => 'utf8',
    ]);
  
    return new \Spot\Locator($cfg);
};

$container["cache"] = function ($container) {
    return new \Micheh\Cache\CacheUtil();
};

$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};