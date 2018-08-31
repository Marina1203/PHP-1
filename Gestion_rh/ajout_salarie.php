<?php
require_once 'inc/init.inc.php';


/*Cahier des charges
1.Créer une base de données nommée gestion_rh
//CRUD admin 
//CRUD salariés (nom, prenom, date_naissance, civilité, poste, service)
//CRUD services (nom salaries)
//CRUD projets (nom, service, date_debut,date_fin)
Une page admin qui permet d'ajouter des salariés 
Une page de connexion et inscription*/





$pdo = new PDO('mysql:host=localhost;dbname=gestion_rh',//driver mysql + serveur+nom de la BDD
'root', //pseudo de la BDD
'', // mot de passe de la BDD
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
    );

         $contenu ='';
         $message ='';
    /* echo '<pre>';
    print_r($_POST);
    echo '</pre>';  */
    require_once 'inc/haut.inc.php';

   
    
                    

if (!empty($_POST)){
    if(!isset($_POST['nom']) || strlen($_POST['nom']) <2 || strlen($_POST['nom'])>
    20) $message .='<div>Le nom doit comporter entre 2 et 20 caractères </div>';
    //on verifie si l'indice "prenom" existe bien, si il n'existe pas on met un message à l
    //'internaute. On vérifie aussi sa longueur qui doit être comprise entre 2 et 20
    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) <2 || strlen($_POST['prenom'])>
    20) $message .='<div>Le nom doit comporter entre 2 et 20 caractères </div>';
    if(!isset($_POST['civilite']) || ($_POST['civilite'] != 'h' && $_POST['civilite'] !='f')) $contenu .='<div>La civilité est incorrecte !</div>';
    if(!isset($_POST['poste']) || strlen($_POST['poste']) <2 || strlen($_POST['poste'])>
    20) $message .='<div>Le nom de poste doit comporter entre 2 et 20 caractères </div>';
    if(!isset($_POST['id_service']) || ($_POST['id_service'] != 'direction') && ($_POST['id_service'] != 'comptabilite') && ($_POST['id_service'] != 'restaurant') && ($_POST['id_service'] != 'export')) $message .='<div> Le type de service est incorrect </div>';
     //Validation de la date :
     function validateDate($date, $format='d-m-y'){ //$format = 'd-m-y' permet de donner une valeur par défaut au paramètre $format si on ne lui passe
        //pas d'argument lors de l'appel de la fonction

      $d = DateTime::createFromFormat($format,$date); //crée un objet date si la date est valide et qu'elle correspond au format indiqué dans $format.
      //Dans le cas contraire, retourne false ( c'est à dire si la date n'est pas valide ou elle ne correspond au format indiqué)

      if($d && $d->format($format)==$date) { //si $d n'est pas false (voir ci-dessus) et que l'objet date $d est bien égal à la date $date, c'est qu'il n'y a pas
        // eu d'extrapolation sur la date exemple le 32/01/2015 devient 01/02/2015.Dans ce cas la date est validé on retourne : true
          return true;
      }else{
          return false;
      }

     }
     if(!isset($_POST['date_naissance'])) /* || !validateDate($_POST['date_naissance'],'Y-m-d')) */ $message .= '<div>
     La date de naissance n\'est pas valide </div>';
  
    
    
    
  
    
    
         if(empty($message)){ 
    
            
            foreach($_POST as $indice => $valeur){
                $_POST[$indice]= htmlspecialchars($valeur,ENT_QUOTES);
            }
    
         $result = $pdo->prepare("INSERT INTO salaries (nom, prenom,date_naissance,civilite,poste,id_service
         ) VALUES(:nom, :prenom,:date_naissance,:civilite,:poste,:id_service)");
         $result->bindParam(':nom',$_POST['nom']);
         $result->bindParam(':prenom',$_POST['prenom']);
         $result->bindParam(':date_naissance',$_POST['date_naissance']);
         $result->bindParam(':civilite',$_POST['civilite']);
         $result->bindParam(':poste',$_POST['poste']);
         $result->bindParam(':id_service',$_POST['id_service']); 
    
         
         $req = $result->execute(); 
    
         if ($req) {
             $message .= '<div>Le contact a bien été ajouté</div>';
         }else {
             $message .= '<div>Une erreur est survenue lors de l\'enregistrement</div>';
         }
    
      } /* fin de if (empty($message)) */
    }/* fin de if (!empty($_POST)) */
    
  
    
    ?>

    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Ajout salariés</title>
    </head>
    <body>
    <h1>Ajouter un salarié</h1>
    

  <?php
echo $message;
  ?>



    <form method="POST" action="">
    

    <div>
        <label for="nom">Nom</label><br>
        <input type="text" id="nom" name="nom" value=""><br><br>
    </div>


    
<div>
    
        <label>Prenom</label><br>
        <input type="text" id="prenom" name="prenom" value=""><br><br>
</div>
<div>
<label for="date_naissance">Date de naissance</label><br>
    <input type="text" id="date_naissance" name="date_naissance" placeholder="AAAA-MM-JJ" value=""><br><br></div>
   

<div> 
<label>Civilite</label><br>
    <input type="radio" name="civilite" value="h" checked>Monsieur
    <input type="radio" name="civilite" value="f" >Madame<br><br>
</div>
  
<div>
    
        <label>Poste</label><br>
        <input type="text" id="poste" name="poste" value=""><br><br>
</div><div>
    
    <label>Service</label><br>
    <select>
    <?php 
     $result = $pdo->query("SELECT DISTINCT nom FROM services");
   
     while($ligne = $result->fetch(PDO::FETCH_ASSOC)){
    
    foreach($ligne as $info){
    echo '<option value="'.$info.'">'.$info.'</option>';
    }
        
    }
      ?></select><br><br>
</div>
   
    


    <div><input type="submit" name="submit" value="enregistrer"></div>
    </form>
        
    </body>
    </html>

    <?php
    require_once 'inc/bas.inc.php';
  
    





  

    

    
 
    