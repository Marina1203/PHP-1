<?php
require_once 'inc/init.inc.php';





-//----------------------Affichage----------

require_once 'inc/haut.inc.php'; 


//1-redirection si l'internaute n'est pas connecté:
if(!internauteEstConnecte()){//si le membre n'est pas connecté, il ne 
    //doit pas avoir l'accs à la page profil
    header('location:ajout_salarie.php');//nous l'invitons à se connecter
    exit();

}

//2-Preparation du profil à afficher:
debug($_SESSION);
extract($_SESSION['admin']);//extrait tous les indices sous forme de variable auquelles on affecte la valeur dans l'array. Exemple:$_SESSION['membre']['pseudo']
//devient $pseudo=$_SESSION['membre']['pseudo'];

?>
<h1 class="mt-4">Profil</h1>
<h2>Bonjour  <strong><?php echo $prenom;  ?></strong></h2>

<?php  
if(internauteEstConnecteEtAdmin()) echo '<p>Vous êtes un administrateur</p>';
?>

<hr>
<h3>Voici vos informations du profil</h3>
<p>Votre email :<?php echo $email; ?></p>
<p>Votre email :<?php echo $adresse; ?></p>
<p>Votre email :<?php echo $code_postal; ?></p>
<p>Votre email :<?php echo $ville; ?></p>



<?php


require_once 'inc/bas.inc.php'; 