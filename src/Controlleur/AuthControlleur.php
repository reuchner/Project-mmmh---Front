<?php

    namespace Webforce3\Controlleur;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use \DateTime;

    class AuthControlleur{

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

            if(($password) == $user['password']){

                
                $app['db']->delete('tokens', array('user_id' => 1, "type" =>"connection"));

                $token = $this->generateToken();
                $dateExpire = $this->expireToken();


                $app['db']->insert('tokens', array(
                    'token' => $token,
                    'dateEnd' => $dateExpire,
                    'user_id' => $user['id'],
                    )
                );

                unset($user['password']);
                $user['token'] = $token;
                $user['dateEnd'] = $dateExpire;
                $_SESSION["user"] = $user;
                setcookie("mmmh", $token, time()+3600 * 24);
                return $app->redirect("home");
            }
            return $app->redirect("login");
        }


        


        private function generateToken(){
            return substr( md5( uniqid().mt_rand() ), 0, 22 );
        }

        private function expireToken(){
            $dateNow = new DateTime();
            $dateNow->modify("+ 1 day");
            return $dateNow->format("Y-m-d H:i:s");
        }



    }