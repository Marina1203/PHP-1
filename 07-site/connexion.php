<?php
require_once 'inc/init.inc.php';


//-----------------
//2-Deconnexion de l'internaute:
if(isset($_GET['action'])&& $_GET['action'] == 'deconnexion'){ //si l'internaute a cliqué sur "deconnexion"
    session_destroy();//on supprime toute la session du membre. Rappel:cette instruction ne s'execute qu'en fin de script
}

//----------
//-3-On verifie si l'internaute est déjà connecté:
    if(internauteEstConnecte()){//si il est connecté, on le renvoi vers son profil :
        header('location:profil.php');
        exit();//pour quitter le script

    }




/* debug($_POST); */

//1- TRAITEMENT DU FORMULAIRE:

if(!empty($_POST)){ //si le formulaire est soumis



// validation des champs
if (!isset($_POST['pseudo']) || empty($_POST['pseudo'])) $contenu .='<div 
class="bg-danger">Le pseudo est requis</div>';
if (!isset($_POST['mdp']) || empty($_POST['mdp'])) $contenu .='<div 
class="bg-danger">Le mdp est requis</div>';
if(empty($contenu)){ //si il n'y a pas d'erreur dans le formulaire

    $membre = executeRequete("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp = :mdp",
     array(':pseudo' =>$_POST['pseudo'],':mdp' =>$_POST['mdp']));//on sélectionne en base les éventuels membre dont le pseudo
    // correspond au pseudo donné par l'internaute lors de l'inscription

    if($membre->rowCount() > 0){ //si le nombre de ligne est superieur à 0, alors le login et le mdp existent ensemble en bdd

        //on crée une session avec les informations du membre:
            $information = $membre->fetch(PDO::FETCH_ASSOC);//on fait un fetch pour transformer l'objet $membre 
            //en un array associatif qui contient en indices le nom de tous les champs 
            debug($information);
            $_SESSION['membre'] = $information;//nous créons un session avec les infos du membre qui proviennent de la BDD

            header('location:profil.php');
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
<label for="pseudo">Pseudo</label><br>
<input type="text" name="pseudo" id="pseudo" value=""><br><br>
<label for="mdp">Mot de passe</label><br>
<input type="password" name="mdp" id="mdp" value=""><br><br>



<input type="submit" name="inscription" class="btn" value="se connecter"><br><br>


</form>
<?php
require_once 'inc/bas.inc.php'; //footer et fermeture des balises