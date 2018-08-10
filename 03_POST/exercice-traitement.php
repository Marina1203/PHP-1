<?php
//--------------------
// La superglobal $_POST
//----------------------
//$_POST étant une superglobale, il s'agit d'un array, et il est disponible dans tout
// le context du script, y compris au sein des fonctions (sans faire "global $_POST")

//L'array $_POST se remplit de la manière suivante : les names du formulaire constituent
//les indices de $_POST et les données saisies dans le formulaire constituent les valeurs de $_POST
/* Créer un formulaire avec les champs ville et code postale, et une zone de texte adresse.
 - Vous envoyer les données saisies par l'internaute dans exercice-traitement.php
 -Vous y affichez ces saisies en précisant l'étiquette correspondante
 */

/* var_dump($_POST); */
$message = "";
if(!empty($_POST)){ //si $_POST n'est pas vide, c'est qu'il est rempli par des données recues de l'internaute on peut ommettre !empty if($_POST)

    //dans un futur proche on vérifiera ici les données reçues avant de les traiter
    $message ='<p>Ville: ' . $_POST['ville'] . '</p>';
    $message .='<p>Code postale: ' . $_POST['code_postale'] . '</p>';
    $message .='<p>Adresse: ' . $_POST['adresse'] . '</p>';
    
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Votre formulaire</title>
</head>
<body>
<h1>Vous avez indiqué :</h1>
<?php  echo $message;?>
    
</body>
</html>