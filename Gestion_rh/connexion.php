<?php
require_once 'inc/init.inc.php';


$pdo = new PDO('mysql:host=localhost;dbname=gestion_rh',//driver mysql + serveur+nom de la BDD
'root', //pseudo de la BDD
'', // mot de passe de la BDD
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
    );
/* 
         $contenu ='';
    echo '<pre>';
    print_r($contenu);
    echo '</pre>'; */ 




//-----------------
//2-Deconnexion de l'internaute:
if(isset($_GET['action'])&& $_GET['action'] == 'deconnexion'){ //si l'internaute a cliqué sur "deconnexion"
    session_destroy();//on supprime toute la session du membre. Rappel:cette instruction ne s'execute qu'en fin de script
}

//----------
//-3-On verifie si l'internaute est déjà connecté:
    if(internauteEstConnecte()){//si il est connecté, on le renvoi vers son profil :
        header('location:ajout_salarie.php');
        exit();//pour quitter le script

    }else{
        $contenu .='<div class="bg-danger">Veuillez vous connecter.</div>';
    }




/* debug($_POST); */

//1- TRAITEMENT DU FORMULAIRE:

if(!empty($_POST)){ //si le formulaire est soumis



// validation des champs
if(!isset($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $message .='<div>L\'email est incorrect</div>';
if (!isset($_POST['mdp']) || empty($_POST['mdp'])) $contenu .='<div 
class="bg-danger">Le mdp est requis</div>';
if(empty($contenu)){ //si il n'y a pas d'erreur dans le formulaire

    $membre = executeRequete("SELECT * FROM admin WHERE email = :email AND mdp = :mdp",
     array(':email' =>$_POST['email'],':mdp' =>$_POST['mdp']));//on sélectionne en base les éventuels membre dont le pseudo
    // correspond au pseudo donné par l'internaute lors de l'inscription

    if($membre->rowCount() > 0){ //si le nombre de ligne est superieur à 0, alors le login et le mdp existent ensemble en bdd

        //on crée une session avec les informations du membre:
            $information = $membre->fetch(PDO::FETCH_ASSOC);//on fait un fetch pour transformer l'objet $membre 
            //en un array associatif qui contient en indices le nom de tous les champs 
            debug($information);
            $_SESSION['admin'] = $information;//nous créons un session avec les infos du membre qui proviennent de la BDD

             header('location:ajout_salarie.php'); 
            exit(); //on redirige l'internaute vers sa page de profil, et on quite ce script avec la fonction exit()
 
    }else{
        //sinon c'est qu'il y a erreur sur les identifiants (ils n'existe pas ou pas pour le même membre)
        $contenu .='<div class="bg-danger">Erreurs sur les identifiants.</div>';
    }

}//fin du if(empty($contenu))


} //fin du if(!empty($_POST))

//-------------Affichage---------

require_once 'inc/haut.inc.php'; //doctype,header,nav
?>
<h1 class="mt-4">Connexion</h1>
<?php echo $contenu; ?>

<form action="" method="post">
<label for="email">Email</label><br>
<input type="text" name="email" id="email" value=""><br><br>
<label for="mdp">Mot de passe</label><br>
<input type="password" name="mdp" id="mdp" value=""><br><br>



<input type="submit" name="inscription" class="btn" value="se connecter"><br><br>


</form>
<?php
require_once 'inc/bas.inc.php'; //footer et fermeture des balises