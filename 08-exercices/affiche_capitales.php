<?php

/*Sujet:
Vous créez un tableau PHP contenant les pays suivants:
-France
-Italie
-Espagne
-Inconnu
-Allemagne

Vous leur associez les valeurs suivantes :
-Paris
-Rome
-Madrid
-'?'
-Berlin

Vous parcourez ce tableau pour afficher la phrase "La capitale X se situe en Y" dans un 
<p>, X - la capitale, Y - le pays

Pour le pays inconnu vous afiichez La capitale de inconnu n'existe pas! a la place de la phrase precedante
*/


/* $pays = '';
$capitale = ''; */
$contenu=array("france"=>"paris","italie"=>"rome","espagne"=>"madrid","inconnu"=>"?","allemagne"=>"berlin");

foreach($pays as $indice=>$valeur){
    if($indice == 'inconnu') {
        echo'<p>La capitale de inconnu n\'existe pas !</p>';
    }else{
        echo '<p>La capitale' . $valeur . 'se situe en '.$pays.'</p>';

}






