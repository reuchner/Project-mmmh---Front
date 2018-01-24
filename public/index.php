<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // clés Amazon Web Services - à remplir avec les vraies clés -> VOIR register.php
    define('AWS_ACCESS_KEY',"xxxxxxxxxxx");
    define('AWS_SECRET_KEY',"xxxxxxxxxxx");
    define('AWS_REGION',"AmazonS3::REGION_EU_W1");

    session_start();

    require_once __DIR__.'/../vendor/autoload.php';

    use Silex\Application;
    $app = new Application();
    $app['debug'] = true;

    require __DIR__.'/../src/lib/awssdk/sdk.class.php';
    require __DIR__.'/../src/register.php';
    require __DIR__.'/../src/middleware.php';
    require __DIR__.'/../src/route.php';
    require __DIR__.'/../src/Controlleur.php';
    require __DIR__.'/../src/Controlleur/AuthControlleur.php';
    require __DIR__.'/../src/Controlleur/RecipeControlleur.php';
    require __DIR__.'/../src/Controlleur/MembreControlleur.php';
    
    $app->run();
