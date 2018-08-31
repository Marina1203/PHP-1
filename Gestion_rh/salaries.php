Cahier des charges
1.Créer une base de données nommée gestion_rh
//CRUD salariés (nom, prenom, date_naissance, civilité, poste, service)
//CRUD services (nom salaries)
//CRUD projets (nom, service, date_debut,date_fin)
Une page admin qui permet d'ajouter des salariés 
Une page de connexion et inscription

<?php

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
    