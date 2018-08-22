<?php
//-------------------------------
//Cas pratique : espace de commentaires
//-------------------------------------------

//Objectif : créer un formulaire pour poster des commentaires et le sécuriser
 //01
/*Créer une BDD : dialogue
  Table         : commentaire
  Champs        : id_commentaire INT(3) PK - AI
                : pseudo VARCHAR(20)
                 : message  TEXT
                 date_enregistrement DATETIME

*/
function debug($param) {
  echo '<pre>';
  var_dump($param);
  echo '</pre>';
}

//-----------------------------
//02 - Connexion à la BDD et traitement de $_POST
//------------------------------


$pdo = new PDO('mysql:host=localhost;dbname=dialogue',//driver mysql + serveur+nom de la BDD
              'root', //pseudo de la BDD
              '', // mot de passe de la BDD
              array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
                  );
/* print_r($_POST); */
if (!empty($_POST)){//signifie si le formulaire est remplie

  //Traitement contre les failles JS (XSS) ou les failles CSS :on parle d'echappement des données recues :
  //on commence par mettre du code CSS dans le champ "message": <style>body{display:none}</style>

  //Pour s'en prémunir :
  $_POST['pseudo'] = htmlspecialchars($_POST['pseudo'],ENT_QUOTES);// convertit les caractères spéciaux (<,>,'','') en entités HTML (exemple : le < devient &lt;)
  // ce qui permet de rendre inoffensives les balises HTML. On parle d'echappement des données reçues.
  $_POST['message'] = htmlspecialchars($_POST['message'],ENT_QUOTES);

  //Insertion du commentaire de l'internaute en BDD: nous allons faire une 
  //première requete qui n'est pas protegée contre les injections et qui n'accepte pas les apostrophes:
/*   $resultat=$pdo->query("INSERT INTO commentaire(pseudo,date_enregistrement,message)VALUES('$_POST[pseudo]', NOW(),'$_POST[message]'  )"); */

  //Nous faisons l'injection SQL suivante dans le champs "message" : 'ok');DELETE FROM commentaire;(

    //Pour se prémunir des injections SQL, nous faisons une requête préparée. 
    //Par ailleurs, elle permettra la saisie d'apostrophes par inrennautes

    $resultat = $pdo->prepare("INSERT INTO commentaire (pseudo, date_enregistrement, message) VALUES (:pseudo, NOW(), :message)");

    $resultat->bindParam(':pseudo',$_POST['pseudo']);
    $resultat->bindParam(':message',$_POST['message']);

    $resultat->execute();

    //Comment ça marche? Le fait de mettre des marqueurs dans la requête permet de ne pas concaténer les instructions SQL avec l'injection SQL.
    //Par ailleurs, en faisant un bindParam, les instructions SQL sont dissociés les unes des autres et neutralisées par PDO qui les transforme en string inoffensif.
    // En effet le SGBD attend les valeurs à la place des marqueurs, dont elle sait qu'elles ne ont pas du code à executer

}
?>

<!-- 1. Formulaire de saisie des messages -->
<h1>Votre messsage</h1>
<form method="post" action="">

<label for="pseudo">Pseudo</label><br>
<input type="text" id="pseudo" name="pseudo" value="<?php echo $_POST['pseudo'] ??'';?>"><br> <!-- l'operateur "??" en PHP7 signifie 
"prend le premier" ici on affiche  donc $_POST['pseudo'] s'il existe, sinon  -->

<label for="message">Message</label><br>
<textarea name="message" id="message"><?php echo $_POST['message'] ??'';?></textarea><br>

<input type="submit" name="envoi" value="envoyer"><br>



<?php
//------------
//Affichage des messages:
$resultat = $pdo->query("SELECT pseudo,message,DATE_FORMAT(date_enregistrement,'%d/%m/%Y')AS datefr, 
DATE_FORMAT(date_enregistrement, '%H:%i:%s') AS heurefr FROM commentaire ORDER BY date_enregistrement DESC");

echo '<h2>'.$resultat->rowCount() . 'commentaire</h2>';

while($commentaire = $resultat->fetch(PDO::FETCH_ASSOC)){
  var_dump($commentaire);

  echo '<p>Par'.' '.$commentaire['pseudo'] .' '. 'le' .$commentaire['datefr']. 'à'.$commentaire['heurefr'] . '</p>';
  echo '<p>'.$commentaire['message'] . '<p><hr>';
}


//Conclusion: faire systématiquement sur données reçues : 1 htmlspecialchars() et une requête préparé!!!


