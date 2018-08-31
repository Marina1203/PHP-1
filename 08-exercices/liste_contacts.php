<?php

/*
Sujet:
-Afficher dans une table HTML (avec doctype...) la liste des contacts avec les champs nom,prenom, et telephone et un champ supplémentaire "autres infos" qui 
est un lien qui permet d'afficher le détail de chaque contact

Afficher sous la table HTML, le détail du contact quand on clique sur son lien "autres infos".

*/

$pdo = new PDO('mysql:host=localhost;dbname=contacts',//driver mysql + serveur+nom de la BDD
'root', //pseudo de la BDD
'', // mot de passe de la BDD
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
    );

    $contenu = '';
    

    $resultat = $pdo->query("SELECT id_contact, nom, prenom, telephone FROM contact");

    $contenu .= '<table border="1">';


$contenu .= '<tr>';
$contenu .= '<th>nom</th>';
$contenu .= '<th>prenom</th>';
$contenu .= '<th>telephone</th>';
$contenu .= '<th>autres_infos</th>';
$contenu .= '</tr>';

 //Affichage des autre lignes :
 while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
    $contenu .='<tr>';
    //affichage des infos de chaque ligne $ligne:
    $contenu .= '<td>' . $ligne['nom'].'</td>';
    $contenu .= '<td>' . $ligne['prenom'].'</td>';
    $contenu .= '<td>' . $ligne['telephone'].'</td>';

    $contenu .= '<td><a href="?id_contact='.$ligne['id_contact'].'">autres infos</a></td>';
      $contenu .='</tr>';
}
$contenu .='</table>';

var_dump($_GET);

if(isset($_GET['id_contact'])) { //si existe l'indice 'id_contact' dans $_GET c'est que cet indice est
    // passé dans url, donc que l'internaute a cliqué sur un des liens 'autres infos'

    $_GET['id_contact'] = htmlspecialchars($_GET['id_contact'], ENT_QUOTES);//pour se prémunir des injections CSS ou JS via l'url

    $resultat = $pdo->prepare("SELECT * FROM contact WHERE id_contact = :id_contact");
    $resultat->bindParam(':id_contact',$_GET['id_contact']);
    $resultat->execute();

    $contact = $resultat->fetch(PDO::FETCH_ASSOC); // on transforme l'objet $resultat en un array associatif $contact. Pas de
    //boucle car on n'a qu'un seul résultat ici

 /*    print_r($contact);
 

    foreach($contact as $valeur){
        $contenu .= '<p>'.$valeur.'</p>';
    } */
if(!empty($contact)){
    //version sans boucle foreach :
        $contenu .='<p>Nom :'.$contact['nom'] .'</p>';
        $contenu .='<p>Prenom :'.$contact['prenom'] .'</p>';
        $contenu .='<p>Téléphone :'.$contact['telephone'] .'</p>';
        $contenu .='<p>Email :'.$contact['email'] .'</p>';
        $contenu .='<p>Annee de rencontre :'.$contact['annee_rencontre'] .'</p>';
        $contenu .='<p>Type de contact :'.$contact['type_contact'] .'</p>';
    }else{
        $contenu .= '<p>Ce contact n\'existe pas!</p>';
    }

} //fin de if(isset($_GET['id_contact']))

  


    

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Liste_contacts</title>
</head>
<body>
<h1>Liste de contacts</h1>
<?php echo $contenu ?>






    
    
</body>
</html>