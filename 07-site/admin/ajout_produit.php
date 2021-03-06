<?php
require_once '../inc/init.inc.php';


//1-On verifie si membre est admin:
    if(!internauteEstConnecteEtAdmin()){
        header('location:../connexion.php'); //si pas admin on le redirige vers la ,page de
        // connexion
        exit();
    }
  

    //4-Traitement du $_POST: enregistrement du produit en BDD 
    /* debug($_POST); */
    if(!empty($_POST)) {
        //ICI il faudrait mettre les controls sur les champs du formulaire.

        //ici le code $photo à venir
        $photo_bdd=''; // par défaut la photo est vide en BDD

        debug($_FILES);
if(!empty($_FILES['photo']['name'])){//si il y a un nom du fichier dans la 
    // superglobale $_FILES, c'est que je suis en train d'uploader un fichier. L'indice "photo" correspond au name du champ dans le formulaire

    $nom_photo = $_POST['reference'] .'_' .$_FILES['photo']['name'];//pour créer un nom du fichier unique, on concatène la 
    //réference du produit avec le nom du fichier en cours d'upload

    $photo_bdd = 'photo/' . $nom_photo; // chemin relatif de la photo enregistré dans la BDD correspondant
    // au fichier physique uploadé dans le dossier:photo: du site

    copy($_FILES['photo']['tmp_name'], '../' . $photo_bdd); //on enregistre le fichier photo qui est
    // temporairement dans ($_FILES['photo']['tmp_name'] dans le repertoire "../photo/nom_photo.jpg"

}
        //Insertion du produit en BDD:
        executeRequete("REPLACE INTO produit 
                        VALUES( :id_produit, :reference, :categorie, :titre, :description,
                                :couleur, :taille, :public, :photo_bdd, :prix, :stock)",
                                array(':id_produit' => $_POST['id_produit'],
                                 ':reference'  => $_POST['reference'],
                                 ':categorie' => $_POST['categorie'],
                                 ':titre'  => $_POST['titre'],
                                 ':description' => $_POST['description'],
                                 ':couleur' => $_POST['couleur'],
                                 ':taille'  => $_POST['taille'],
                                 ':public' => $_POST['public'],
                                 ':photo_bdd' => $photo_bdd, //attention variable,
                                 ':prix' => $_POST['prix'],
                                 ':stock'  => $_POST['stock'],
                                ));

        //REPLACE INTO se comporte comme un INSERT INTO quand l'id_produit n'existe pas en BDD :
        //c'est le cas lors de la création d'un produit pour lequel nous avons mis un id_produit à 0 par defaut dans le formulaire (voir
        //champ id_produit). REPLACE INTO se comporte comme un UPDATE 
        //quand l'id_produit existe dans la BDD; c'est le cas lors de la modification d'un produit existant.
        $contenu .='<div class="bg-success">Le produit a bien été enregistré !</div>' ;

    } //fin du if(!empty($_POST))

    



//---------Affichage-----------

require_once '../inc/haut.inc.php'; 

?>
<h1 class="mt-4">Gestion boutique</h1>
<ul class=" nav nav-tabs">
    <li><a class="nav-link" href="gestion_boutique.php">Affichage des produits</a></li>
    <li><a class="nav-link  active" href="ajout_produit.php">Ajout d'un produit</a></li>
   
</ul>

<?php

echo $contenu;

?>

 <!-- 3 -formulaire d'ajout de produit -- -->
<h2>Ajout d'un produit</h2>

<form method="post" action="" enctype="multipart/form-data">  <!-- -- multipart/form-data spécifie que le formulaire anvoie des données d'un fichier
 uploadé et du texte; permet d'uploader une photo pour le produit  -->
 <input type="hidden" id="id_produit" name="id_produit" value="0"> <!-- ce champ caché est utile pour la modification d'un
  produit afin de l'identifier dans la requete SQL.La valeur 0 par defaut signifie que le produit n'existe pas et
   qu'on est en trazin de le créer -->

   <label for="reference">Référence</label><br>
   <input type="text" id="reference" name="reference" value=""><br><br>

    <label for="categorie">Catégorie</label><br>
   <input type="text" id="categorie" name="categorie" value=""><br><br>

    <label for="titre">Titre</label><br>
   <input type="text" id="titre" name="titre" value=""><br><br>

   <label for="description">Description</label><br>
   <textarea id="description" name="description"></textarea><br><br>

      <label for="couleur">Couleur</label><br>
   <input type="text" id="couleur" name="couleur" value=""><br><br>

   <label for="taille">Taille</label><br>
   <select id="taille" name="taille">
    <option value="S">S</option>
    <option value="M">M</option>
    <option value="L">L</option>
    <option value="XL">XL</option>
    </select>

      <label>Public</label><br>
   <input type="radio" name="public" value="m" checked>Masculin
   <input type="radio" name="public" value="f">Féminin<br><br>

   <label for="photo">Photo</label>
   <input type="file" name="photo" id="photo"><br><br> <!-- le type file permet de uploader un fichier et de remplir la superglobale $_FILES.Ne pas
    oublier l'attribut enctype dans la balise <form> de ce formulaire -->

      <label for="prix">Prix</label><br>
   <input type="text" id="prix" name="prix" value="0"><br><br>

      <label for="stock">Stock</label><br>
   <input type="text" id="stock" name="stock" value="0">

    <input type="submit" class="btn" value="valider">



</form>


<?php

require_once '../inc/bas.inc.php'; 