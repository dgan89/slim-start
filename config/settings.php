<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header
        'siteName' => 'Sms Center',
        // Renderer settings
        'renderer' => [
            'template_path' => __DIR__ . '/../templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],
        
        // DB settings
        'db' => [
            'dns' => 'mysql:host=localhost;dbname=razmik_smska;charset=utf8',
            'login' => 'razmik_razmik',
            'password' => 'dgan1989',
            'dbase' => 'razmik_smska'
        ],
    ],
];
