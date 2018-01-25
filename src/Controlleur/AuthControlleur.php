<?php

    namespace Webforce3\Controlleur;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;

    class AuthControlleur extends Controlleur{
        // CONNEXION
        public function login(Request $request, Application $app){

            $email = strip_tags(trim($request->get("username")));
            $password = strip_tags(trim($request->get("password")));

            
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // Verification de l'email
                return $app->redirect("login");

            if(strlen($password) < 4 || strlen($password) > 40)
                return $app->redirect("login");

            $sql = "SELECT * FROM user WHERE email = ?";
            $user = $app['db']->fetchAssoc($sql, array((string) $email));
            if($user == false)
                return $app->redirect("login");

            if(md5($password) == $user['password']){ //changer la méthode de cryptage, md5 étant facile à déchiffrer

                
                $app['db']->delete('tokens', array('user_id' => $user['id']));

                $token = $this->generateToken();
                $dateExpire = $this->expireToken();


                $app['db']->insert('tokens', array(
                    'token' => $token,
                    'dateEnd' => $dateExpire,
                    'user_id' => $user['id'],
                    )
                );

                unset($user['password']);
                unset($user['id']);
                $user['token'] = $token;
                $user['dateEnd'] = $dateExpire;
                $_SESSION["user"] = $user;
                setcookie("mmmh", $token, time()+3600 * 24);
                return $app->redirect("/");
            }
            return $app->redirect("login");
        }

        // INSCRIPTION
        public function register(Request $request, Application $app){

            $username = strip_tags(trim($request->get("username")));
            $email = strip_tags(trim($request->get("email")));
            $password = strip_tags(trim($request->get("password")));

            if(strlen($username) < 2 || strlen($email) < 4 || strlen($password) < 4)
                return $app->redirect("register");

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // Verification de l'email
                return $app->redirect("register");

            $sql = "SELECT * FROM user WHERE email = ?";
            $user = $app['db']->fetchAssoc($sql, array((string)$email));
            if($user != false)
                return $app->redirect("register");


            $app['db']->insert('user', array(
                'username' => $username,
                'email' => $email,
                'password' => md5($password),
                )
            );
            
            return $app->redirect("login");
        
        }
    }