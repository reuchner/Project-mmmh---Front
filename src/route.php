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
->bind('/')->before($isConnectNo);

$app->get('/home', function () use ($app) {

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

$app->get("/register", function() use ($app){
    return $app["twig"]->render("login-register/register.html.twig", array());
})->bind("register");
$app->post("/register", "Webforce3\Controlleur\AuthControlleur::register");


/********************************************************************************/
/*********************** Page profil ********************************************/
/********************************************************************************/



$app->get("/profil", "Webforce3\Controlleur\MembreControlleur::editProfilView")->bind("profil");
$app->post("/profil", "Webforce3\Controlleur\MembreControlleur::editProfil");



/********************************************************************************/
/*********************** Pages contenu ******************************************/
/********************************************************************************/



$app->get("/ajout_recette", function() use ($app){

    $sql = "SELECT * FROM categories";
    $categories = $app['db']->fetchAll($sql);
    return $app["twig"]->render("pages/ajout-recette.html.twig", array(
        "categories" => $categories,
    ));
})->bind("ajout_recette");
$app->post("/ajout_recette", "Webforce3\Controlleur\RecipeControlleur::addRecipe");


$app->get("/liste_recette", function() use ($app){
    $sql = "SELECT * FROM recipes";
    $recipes = $app['db']->fetchAll($sql);
    return $app["twig"]->render("pages/listeRecette.html.twig", array(
        "recipes" => $recipes,
    ));
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

$app->get("/ajoutMembre", function() use ($app){
    return $app["twig"]->render("pages/pageAdmin/ajoutMembre.html.twig", array("error" => ""));
})->bind("ajoutMembre");
$app->post("/ajoutMembre", "Webforce3\Controlleur\MembreControlleur::insertMembre")->bind("insertMembre");

$app->get("/membre", "Webforce3\Controlleur\MembreControlleur::selectMembres")->bind("listeMembre");
$app->get("/membre/{id}", "Webforce3\Controlleur\MembreControlleur::selectMembre")->bind("infoMembre");
$app->post("/membre/{id}", "Webforce3\Controlleur\MembreControlleur::editProfil");



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
