<?php
//--------------------
// La superglobal $_POST
//----------------------
//$_POST étant une superglobale, il s'agit d'un array, et il est disponible dans tout
// le context du script, y compris au sein des fonctions (sans faire "global $_POST")

//L'array $_POST se remplit de la manière suivante : les names du formulaire constituent
//les indices de $_POST et les données saisies dans le formulaire constituent les valeurs de $_POST

var_dump($_POST);
$message = "";
if(!empty($_POST)){ //si $_POST n'est pas vide, c'est qu'il est rempli par des données recues de l'internaute

    //dans un futur proche on vérifiera ici les données reçues avant de les traiter
    $message ='<p>Prenom:' . $_POST['prenom'] . '</p>';
    $message .='<p>Description:' . $_POST['description'] . '</p>';

}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Formulaire</title>
</head>
<body>
<h1>Formulaire</h1>
<?php echo $message; ?>
<form  method="POST" action=""> <!-- un formulaire est toujours dans des <form> pour fonctionner method = comment vont circuler les données du navigateur au serveur
(ici en post) action = url de destination de données -->
<div>
    <label for="prenom">Prénom</label>
    <input type="text" name="prenom" id="prenom" value=""> <!-- ne pas utiliser les name: ils constituent les indices 
    de l'array $_POST qui receptionne les données -->
</div>

<div>
    <label for="description">Description</label>
    <textarea name="description" id="description"></textarea>
</div>

<div><input type="submit" name="validation" value="envoyer"></div>
</form>
 <!-- Les id des labels ne sont pas indispensables : ils permettent de lier un label à son 
input grace au for de même nom.Ainsi si nous cliquons sur un label, le curseur se positionne dans son input -->
    
</body>
</html>