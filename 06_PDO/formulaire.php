<?php
//Nous allons créer un formulaire pour enregistrer un nouvel employé dans la BDD "entreprise".

//Objectif : valider le formulaire et le sécuriser avant insertion en BDD

$message = ''; //pour afficher les messages à l'internaute

print_r($_POST);

    //2- Connexion à la BDD

    $pdo = new PDO('mysql:host=localhost;dbname=entreprise',//driver mysql + serveur+nom de la BDD
              'root', //pseudo de la BDD
              '', // mot de passe de la BDD
              array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
                  );

    // 3 -Traitement du formulaire :
        if (!empty($_POST)){// si $_POST est rempli c'est que le formulaire a été soumis
    //  Contrôles sur le formulaire :
    if(!isset($_POST['prenom']) || strlen($_POST['prenom']) <3 || strlen($_POST['prenom'])>
     20) $message .='<div>Le prenom doit comporter entre 3 et 20 caractères </div>';
//on verifie si l'indice "prenom" existe bien, si il n'existe pas on met un message à l
//'internaute. On vérifie aussi sa longueur qui doit être comprise entre 3 et 20
if(!isset($_POST['nom']) || strlen($_POST['nom']) <3 || strlen($_POST['nom'])>
     20) $message .='<div>Le nom doit comporter entre 3 et 20 caractères </div>';
     if(!isset($_POST['sexe']) || ($_POST['sexe'] != 'm' && $_POST['sexe'] != 'f')) $message .='<div>Le sexe n\'est pas correct </div>';
     if(!isset($_POST['service']) || strlen($_POST['service']) <3 || strlen($_POST['service'])>
     30) $message .='<div>Le service doit comporter entre 3 et 30 caractères </div>';
     if(!isset($_POST['salaire']) || !is_numeric($_POST['salaire'])) $message .='<div>Le salaire doit 
     être un nombre </div>';//is_numéric vérifie si la variable
     //est un nombre ou une chaine numérique

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
     if(!isset($_POST['date_embauche']) || !validateDate($_POST['date_embauche'],'Y-m-d')) $message .= '<div>
     La date n\'est pas valide </div>'; // On entre dans la condition si l'indice "date_embauche" n'existe pas OU que la fonction validateDate()
     //me retourne false (attention à la présence du "!")

     //Insertion en BDD si il n'y a pas de message d'erreur :
     if(empty($message)){ //si $message est vide c'est qu'il n'y a pas d'erreur

        //On échappe toutes les valeurs de $_POST
        foreach($_POST as $indice => $valeur){
            $_POST[$indice]= htmlspecialchars($valeur,ENT_QUOTES);
        }

        //On fait une requête préparée :
        $result = $pdo->prepare("INSERT INTO employes (prenom, nom,sexe,service,date_embauche,
        salaire) VALUES(:prenom, :nom,:sexe,:service,:date_embauche,:salaire)");
        $result->bindParam(':prenom',$_POST['prenom']);
        $result->bindParam(':nom',$_POST['nom']);
        $result->bindParam(':sexe',$_POST['sexe']);
        $result->bindParam(':service',$_POST['service']);
        $result->bindParam(':date_embauche',$_POST['date_embauche']);
        $result->bindParam(':salaire',$_POST['salaire']); 

       
           

        $req = $result->execute(); //la méthode execute() renvoie un boléen selon que la requète a marché (true) ou pas (false)

        //Afficher un message de réussite ou d'échec:

        if ($req) {
            $message .= '<div>L\'employé a bien été ajouté</div>';
        }else {
            $message .= '<div>Une erreur est survenue lors de l\'enregistrement</div>';
        }

     }//fin du if (empty($message))

        } //fin du if (!empty($_POST))


// 1- Création du formulaire :
    echo $message;
    ?>
    <form method="post" action="">
    <label for="prenom">Prénom</label><br>
    <input type="text" id="prenom" name="prenom" value=""><br><br>

    <label for="nom">Nom</label><br>
    <input type="text" id="nom" name="nom" value=""><br><br>

    <label>Sexe</label><br>
    <input type="radio" name="sexe" value="m" checked>Homme
    <input type="radio" name="sexe" value="f" checked>Femme<br><br>

    <label for="service">Service</label><br>
    <input type="text" id="service" name="service" value=""><br><br>

     <label for="date_embauche">Date d'embauche</label><br>
    <input type="text" id="date_embauche" name="date_embauche" placeholder="AAAA-MM-JJ" value=""><br><br>

     <label for="salaire">Salaire</label><br>
    <input type="text" id="salaire" name="salaire" value=""><br><br>

    <input type="submit" name="submit" value="enregistrer"><br><br>
    </form>

    <?php

