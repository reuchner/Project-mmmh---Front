<?php

    session_start();
    // ini_set('display_errors', 0); // Message d'erreur n'apparait pas

    require_once __DIR__.'/../vendor/autoload.php';

    use Silex\Application;
    $app = new Application();
    $app['debug'] = true;
    require __DIR__.'/../src/register.php';
    require __DIR__.'/../src/middleware.php';
    require __DIR__.'/../src/route.php';
    require __DIR__.'/../src/Controlleur/AuthControlleur.php';
    require __DIR__.'/../src/Controlleur/RegisterController.php';
    
    $app->run();
