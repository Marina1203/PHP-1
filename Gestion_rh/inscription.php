<?php
require_once 'inc/init.inc.php';


$pdo = new PDO('mysql:host=localhost;dbname=gestion_rh',//driver mysql + serveur+nom de la BDD
'root', //pseudo de la BDD
'', // mot de passe de la BDD
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
    );

         $contenu ='';
    echo '<pre>';
    print_r($contenu);
    echo '</pre>'; 
   

$inscription = false; //pour savoir si l'internaute vient de s'inscrire (on mettra la variable à true) et 
//ne plus afficher le formulaire d'inscription

/* var_dump($_POST); */

//Traitement du formulaire:
    if(!empty($_POST)){ //si le formulaire est soumis

      // validation des champs
    if(!isset($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $message .='<div>L\'email est incorrect</div>';
    if (!isset($_POST['mdp']) || empty($_POST['mdp'])) $contenu .='<div 
    class="bg-danger">Le mdp est requis</div>';
    if(empty($contenu)){ //si il n'y a pas d'erreur dans le formulaire
        //---------------------
        //Si pas d'erreur sur le formulaire, on vérifie que le pseudo est disponible dans la BDD:
            if(empty($contenu)) { //si $contenu est vide, c'est qu'il n'y a pas d'erreur

                //Verification du pseudo:
            $membre = executeRequete("SELECT * FROM admin WHERE email = :email", array(':email' =>$_POST['email']));//on sélectionne en base les éventuels membre dont le pseudo
            // correspond au pseudo donné par l'internaute lors de l'inscription

            //code à suivre
            if($membre->rowCount()>0){//si la requête retourne 1 ou plusieurs résultats c'est que le pseudo existe en BDD
                $contenu .='<div class="bg-danger">L\'email n\'est pas valide.</div>';

            }

            $contenu .='<div class="bg-success">Vous êtes inscrit. <a href="connexion.php">Cliquez ici pour vous connecter.</a></div>';
            $inscription = true;//pour ne plus afficher le formulaire sur cette page
            } //fin du else

            }  /* fin de if(!empty($contenu)) */



    } /* fin de if(!empty($_POST)) */

//----------------AFFICHAGE------------
require_once 'inc/haut.inc.php'; //doctype,header,nav

echo $contenu; //pour afficher les messages à internaute
?>
<h1 class="mt-4">Inscription</h1>
<?php
if (!$inscription): //(!$inscription) équivaut à ($inscription == false),
    //c'est à dire que nous entrons dans la condition si $inscription vaut false //Syntaxe en if (condition) ...endif

?>
<p>Veuillez renseigner le formulaire</p>


<form action="" method="post">
<label for="email">Email</label><br>
<input type="text" name="email" id="email" value=""><br><br>
<label for="mdp">Mot de passe</label><br>
<input type="password" name="mdp" id="mdp" value=""><br><br>



<input type="submit" name="inscription" class="btn" value="s'inscrire"><br><br>


</form>

<?php

endif;







require_once 'inc/bas.inc.php'; //footer et fermeture des balises