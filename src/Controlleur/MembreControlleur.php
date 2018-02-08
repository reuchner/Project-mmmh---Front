<?php

    namespace Webforce3\Controlleur;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use \DateTime;

    class MembreControlleur{
        // MISE A JOUR DU PROFIL DU COMPTE CONNECTE
        public function editProfilView(Request $request, Application $app){

            $sql = "SELECT user_id FROM tokens WHERE token = ?";
            $idUser = (int)$app['db']->fetchAssoc($sql, array((string) $_SESSION["user"]["token"]))['user_id'];
            $users = $app['db']->fetchAll('SELECT id, username, firstname, lastname, email, tel,statuts, created FROM user WHERE id ='.$idUser)[0];

            return $app["twig"]->render("pages/profil.html.twig", array(
                "id" => $idUser,
                "username" => $users["username"],
                "firstname" => $users["firstname"],
                "lastname" => $users["lastname"],
                "email" => $users["email"],
                "phone" => $users["tel"],
                "statuts" => $users["statuts"],
            ));
        }

        public function editProfil(Request $request, Application $app){

            $id = strip_tags(trim($request->get("id")));
            $username = strip_tags(trim($request->get("username")));
            $firstname = strip_tags(trim($request->get("firstname")));
            $lastname = strip_tags(trim($request->get("lastname")));
            $email = strip_tags(trim($request->get("email")));
            $phone = strip_tags(trim($request->get("phone")));
            
            $app['db']->update('user', array(
                'username' => $username,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'email' => $email,
                'tel' => $phone,
            ), array('id' => $id));
            return $app->redirect("membre");
        }

        public function selectMembres(Request $request, Application $app){
            $users = $app['db']->fetchAll('SELECT id, username, firstname, lastname, email, tel,statuts, created FROM user');           
            return $app["twig"]->render("pages/pageAdmin/listeMembre.html.twig", array("users" => $users));
        }

        public function selectMembre(Request $request, Application $app, $id){


            $sql = "SELECT id, username, firstname, lastname, email, tel,statuts, created FROM user WHERE id = ?";
            $user = $app['db']->fetchAll($sql, array((int)$id));

            if(empty($user))
                return $app->redirect("/");
                
            return $app["twig"]->render("pages/profil.html.twig", array(
                "id" => $id,
                "username" => $user[0]["username"],
                "firstname" => $user[0]["firstname"],
                "lastname" => $user[0]["lastname"],
                "email" => $user[0]["email"],
                "phone" => $user[0]["tel"],
                "statuts" => $user[0]["statuts"],
            ));
        }
        



        public function insertMembre(Request $request, Application $app){

            $username = strip_tags(trim($request->get("username")));
            $statut = strip_tags(trim($request->get("statut")));
            $prenom = strip_tags(trim($request->get("prenom")));
            $nom = strip_tags(trim($request->get("nom")));
            $email = strip_tags(trim($request->get("email")));
            $phone = strip_tags(trim($request->get("phone")));


            if(strlen($username) < 2 || strlen($nom) < 2 || strlen($prenom) < 2 || strlen($email) < 4 || strlen($phone) < 4 )
                return $app->redirect("ajoutMembre");

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // Verification de l'email
                return $app->redirect("ajoutMembre");

            $sql = "SELECT * FROM user WHERE email = ?";
            $user = $app['db']->fetchAssoc($sql, array((string)$email));
            if(!empty($user))
                return $app->redirect("ajoutMembre");


            $app['db']->insert('user', array(
                'username' => $username,
                'statuts' => $statut,
                'firstname' => $nom,
                'lastname' => $prenom,
                'email' => $email,
                'tel' => $phone,
                )
            );
            
            return $app->redirect("ajoutMembre");
        
        }

        
        public function pagination(){

            $nbProducts = getNbProductsFromDb();
            $maxPage = ceil($nbProducts / 20);

            // La fonction ceil() arrondit à l'entier supérieur.
            // Exemple : On a 352 produits en base de données. 352 / 20 par page = 17.6 pages, soit 18 pages.

            $page; // Le numéro de la page que nous souhaitons visualiser
            if (isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page']) && $page > 0 && $page <= $maxPage) // On vérifie si la page est bien un nombre compris entre 1 et $maxPage
            {
            $page = $_GET['page'];
            }
            else // Si le paramètre n'est pas spécifié ou n'est pas un nombre valide
            {
            $page = 1;
            }

            // Maintenant, nous avons le numéro de page. Nous pouvons en déduire les enregistrements à afficher :
            $offset = ($page - 1) * 10;   // Si on est à la page 1, (1-1)*10 = OFFSET 0, si on est à la page 2, (2-1)*10 = OFFSET 10, etc.

            $products = getProductsFromDb(10, $offset);

            // Affichage des produits
            foreach($products as $product) : ?>
            <article>
            <header><?php echo $product['name'] ?></header>
            <div>
            <?php echo $product['description'] ?>
            </div>
            </article>
            <?php endforeach;

            // Nous pouvons ajouter un message, qui permet à l'utilisateur de se situer dans la navigation :
            // $offset + 1 correspond à l'indice du premier article affiché
            // $offset + 11 correspond à l'indice du dernier article affiché
            // On souhaite afficher un message du genre "Articles 21 à 31 (sur 152)"
            ?>
            <p>
            Articles <?php echo ($offset + 1) ?> à <?php echo ($offset + 11) ?> (sur <?php echo $nbProducts ?>)
            </p>
            <?php

            if ($page > 1 ) // Seulement si on est sur la page 2 ou plus, afficher un bouton "Précédent"
            {
            echo '<a href="?page=<?php echo ($page - 1) ?>">Précédent </a>';
            }

            if ($page < $maxPage) // Seulement si on est pas sur la dernière page, afficher un bouton "Suivant"
            {
            echo '<a href="?page=<?php echo ($page + 1) ?>">Suivant</a>';
            }

            // On aurait pu afficher une suite de liens vers chacune des pages, en bouclant de 1 à $maxPage.
        }

    }