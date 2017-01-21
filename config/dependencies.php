<?php
// DIC configuration

$container = $app->getContainer();

// view renderer
$container['renderer'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    return new Components\PhpRenderer($settings['template_path']);
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
    ]);
  
    return new \Spot\Locator($cfg);
};