<?php

    namespace Webforce3\Controlleur;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;

    class RecipeControlleur extends Controlleur {
 
        public function addRecipe(Request $request, Application $app){

            $recipe = array(
                "id" =>  $_POST["id"],
                "created_by" =>  $_SESSION["user"]["username"],
                "creadted_date" =>  date('d/m/Y'),
                "categorie" =>  $_POST["categorie"],
                "vignette_url" =>  "test",
                "carotte_reponse" =>  $_POST["carotte_reponse"],
                "carotte_tips" =>  $_POST["carotte_tips"],
                "carotte_recette" =>  $_POST["carotte_recette"],
                "nb_personne" =>  $_POST["nb_personne"],
                "tmp_preparation" =>  $_POST["tmp_preparation"],
                "tmpCuisson" =>  $_POST["tmpCuisson"],
                "vignette_title" =>  $_POST["vignette_title"],
                "vignette_subtitle" =>  $_POST["vignette_subtitle"],
                "description" =>  $_POST["description"],
            );
            $newRecipe = json_encode($this->arrayObjectRecipe($recipe)); // conversion du tableau en Json
            $app['db']->insert('recipes', array(
                'name' => $_POST["name"],
                'json' => $newRecipe,
                )
            );
            // $app['mongodb']->insertOne('recipes', array(
            //     'name' => $_POST["name"],
            //     'json' => $newRecipe,
            //     )
            // );
            return $app->redirect("liste_recette");
            
        }
 
        private function arrayObjectRecipe($data){

            return array(
                "_id" => $data["id"],
                "analyse" => array(
                    "type" => "autre",
                    "categorie" => $data["categorie"],
                    "sous_categorie" => "",
                    "work_to_do" => true,
                    "save" => array(
                        "status" => false,
                        "label" => ""
                    ),
                    "next" => array(
                        "contentID_default" => "",
                        "attendu" => array(
                            "forme" => "",
                            "rep_attendue" => [],
                            "contentID_rep_attendue" => []
                        )
                    ),
                    "etape" => array(
                        "précédente" => [],
                        "suivante" => []
                    ),
                    "info" => array(
                        "created_by" => $data["created_by"],
                        "creadted_date" => $data["creadted_date"],
                        "database" => "content"
                    ),
                    "audience" => array(
                        "abonnement" => [],
                        "data_custom" => [],
                        "data_interaction" => []
                    ),
                    "add_on" => array(
                        "status" => false,
                        "contentID" => ""
                    ),
                    "carotte" => array(
                        "reponse" => $data["carotte_reponse"],
                        "tips" => $data["carotte_tips"],
                        "recette" => $data["carotte_recette"]
                    ),
                    "vignette" => array(
                        "personne" => $data["nb_personne"],
                        "preparation" => $data["tmp_preparation"],
                        "cuisson" => $data["tmpCuisson"],
                        "budget" => " =>euro: :euro: :black_small_square:",
                        "difficulte" => " =>muscle: :muscle: :black_small_square:"
                    )
                ),
                "message" => [
                    array(
                        "contenu" => "DESCRIPTION",
                        "element" => [
                            array(
                                "text" => $data["description"]
                            )
                        ]
                    ),
                    array(
                        "contenu" => "VIGNETTE",
                        "element" => array(
                            "image_url" => $data["vignette_url"],
                            "title" => $data["vignette_title"],
                            "subtitle" => " =>busts_in_silhouette: 2 pers.\n:clock1: Préparation 20'\n:hourglass_flowing_sand: Cuisson 15'\n:moneybag: Budget :euro: :black_small_square: :black_small_square:\n:dart: Difficulté :muscle: :muscle: :black_small_square:"
                        )
                    ),
                    array(
                        "contenu" => "INGREDIENT",
                        "element" => [
                            array(
                                "attachment" => array(
                                    "type" => "template",
                                    "payload" => array(
                                        "template_type" => "button",
                                        "text" => "Choisis le nombre de convives pour cette recette :",
                                        "buttons" => [
                                            array(
                                                "type" => "postback",
                                                "title" => "2 convives :fork_and_knife:",
                                                "payload" => "#c_id#EDITION_NOEL/02/ENTREE/2_CONVIVES"
                                            ),
                                            array(
                                                "type" => "postback",
                                                "title" => "4 convives :fork_and_knife:",
                                                "payload" => "#c_id#EDITION_NOEL/02/ENTREE/4_CONVIVES"
                                            ),
                                            array(
                                                "type" => "postback",
                                                "title" => "6 convives :fork_and_knife:",
                                                "payload" => "#c_id#EDITION_NOEL/02/ENTREE/6_CONVIVES"
                                            )
                                        ]
                                    )
                                )
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_01",
                        "element" => [
                            array(
                                "text" => "C\u2019est parti ! On commence par la préparation des crevettes (2 par personne) :"
                            ),
                            array(
                                "text" => " =>small_blue_diamond: Décortique la crevette en commençant toujours par la tête pour mieux enlever le corps en un seul bloc."
                            ),
                            array(
                                "text" => "Le conseil de Chef Axel :\n:tophat: « Je te conseille de \u201cchâtrer\u201c la crevette : c'est lui inciser le dos, pour enlever le boyau qui donne un goût amer à la crevette à la cuisson. Attention le liquide qui sort de la tête peut-être très tâchant. »"
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_02",
                        "element" => [
                            array(
                                "text" => "On enchaîne avec les Saint-Jacques (3 par personne) :"
                            ),
                            array(
                                "text" => " =>small_blue_diamond: Si les Saint-Jacques ont encore des coraux, enlèves-les en tirant délicatement, et conserve-les."
                            ),
                            array(
                                "text" => " =>tophat: « Si tu les a acheté congelées, fais-les toujours décongeler la veille dans du lait ! Surtout vérifie bien la provenance : origine France uniquement. Sinon, gros risque que les Saint-Jacques aient été gorgée d'eau pour paraître plus grosses (elles diminueront alors de moitié à la cuisson...) »"
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_03",
                        "element" => [
                            array(
                                "text" => "Attaquons maintenant la sauce corail (si tu en avais avec les Saint-Jacques) :"
                            ),
                            array(
                                "text" => " =>small_blue_diamond: Les coraux vont te servir pour faire la sauce qui va accompagner la salade de mâche. Ça \u201cmâche\u201c bien entre eux 2 :wink:\n:small_blue_diamond: Dé-chemise l\u2019ail (½ par personne) et émince-la, puis cisèle ton persil plat (2 brins par personne)."
                            ),
                            array(
                                "text" => " =>tophat: « Je dégerme toujours l\u2019ail, car il est indigeste et devient amer à la cuisson. En revanche quand il est sorti de 5 mm il devient excellent pour la santé ! »\n\n:tophat: « J\u2019utilise du persil plat : beaucoup + de goût que le persil frisé. D\u2019ailleurs j\u2019utilise aussi les tiges car celles-ci contiennent plus de goût que les feuilles. »"
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_04",
                        "element" => [
                            array(
                                "text" => "C\u2019est le moment de passer à la cuisson de la sauce :"
                            ),
                            array(
                                "text" => " =>small_blue_diamond: Fais chauffer de l'huile d'olive dans une poêle, puis fais revenir l\u2019ail et le persil plat.\n:small_blue_diamond: Ajoute les coraux, fais-les revenir moins de deux minutes, puis ajoute la crème.\n:small_blue_diamond: Baisse le feu quand c'est à ébullition, attend que ça réduise un peu, puis coupe le feu.\n:small_blue_diamond: Tu peux maintenant mixer toute la préparation et réserver au froid : la sauce salade est prête !"
                            ),
                            array(
                                "text" => " =>tophat: « Tu peux garder la même poêle pour cuire les poireaux, pas besoin de faire plus de vaisselle :wink: »"
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_05",
                        "element" => [
                            array(
                                "text" => "Avant-dernière étape, la préparation des poireaux (80g par personne) :"
                            ),
                            array(
                                "text" => " =>small_blue_diamond: Lave tes poireaux, émince-les finement, et fais-les revenir dans la poêle avec de l\u2019huile d\u2019olive.\n:small_blue_diamond: Quand les poireaux deviennent transparents et que l'eau s'est évaporée, ajoute le Nolly Prat (1,5 càs par personne) et fais tout flamber ! N'hésite pas à inviter des amis pour cette étape, c'est joli ;)\n:small_blue_diamond: Une fois flambé tu peux laisser hors du feu, saler et poivrer."
                            ),
                            array(
                                "text" => " =>tophat: « Pour laver les poireaux, je les laisse tremper dans de l'eau avec 1 verre de vinaigre blanc. Et ce serait dommage de jeter le vert qui reste, garde le pour une soupe. »"
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_06",
                        "element" => [
                            array(
                                "text" => "On termine par le montage pour des aumônières :"
                            ),
                            array(
                                "metadata" => "RECETTE/10/EDITION_NOEL/91/ENTREE",
                                "attachment" => array(
                                    "type" => "template",
                                    "payload" => array(
                                        "template_type" => "generic",
                                        "image_aspect_ratio" => "square",
                                        "elements" => [
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(12).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(13).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(14).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(15).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(16).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(17).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(18).jpg"
                                            ),
                                            array(
                                                "title" => "Suite :fast_forward:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(19).jpg"
                                            ),
                                            array(
                                                "title" => "FIN",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/FEUILLE+DE+BRICK/RECETTE+10+EDITION+NOEL+91+ENTREE+(20).jpg"
                                            )
                                        ]
                                    )
                                )
                            ),
                            array(
                                "text" => " =>small_blue_diamond: Comme sur les photos :point_up:, dispose 2 feuilles de brick par personne que tu superposes, et décales-en une pour former une étoile.\n:small_blue_diamond: Mets la chapelure au centre (1 càs par personne), dispose les poireaux avec les Saint-Jacques et les crevettes.\n:small_blue_diamond: Referme la brick en aumônière et fais un nœud avec du fil à rôti.\n:small_blue_diamond: Direction le four pour 15 min à 160°C."
                            ),
                            array(
                                "text" => " =>tophat: « Pourquoi de la chapelure ? Car elle absorbe les excédents d\u2019eau rendus par les St-Jacques et crevettes, ça évite de percer la feuille de brick. »"
                            )
                        ]
                    ),
                    array(
                        "contenu" => "ETAPE_07",
                        "element" => [
                            array(
                                "text" => "Voici une inspiration de dressage des assiettes !"
                            ),
                            array(
                                "metadata" => "RECETTE/10/EDITION_NOEL/91/ENTREE",
                                "attachment" => array(
                                    "type" => "template",
                                    "payload" => array(
                                        "template_type" => "generic",
                                        "image_aspect_ratio" => "square",
                                        "elements" => [
                                            array(
                                                "title" => "Pour partager la recette, c'est ici :point_down:",
                                                "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/RECETTE+10+EDITION+NOEL+91+ENTREE+(26).jpg",
                                                "buttons" => [
                                                    array(
                                                        "type" => "element_share",
                                                        "share_contents" => array(
                                                            "attachment" => array(
                                                                "type" => "template",
                                                                "payload" => array(
                                                                    "template_type" => "generic",
                                                                    "image_aspect_ratio" => "square",
                                                                    "elements" => [
                                                                        array(
                                                                            "title" => "[:santa: Édition de Noël] Aumonière aux douceurs de la mer",
                                                                            "subtitle" => "Tu dois absolument lire cette recette de Mmmh!\nClique sur voir.",
                                                                            "image_url" => "https://s3-eu-west-1.amazonaws.com/mmmh-image/Recette/10+Edition+Noel/ENTREE/RECETTE+10+EDITION+NOEL+91+ENTREE.jpg",
                                                                            "default_action" => array(
                                                                                "type" => "web_url",
                                                                                "url" => "http://www.m.me/mercimmITION_NOEL/91/ENTREE/08/ETAPE_07"
                                                                            ),
                                                                            "buttons" => [
                                                                                array(
                                                                                    "type" => "web_url",
                                                                                    "url" => "http://www.m.me/mercimmITION_NOEL/91/ENTREE/08/ETAPE_07",
                                                                                    "title" => " =>point_right: VOIR :point_left:"
                                                                                )
                                                                            ]
                                                                        )
                                                                    ]
                                                                )
                                                            )
                                                        )
                                                    )
                                                ]
                                            )
                                        ]
                                    )
                                )
                            )
                        ]
                    )
                ]
                                                                                );
        }

        public function selectRecipe(Request $request, Application $app){
            $users = $app['db']->fetchAll('SELECT id, name, json  FROM recipes');           
            return $app["twig"]->render("pages/pageAdmin/listeMembre.html.twig", array("users" => $users));
        }

        public function selectMembre(Request $request, Application $app, $id){


            $sql = "SELECT id, name, json  FROM recipes WHERE id = ?";
            $recipe = $app['db']->fetchAll($sql, array((int)$id));

            if(empty($recipe))
                return $app->redirect("/");
                
            return $app["twig"]->render("pages/profil.html.twig", array(
                "id" => $id,
                "name" => $recipe[0]["name"],
                "json" => $recipe[0]["json"],
                
            ));
        }

    }