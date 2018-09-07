
<?php
/*Exercice 3 : « Et si on regardait un film ? » 
 
Vous travaillez pour un cinéma et devez créer une base de données de film. Votre base de données s’appellera « exercice_3 ». Vous devrez ensuite créer un script qui permettra d’ajouter et d’afficher des films. Suivez les étapes. 
 
Étape 1 : 
Cette table, nommée “movies” sera composée des champs suivants : 
 ● title ​(varchar)​ : le nom du film ● actors ​(varchar)​ : les noms d’acteurs ● director ​(varchar)​ : le nom du réalisateur ● producer ​(varchar)​ : le nom du producteur ● year_of_prod ​(year)​ : l’année de production ● language ​(varchar)​ : la langue du film ● category ​(enum)​ : la catégorie du film ● storyline ​(text)​ : le synopsis du film ● video ​(varchar) ​: le lien de la bande annonce du film 
 N’oubliez pas de créer un ID pour chaque film et de l’auto-incrémenter. 
 
Étape 2 : 

Créer un formulaire permettant d’ajouter un film et effectuer les vérifications nécessaires. 
 
Prérequis : ● Les champs “titre, nom du réalisateur, acteurs, producteur et synopsis” comporteront au minimum 5 caractères. ● Les champs : année de production, langue, category, seront obligatoirement un menu déroulant ● Le lien de la bande annonce sera obligatoirement une URL valide ● En cas d’erreurs de saisie, des messages d’erreurs seront affichés en rouge 
 
Chaque film sera ajouté à la base de données créée. Un message de réussite confirmera l’ajout du film. 
Évaluation pratique PHP Temps imparti : 4h00 
Étape 3 : 
Créer une page listant dans un tableau HTML les films présents dans la base de données.  Ce tableau ne contiendra, par film, que le nom du film, le réalisateur et l’année de production. 
 Une colonne de ce tableau contiendra un lien ​« plus d’infos »  permettant de voir la fiche d’un film dans le détail. 
Étape 4 : 
Créer une page affichant le détail d’un film de manière dynamique. Si le film n’existe pas, une erreur sera affichée.   */

$pdo = new PDO('mysql:host=localhost;dbname=exercice_3',//driver mysql + serveur+nom de la BDD
'root', //pseudo de la BDD
'', // mot de passe de la BDD
array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
    );



    $contenu = '';
    $movies ='';
    

    $resultat = $pdo->query("SELECT id_movies, title, producer,year_of_prod FROM movies");

    $contenu .= '<table border="1">';


$contenu .= '<tr>';
$contenu .= '<th>title</th>';
$contenu .= '<th>producer</th>';
$contenu .= '<th>year_of_prod</th>';
$contenu .= '<th>autres_infos</th>';
$contenu .= '</tr>';

 
 while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
    $contenu .='<tr>';
   
    $contenu .= '<td>' . $ligne['title'].'</td>';
    $contenu .= '<td>' . $ligne['producer'].'</td>';
    $contenu .= '<td>' . $ligne['year_of_prod'].'</td>';

    $contenu .= '<td><a href="?id_movies='.$ligne['id_movies'].'">autres infos</a></td>';
      $contenu .='</tr>';
}
$contenu .='</table>';

/* var_dump($_GET); */
/* 
if(isset($_GET['id_movies'])) { 

    $_GET['id_movies'] = htmlspecialchars($_GET['id_movies'], ENT_QUOTES);

    $resultat = $pdo->prepare("SELECT * FROM movies WHERE id_movies = :id_movies");
    $resultat->bindParam(':id_movies',$_GET['id_movies']);
    $resultat->execute();

    $movies = $resultat->fetch(PDO::FETCH_ASSOC); 

 
 

    foreach($movies as $valeur){
        $contenu .= '<p>'.$valeur.'</p>';
    } 


} //fin de if(isset($_GET['id_movies'])) */

       

?>

         
         


 
    
 