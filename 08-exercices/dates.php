<?php
/* Sujet :
Creer une fonction qui permet de convertir une date fr en date us ou inversement
Cette fonction prend 2 paramètres  une date et le format de conversion "us" ou "fr"

-Vous validez que le paramètre format de sortie est bien "us" ou "fr"
Une fonction retourne un message si c'est pas le cas
*/

//Preambule de l'execice

$aujourdhui = date('d-m-y');//donne la date du jour au format indiqué
echo $aujourdhui.'<br>';

//-------------
//Convertir une date d'un format vers un autre:
    $date = '2018-08-24';
    echo'La date au format US: ' .$date.'<br>';

    $objetDate = new DateTime($date);
    echo 'La date au format FR:'.$objetDate->format('d-m-y'); //la methode format() permet de convertir un objet date selon le format indiqué

    echo '<hr>';

    //Votre exercice:
    function convertDate($date, $format){

        //vérifier la valeur du paramètre $format :
            if($format != 'US' && $format != 'FR'){
                return 'Erreur sur le format !';
            } //une fois les paramètres validés on fait le traitement :
        if($format == 'US'){
            $objetDate = new DateTime($date);
    return 'La date au format US:'.$objetDate->format('Y-m-d');
        }else {
            $objetDate = new DateTime($date);
            return 'La date au format FR:'.$objetDate->format('d-m-y');
        }
    }

    echo convertDate('15-03-1985', "US");
    echo '<br>';
    echo convertDate('1985-03-15', "FR");
    echo '<br>';
    echo convertDate('1985-03-15', "XX");
 
  


