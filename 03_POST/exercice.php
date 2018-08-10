<?php
//Exercice :

/* Créer un formulaire avec les champs ville et code postale, et une zone de texte adresse.
 - Vous envoyer les données saisies par l'internaute dans exercice-traitement.php
 -Vous y affichez ces saisies en précisant l'étiquette correspondante
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Exercice</title>
</head>
<body>
<h1>Formulaire</h1>

<form  method="POST" action="exercice-traitement.php"> 
<div>
    <label for="ville">Ville</label>
    <input type="text" name="ville" id="ville" value=""> 
</div>
<div>
    <label for="code_postale">Code postale</label>
    <input type="text" name="code_postale" id="code_postale" value=""> 
</div>

<div>
    <label for="adresse">Adresse</label>
    <textarea name="adresse" id="adresse"></textarea>
</div>

<div><input type="submit" name="validation" value="envoyer"></div>
</form>

    
</body>
</html>