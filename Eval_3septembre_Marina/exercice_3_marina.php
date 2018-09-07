
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

$message ='';

/*   $contenu ='';
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';  */

  $pdo = new PDO('mysql:host=localhost;dbname=exercice_3',//driver mysql + serveur+nom de la BDD
              'root', //pseudo de la BDD
              '', // mot de passe de la BDD
              array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
                  );

            if (!empty($_POST)){
            if(!isset($_POST['title']) || strlen($_POST['title']) <5 || strlen($_POST['title'])>
            100) $message .='<div class="bg-danger">Le nom du film doit comporter entre 5 et 100 caractères </div>';
            //on verifie si l'indice "title" existe bien, si il n'existe pas on met un message à l
            //'internaute. On vérifie aussi sa longueur qui doit être comprise entre 5 et 100
            if(!isset($_POST['actors']) || strlen($_POST['actors']) <5 || strlen($_POST['actors'])>
            50) $message .='<div class="bg-danger">Le nom des acteurs doit comporter entre 5 et 50 caractères </div>';
            if(!isset($_POST['director']) || strlen($_POST['director']) <5 || strlen($_POST['director'])>
            50) $message .='<div class="bg-danger">Le nom du réalisateur doit comporter entre 5 et 50 caractères </div>';
            if(!isset($_POST['producer']) || strlen($_POST['producer']) <5 || strlen($_POST['producer'])>
            50) $message .='<div class="bg-danger">Le nom du producteur doit comporter entre 5 et 50 caractères </div>';
            if(!isset($_POST['year_of_prod']) || !ctype_digit($_POST['year_of_prod']) || $_POST['year_of_prod'] <(date('Y')-100) || $_POST ['year_of_prod'] > date('Y')) $message .='<div class="bg-danger">L\'année n\'est pas valide </div>';
            if(!isset($_POST['language']) || ($_POST['language'] != 'francais') && ($_POST['language'] != 'anglais') && ($_POST['language'] != 'espagnol') && ($_POST['language'] != 'italien') && ($_POST['language'] != 'autre')) $message .='<div class="bg-danger"> La langue est incorrect </div>';
            if(!isset($_POST['category']) || ($_POST['category'] != 'drame') && ($_POST['category'] != 'comedie') && ($_POST['category'] != 'horreur') && ($_POST['category'] != 'film_policier') && ($_POST['category'] != 'autre')) $message .='<div class="bg-danger"> La catégorie est incorrect </div>';
            if(!isset($_POST['storyline']) || strlen($_POST['storyline']) <5) $message .='<div class="bg-danger">Le nom du film doit comporter au minimum 5 caractères</div>';
            if(!isset($_POST['video']) || !filter_var($_POST['video'],FILTER_VALIDATE_URL)) $message .='<div class="bg-danger">L\'url de vidéo est incorrect</div>';
                    
                    
            if(empty($message)){ 
                    
                            
            foreach($_POST as $indice => $valeur){
                $_POST[$indice]= htmlspecialchars($valeur,ENT_QUOTES);
            }

            /*● title ​(varchar)​ : le nom du film ● actors ​(varchar)​ : les noms d’acteurs ● director ​(varchar)​ : le nom du réalisateur ● producer ​(varchar)​ : le nom du producteur ● year_of_prod ​(year)​ : l’année de production ● language ​(varchar)​ : la langue du film ● category ​(enum)​ : la catégorie du film ● storyline ​(text)​ : le synopsis du film ● video ​(varchar) ​: le lien de la bande annonce du film 
            N’oubliez pas de créer un ID pour chaque film et de l’auto-incrémenter. */
                    
            $result = $pdo->prepare("INSERT INTO movies (title,actors,director,producer,year_of_prod,language,category,
            storyline,video) VALUES(:title, :actors,:director,:producer,:year_of_prod,:language,:category,:storyline,:video)");
            $result->bindParam(':title',$_POST['title']);
            $result->bindParam(':actors',$_POST['actors']);
            $result->bindParam(':director',$_POST['director']);
            $result->bindParam(':producer',$_POST['producer']);
            $result->bindParam(':year_of_prod',$_POST['year_of_prod']);
            $result->bindParam(':language',$_POST['language']);
            $result->bindParam(':category',$_POST['category']); 
            $result->bindParam(':storyline',$_POST['storyline']); 
            $result->bindParam(':video',$_POST['video']); 
                    
                         
            $req = $result->execute(); 
                    
            if ($req) {
                             $message .= '<div>Le contact a bien été ajouté</div>';
            }else {
                             $message .= '<div>Une erreur est survenue lors de l\'enregistrement</div>';
            }
                    
        }  //fin de if (empty($message))
    } //fin de if (!empty($_POST)) 
                  



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajout de filmes</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">


<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>
<body>
<h1>Ajouter un film</h1>
<?php
echo $message;
?>
 
<form method="POST" action="">


<div>
    <label for="title">Titre</label><br>
    <input type="text" id="title" name="title" value=""><br><br>
</div>
<div>
    <label for="actors">Nom des acteurs</label><br>
    <input type="text" id="actors" name="actors" value=""><br><br>
</div>
<div>
    <label for="director">Nom du realisateur</label><br>
    <input type="text" id="director" name="director" value=""><br><br>
</div>
<div>
    <label for="producer">Nom du producteur</label><br>
    <input type="text" id="producer" name="producer" value=""><br><br>
</div>
<div>

     <label for="year_of_prod">Année de production</label><br>
     <select name="year_of_prod" id="year_of_prod"><br><br>
     <?php 
     for ($i = date('Y');$i>= date('Y')-100; $i--){
        echo "<option>$i</option>";
     }
  ?>
  </select><br><br>
</div>
<div>
    <label for="language">Langues</label><br>
    <select name="language" id="language">
        
        <option value="francais">FR</option>
        <option value="anglais">EN</option>
        <option value="espagnol">ES</option>
        <option value="italien">IT</option>
        <option value="autre">Autre</option>
        </select><br><br>
</div>
<div>
     <label for="category">Categorie</label><br>
    <select name="category" id="category">
        
    <option value="drame">Drame</option>
    <option value="comedie">Comedie</option>
    <option value="horreur">Film d'horreur</option>
    <option value="film_policier">Film policier</option>
    <option value="autre">autre</option>
    </select><br><br>
</div>

<div>
    <label for="storyline">Le synopsis</label><br>
    <textarea name="storyline" id="storyline" cols="30" rows="10"></textarea><br><br>
</div>
<div>
    <label for="video">Vidéo du film</label><br>
    <input type="video" id="video" name="video" value=""><br><br>
</div>
<div><input type="submit" name="submit" value="enregistrer"></div>
</form><br><br><br>

                  
</body>
</html>
 
    
 