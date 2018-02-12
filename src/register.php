<?php


    use Silex\Provider\AssetServiceProvider;
    use Silex\Provider\TwigServiceProvider;
    use Silex\Provider\ServiceControllerServiceProvider;
    use Silex\Provider\HttpFragmentServiceProvider;
    use Corllete\SilexMongoDB\Provider\MongoDBServiceProvider;

    $app->register(new ServiceControllerServiceProvider()); // Chargement des Controleur Provider
    $app->register(new AssetServiceProvider()); // Chargement de la gestion des Asset
    $app->register(new TwigServiceProvider()); // Chargement de Twig
    $app->register(new HttpFragmentServiceProvider()); // Chargement des Fragment HTTP (Request, Response)
    $app['twig'] = $app->extend('twig', function ($twig, $app) {
        // add custom globals, filters, tags, ...

        return $twig;
    });
    $app['twig.path'] = array(__DIR__.'/../templates'); // Dossier des pages Twig
    // $app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig'); // Dossier des caches des pages Twig

    $app->register(new Silex\Provider\DoctrineServiceProvider(), array(
        'db.options' => array(
            'host'   => 'localhost',
            'user'     => 'root',
            'password'     => '',
            'dbname'     => 'db_mmmh',
        ),
    ));

    // connection uri: mongodb://localhost:27017
    $app->register(new MongoDBServiceProvider());

    // $app->register(new MongoDBServiceProvider(), [
    //     'mongodb.options' => [
    //         'host' => 'sitemmmhwf3.betawf3',
    //         'port' => '51727',
    //         'username' => 'betawf3',
    //         'password' => 'betawf3',
    //         'database' => 'sitemmmhwf3',
    //     ],
    // ]);

    $app->register(new MongoDBServiceProvider(), [
        'mongodb.options' => [
            'uri' => 'mongodb://betawf3:betawf3@ds251727.mlab.com:51727/sitemmmhwf3'
        ],
    ]);

/*
    // clés Amazon Web Services - à remplir avec les vraies clés -> VOIR index.php
    $app["amazon"] = array(
        's3' => new AmazonS3(),
        'AWS_REGION' => "AmazonS3::REGION_EU_W1",
        'BUCKET_NAME' => "webforce3",
        'AWS_URL' => "https://xxxxxxxxxxx.s3.amazonaws.com/",
    );
*/