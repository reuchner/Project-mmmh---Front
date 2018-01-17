<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

//home
$app->get('/', function () use ($app) {
    return $app['twig']->render('pages/home.html.twig', array(
        // 'user'=> "expert",
        // 'prenom'=> "Pierre",
        // 'nom'=> "Paul"
    ));
})
->bind('home2')->before($isConnectNo);

$app->get('/home', function () use ($app) {
    return $app['twig']->render('pages/home.html.twig', array());
})->bind("home")->before($isConnectNo);


//connexion 
$app->get("/login", function() use ($app){
    return $app["twig"]->render("login-register/login.html.twig", array());
})->bind("login")->before($isConnectYes);
$app->post("/login", "Webforce3\Controlleur\AuthControlleur::login");
$app->get("/register", function() use ($app){
    return $app["twig"]->render("login-register/register.html.twig", array());
})->bind("register")->before($isConnectYes);


// *************  route inscription ************ //

$app->get('/register', function () use ($app){
    return $app['twig']->render('login-register/register.html.twig', array());
})->bind("register");

$app->post("/register", "Webforce3\Controlleur\IndexController::registerAction");











//page Expert
$app->get("/profil", function() use ($app){
    return $app["twig"]->render("pages/pagesExpert/profil.html.twig", array());
})->bind("profil");
$app->get("/question", function() use ($app){
    return $app["twig"]->render("pages/pagesExpert/questionConso.html.twig", array());
})->bind("question");
$app->get("/contenu", function() use ($app){
    return $app["twig"]->render("test/ajout-contenu.html.twig", array());
})->bind("contenu");



















//page Admin
$app->get("/formExpert", function() use ($app){
    return $app["twig"]->render("pages/pageAdmin/formExpert.html.twig", array());
})->bind("formExpert");

$app->get("/formEquipe", function() use ($app){
    return $app["twig"]->render("pages/pageAdmin/formEquipe.html.twig", array());
})->bind("formEquipe");






















//page Membre
$app->get("/filtre", function() use ($app){
    return $app["twig"]->render("pages/pageMembre/filtre.html.twig", array());
})->bind("filtre");
$app->get("/reponse", function() use ($app){
    return $app["twig"]->render("pages/pageMembre/gestionReponse.html.twig", array());
})->bind("reponse");
$app->get("/listeConso", function() use ($app){
    return $app["twig"]->render("pages/pageMembre/listeConso.html.twig", array());
})->bind("listeConso");

































$app->error(function (\Exception $e, Request $request, $code) use ($app) {
    if ($app['debug']) {
        return;
    }

    // 404.html, or 40x.html, or 4xx.html, or error.html
    $templates = array(
        'errors/'.$code.'.html.twig',
        'errors/'.substr($code, 0, 2).'x.html.twig',
        'errors/'.substr($code, 0, 1).'xx.html.twig',
        'errors/error.html.twig',
    );

    return new Response($app['twig']->resolveTemplate($templates)->render(array('code' => $code)), $code);
});
