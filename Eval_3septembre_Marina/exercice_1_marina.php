<?php
//Exercice 1 : « On se présente ! » 
 
//Créer un tableau en PHP contenant les infos suivantes :  ● Prénom ● Nom ● Adresse ● Code Postal ● Ville ● Email ● Téléphone ● Date de naissance au format anglais (YYYY-MM-DD) 
 
//A l’aide d’une boucle, afficher le contenu de ce tableau (clés + valeurs) dans une liste HTML. La date sera affichée au format français (DD/MM/YYYY). 
 
//Bonus :  Gérer l’affichage de la date de naissance à l’aide de la classe DateTime



echo '<h1> Exercice 1 </h1>';
$tab = array(
    'Prenom' => 'Marina',
    'Nom'=> 'Djalti',
    'Adresse' => '148 avenue Victor Hugo',
    'Code_postale'=> '75016',
    'Ville'=> 'Paris',
    'Email'=> 'marinadjalti@hotmail.com',
    'Telephone'=> '0615363113',
    'Date_naissance'=> '12/03/1980',
);


foreach($tab as $indice => $val){
    echo '<h3>'.$indice .':'.' '. $val. '</h3>';
}


