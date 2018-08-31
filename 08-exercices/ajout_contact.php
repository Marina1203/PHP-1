<?php
/* Sujet :

1-Creer une base de donnees "contacts" avec une table "contact" :
id_contact    PK AI INT(3)
nom           VARCHAR(20)
prenom        VARCHAR(20)
telephone     VARCHAR(20)
annee_rencontre  YEAR
email         VARCHAR(255)
type_contact  ENUM('ami', 'famille','professionnel', 'autre')  

2. Creer un formulaire en HTML (avec doctype) afin d'ajouter des conatcts dans le BDD.
Le champ année est un menu déroulant de l'année en cours à 100 ans en arrière à rebours, et le type de contact est aussi un menu deroulant

3.Sur le formulaire effectuer des controles nécessairtes :
    - las champs nom et prénom contiennent 2 caractères  minimum
    -le champ téléphone contient 10 chiffres
    -L'annéee doit être une année valide
    -Le type de contact doit etre conforme à la liste des contacts
    -L'email doit etre valide

    En cas d'rreur de saisie afficher les messages d'erreurr au-dessus du formulaire

    4. Ajoutez les contacts à la BDD et afficher un message en cas de succès ou en cas d'echec
    */

    $message ='';


  /*   $contenu ='';
    echo '<pre>';
    print_r($_POST);
    echo '</pre>'; */

    $pdo = new PDO('mysql:host=localhost;dbname=contacts',//driver mysql + serveur+nom de la BDD
                'root', //pseudo de la BDD
                '', // mot de passe de la BDD
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
                      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
                    );
                    

if (!empty($_POST)){
    if(!isset($_POST['nom']) || strlen($_POST['nom']) <2 || strlen($_POST['nom'])>
    20) $message .='<div>Le nom doit comporter entre 2 et 20 caractères </div>';
    //on verifie si l'indice "prenom" existe bien, si il n'existe pas on met un message à l
    //'internaute. On vérifie aussi sa longueur qui doit être comprise entre 2 et 20
    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) <2 || strlen($_POST['prenom'])>
    20) $message .='<div>Le nom doit comporter entre 2 et 20 caractères </div>';
    if(!isset($_POST['telephone']) || !ctype_digit($_POST['telephone']) ||strlen ($_POST['telephone']) !=10) $message .='<div>Le téléphone est incorrect </div>';
    if(!isset($_POST['annee_rencontre']) || !ctype_digit($_POST['annee_rencontre']) || $_POST['annee_rencontre'] <(date('Y')-100) || $_POST ['annee_rencontre'] > date('Y')) $message .='<div>L\'année n\'est pas valide </div>';
    if(!isset($_POST['type_contact']) || ($_POST['type_contact'] != 'ami') && ($_POST['type_contact'] != 'famille') && ($_POST['type_contact'] != 'professionnel') && ($_POST['type_contact'] != 'autre')) $message .='<div> Le type de contact est incorrect </div>';
    if(!isset($_POST['email']) || !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL)) $message .='<div>L\'email est incorrect</div>'; //fonctionne aves des url
    
    
    
    
    
    
         if(empty($message)){ 
    
            
            foreach($_POST as $indice => $valeur){
                $_POST[$indice]= htmlspecialchars($valeur,ENT_QUOTES);
            }
    
         $result = $pdo->prepare("INSERT INTO contact (nom, prenom,telephone,annee_rencontre,email,type_contact
         ) VALUES(:nom, :prenom,:telephone,:annee_rencontre,:email,:type_contact)");
         $result->bindParam(':nom',$_POST['nom']);
         $result->bindParam(':prenom',$_POST['prenom']);
         $result->bindParam(':telephone',$_POST['telephone']);
         $result->bindParam(':annee_rencontre',$_POST['annee_rencontre']);
         $result->bindParam(':email',$_POST['email']);
         $result->bindParam(':type_contact',$_POST['type_contact']); 
    
         
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
        <title>Ajout contact</title>
    </head>
    <body>
    <h1>Ajouter un contact</h1>
    

  <?php
echo $message;
  ?>



    <form method="POST" action="">
    

    <div>
        <label for="nom">Nom</label><br>
        <input type="text" id="nom" name="nom" value="">
    </div>


    
<div>
    
        <label>Prenom</label><br>
        <input type="text" id="prenom" name="prenom" value="">
</div>
   

    <div>
        <label for="telephone">Téléphone</label><br>
        <input type="text" id="telephone" name="telephone" value="">
    </div>
<div>
    
         <label for="annee_rencontre">Année_rencontre</label><br>
         <select name="annee_rencontre" id="annee_rencontre">
         <?php 
         for ($i = date('Y');$i>= date('Y')-100; $i--){
            echo "<option>$i</option>";
         }
      ?>
      </select>
</div>
  

   <div>
         <label for="email">Email</label><br>
        <input type="text" id="email" name="email" value="">
   </div>

   <div>
         <label for="type_contact">Type de contact</label><br>
        <select name="type_contact" id="type_contact">
            
        <option value="ami">ami</option>
        <option value="famille">famille</option>
        <option value="professionnel">professionnel</option>
        <option value="autre">autre</option>
        </select>
   </div>
    


    <div><input type="submit" name="submit" value="enregistrer"></div>
    </form>
        
    </body>
    </html>
    <?php
  
    





  

    

    
 
    