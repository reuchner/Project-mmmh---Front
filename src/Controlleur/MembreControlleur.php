<?php

    namespace Webforce3\Controlleur;

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;
    use \DateTime;

    class MembreControlleur{

        public function selectMembre(Request $request, Application $app){
            $user = $app['db']->fetchAll('SELECT username,statut,prenom,nom,email,phone FROM user');
            // $username =  $user['username'];
            // $statut =  $user['statut'];
            // $prenom =  $user['prenom'];
            // $nom =  $user['nom'];
            // $email =  $user['email'];
            // $phone =  $user['phone'];
            return var_dump($user);
           
        }



        public function insertMembre(Request $request, Application $app){

            $username = strip_tags(trim($request->get("username")));
            $statut = strip_tags(trim($request->get("statut")));
            $prenom = strip_tags(trim($request->get("prenom")));
            $nom = strip_tags(trim($request->get("nom")));
            $email = strip_tags(trim($request->get("email")));
            $phone = strip_tags(trim($request->get("phone")));


            if(strlen($username) < 2 || strlen($nom) < 2 || strlen($prenom) < 2 || strlen($email) < 4 || strlen($phone) < 4 )
                return "1";

            if(!filter_var($email, FILTER_VALIDATE_EMAIL)) // Verification de l'email
                return "2";

            $sql = "SELECT * FROM user WHERE email = ?";
            $user = $app['db']->fetchAssoc($sql, array((string)$email));
            if($user != false)
                return "3";


            $app['db']->insert('user', array(
                'username' => $username,
                'statut' => $statut,
                'nom' => $nom,
                'prenom' => $prenom,
                'email' => $email,
                'phone' => $phone,
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