<?php
/* Sujet :

1- Créer une BDD "restaurants" avec une table "restaurant" :
id_restaurant  PK AI INT(3)
nom            VARCHAR(100)
adresse        VARCHAR(255)
telephone      VARCHAR(10)
type           ENUM ('gastronomique', 'pizzeria','brasserie','autre')
note           INT(1)
avis           TEXT

2 Créer un formulaire HTML (avec doctype...) afin d'ajouter un restaurant en bdd les champs type et note (de 1 à 5°) sont des menus deroulants

3 Effectuer les verifications
Le champ nom - 2 caracteres
Le champ adresse pas vide
Le telephone - 10 chiffre
Le type doit etre conforme à la lyste des types de la BDD
La note est un nombre entier antre 0 et 5
L'a vis pas vide
En cas d'essreur de asisi afficher un message au dessus du formulaire

4 Ajoutez un ou plusieurs restaurants à la BDD et affichez un message de succès ou d'echec lors de l'enregistrement
*/

  $message ='';
 /*  echo '<pre>';
  print_r($_POST);
  echo '</pre>'; */

  $pdo = new PDO('mysql:host=localhost;dbname=restaurants',//driver mysql + serveur+nom de la BDD
              'root', //pseudo de la BDD
              '', // mot de passe de la BDD
              array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
                  );


                  if (!empty($_POST)){
                    if(!isset($_POST['nom']) || strlen($_POST['nom']) <2 || strlen($_POST['nom'])>
                    20) $message .='<div>Le nom doit comporter entre 2 et 20 caractères </div>';
                    if(!isset($_POST['adresse'])|| strlen($_POST['avis']) <1) $message .='<div>Le champ adresse n\'est pas remplie </div>';
                    if(!isset($_POST['telephone']) || !ctype_digit($_POST['telephone']) ||strlen ($_POST['telephone']) !=10) $message .='<div>Le téléphone est incorrect </div>';
                    if(!isset($_POST['type']) || ($_POST['type'] != 'gastronomique') && ($_POST['type'] != 'pizzeria') && ($_POST['type'] != 'brasserie') && ($_POST['type'] != 'autre')) $message .='<div> Le type de contact est incorrect </div>';
                    if(!isset($_POST['note']) || !is_numeric($_POST['note'])) $message .='<div>La note doit 
                    être un nombre entier </div>';
                    if(!isset($_POST['avis'])|| strlen($_POST['avis']) <1 )  $message .='<div>Le champ avis n\'est pas remplie </div>';


                    if(empty($message)){ 
    
            
                        foreach($_POST as $indice => $valeur){
                            $_POST[$indice]= htmlspecialchars($valeur,ENT_QUOTES);
                        }
                
                     $result = $pdo->prepare("INSERT INTO restaurant (nom, adresse,telephone,type,note,avis
                     ) VALUES(:nom, :adresse,:telephone,:type,:note,:avis)");
                     $result->bindParam(':nom',$_POST['nom']);
                     $result->bindParam(':adresse',$_POST['adresse']);
                     $result->bindParam(':telephone',$_POST['telephone']);
                     $result->bindParam(':type',$_POST['type']);
                     $result->bindParam(':note',$_POST['note']);
                     $result->bindParam(':avis',$_POST['avis']); 
                
                     
                     $req = $result->execute(); 
                
                     if ($req) {
                         $message .= '<div>Le contact a bien été ajouté</div>';
                     }else {
                         $message .= '<div>Une erreur est survenue lors de l\'enregistrement</div>';
                     }
                    } /* fin de if (empty($message)) */
                  } //    if (!empty($_POST))
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
                  <h1>Ajouter un restaurant</h1>
                  
              
                <?php
              echo $message;
                ?>
              
              
              
                  <form method="POST" action="">
                  
              
                  <div>
                      <label for="nom">Nom</label><br>
                      <input type="text" id="nom" name="nom" value=""><br><br>
                  </div>
              
              
                  
              <div>
                  
              <label for="adresse">Adresse</label><br>
                    <textarea name="adresse" id="adresse" cols="15" rows="10"></textarea><br><br>
              </div>
                 
              
                  <div>
                      <label for="telephone">Téléphone</label><br>
                      <input type="text" id="telephone" name="telephone" value=""><br><br>
                  </div>
              
                 <div>
                       <label for="type">Type de restaurant</label>
                      <select name="type" id="type">
                          
                      <option value="gastronomique">gastronomique</option>
                      <option value="pizzeria">pizzeria</option>
                      <option value="brasserie">brasserie</option>
                      <option value="autre">autre</option>
                      </select><br><br>
                 </div>
                 <div>
                      <label for="note">Note</label>
                      <select name="note" id="note">   
                      <option value="0">0</option>
                      <option value="1">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      </select><br><br>
                      
                  </div>
                 <div>
                  
                      <label>Avis</label><br>
                    <textarea name="avis" id="avis" cols="15" rows="10"></textarea><br><br>
              </div>
                  
              
              
                  <div><input type="submit" name="submit" value="enregistrer"></div>
                  </form>
                      
                  </body>
                  </html>