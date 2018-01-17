<?php

    

    function register(array $user, $app){ // Typage donnée en sortie (Null ou string);

        if(!isset($user["firstname"]) || !isset($user["lastname"]) || !isset($user["password"]) || !isset($user["email"]) ) // Verificaion de l'existance des key dans l'array
            return false;

        

        if(empty(trim($user["firstname"])) || empty(trim($user["lastname"])) || empty(trim($user["password"]) || !isset($user["email"]) )) // Verification - remplie
            return false;

        $firstname = htmlspecialchars(trim($user["firstname"])); // Modification des balises html
        $lastname = strip_tags(trim($user["lastname"])); // Suppression des balise html php
        $password = strip_tags(trim($user["password"])); // Suppression des balise html php
        $email = strip_tags(trim($user["email"])); // Suppression des balise html php


        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // Verification de l'email
            return false;


        

                $app['db']->insert('user', array(
                    'firstname' => $user["firstname"],
                    'lastname' => $user["lastname"],
                    'password' => md5($user["password"]),
                    'email' => $user["email"],
                  )
                );
            return true;
            

       

    }