<?php

//-------------------------------
//La superglobale $_SESSION
//-----------------------

/*
Un fichier temporaire appelé "session" est crée sur le serveur avec un identifiant unique.
Cette session est liée à un seul internaute car dans le même temps , un 
cookie est déposé sur le poste de l'internaute avec l'indentifiant. Ce cookie se détruit lorsqu'on
quitte le navigateur.

Le fichier session peut contenir toutes sortes d'informations, y compris sensibles, car il n'est pas accessible par l'internaute, donc pas modifiable.
On y stocks par exemple des données de login, ou les infos de panier d'achat.

Tous les sites qui fonctionnent sur le principe de connexion (votre site bancaire) ou
 ceux qui ont besoin de suivre un internaute
de page en page (par exemple conserver son panier) utilisent les sessions.

Les données stockés dans une session sont accesible et modifiables à partir de la superglobale $_SESSION.


*/

//Création d'une nouvelle session ou ouverture d'une session existante:
session_start(); // permet de créer un fichie de session OU de l'ouvrir si elle existe déjà
//session_start() s'occupe aussi de la gestion des cookies relatifs aux sessions.

//Remplir une session :
$_SESSION['pseudo'] = 'JohnDoe';
$_SESSION['mdp'] = '123456'; //la superglobale $_SESSION étant un array, on accède à ses informations
// comme dans n'importe quel tableau en utilisant des []

echo '1-La session après remplissage :';
var_dump($_SESSION);

//on peut visualiser le contenu de la session physique dans <xampp>/tmp

//Vider une partie de la session
unset($_SESSION['mdp']); //unset() permet de vider une partie de la session ici supprime le mdp;
echo'<br> 2 -La session après la suppression de mdp <br>';
var_dump($_SESSION);

// Supprimer entièrement une session

/* session_destroy(); */

echo '<br> 3 - La session après suppression :<br>';
var_dump($_SESSION); //nous voyons encore le contenu de la session ici, En effet
//il faut savoir que session_destroy() est d'abord lu par l'interpreteur, puis exécuter réellement qu'à la toute fin du script : pour le voir
//  il faut vérifier le dossier xampp/tmp la session n'existe plus

//Les sessions ont l'avantage d'etre disponible partout sur le site, et donc dans tous les scripts (voir session2.php)