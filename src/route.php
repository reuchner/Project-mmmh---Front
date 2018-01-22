<?php

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

//Request::setTrustedProxies(array('127.0.0.1'));

/********************************************************************************/
/****************** Home ********************************************************/
/********************************************************************************/



$app->get('/', function () use ($app) {
    return $app['twig']->render('pages/home.html.twig', array(
        // 'user'=> "expert",
        // 'prenom'=> "Pierre",
        // 'nom'=> "Paul"
    ));
})
->bind('home')->before($isConnectNo);

$app->get('/logout', function () use ($app) {
    setcookie('mmmh', NULL, -1); // Modification du cookie( Valeur null et temps -1)
    unset($_COOKIE['mmmh']); // Suppression de la variable COOKIE
    unset($_SESSION["user"]); // Suppression de la variable SESSION
    session_destroy(); // Suppression de la SESSION
    return $app->redirect("login"); // Redirection
})->bind("logout");




/********************************************************************************/
/********************** Connexion ***********************************************/ 
/********************************************************************************/



$app->get("/login", function() use ($app){
    return $app["twig"]->render("login-register/login.html.twig", array());
})->bind("login")->before($isConnectYes);
$app->post("/login", "Webforce3\Controlleur\AuthControlleur::login");



/********************************************************************************/
/*********************** Page profil ********************************************/
/********************************************************************************/



$app->get("/profil", function() use ($app){
    return $app["twig"]->render("pages/profil.html.twig", array());
})->bind("profil");



/********************************************************************************/
/*********************** Pages contenu ******************************************/
/********************************************************************************/



$app->get("/ajout_recette", function() use ($app){
    return $app["twig"]->render("pages/ajout-recette.html.twig", array());
})->bind("ajout_recette");

$app->get("/liste_recette", function() use ($app){
    return $app["twig"]->render("pages/listeRecette.html.twig", array());
})->bind("liste_recette");

$app->get("/ajout_conseil", function() use ($app){
    return $app["twig"]->render("pages/ajout-conseil.html.twig", array());
})->bind("ajout_conseil");



/********************************************************************************/
/************************** Pages Admin *****************************************/
/********************************************************************************/



$app->get("/formMembre", function() use ($app){
    return $app["twig"]->render("pages/pageAdmin/formMembre.html.twig", array());
})->bind("formMembre");

$app->get("/listeMembre", function() use ($app){
    return $app["twig"]->render("pages/pageAdmin/listeMembre.html.twig", array());
})->bind("listeMembre");

$app->get("/ajoutMembre", function() use ($app){
    return $app["twig"]->render("pages/pageAdmin/ajoutMembre.html.twig", array());
})->bind("ajoutMembre");



/********************************************************************************/
/************************** Pages erreur *****************************************/
/********************************************************************************/



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
