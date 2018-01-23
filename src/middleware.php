<?php

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

$isConnectYes = function (Request $request, Application $app) {
    
    if( isset( $_COOKIE["mmmh"] ) ){
        $token = $_COOKIE["mmmh"];
        $sql = "SELECT user_id FROM tokens WHERE token = ?";
        $idUser = $app['db']->fetchAssoc($sql, array((string) $token));
        if($idUser != false){
            $sql = "SELECT * FROM user WHERE id = ?";
            $user = $app['db']->fetchAssoc($sql, array((int) $idUser['user_id']));
            unset($user['id']);
            unset($user['password']);
            $user['token'] = $token;
            $_SESSION["user"] = $user;
            setcookie("mmmh", $token, time()+3600 * 24);
            return $app->redirect("/");
            // return new RedirectResponse('/home');
        }
    }
    if( isset( $_SESSION["user"] ) )
        return $app->redirect("/");
        // return new RedirectResponse('/home');
};
$isConnectNo = function (Request $request, Application $app) {
    if( !isset( $_SESSION["user"] ) )
        return $app->redirect("login");
        // return new RedirectResponse('/login');
};

//******** verifParamLogin ******* */


$verifParamLogin = function (Request $request, Application $app) {
    $retour = verifParam($request->request, array("username", "email", "password"));
    var_dump($retour);
};

