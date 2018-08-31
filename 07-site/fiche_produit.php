<?php
require_once 'inc/init.inc.php';

//variable d'affichage :
$panier ='';
$suggestion ='';

//1- On verifie que le produit demandé existe bien : ( un produit en favori a pu être supprimé de la bdd...):
    if(isset($_GET['id_produit'])) { // si existe "id_produit dans $_GET (donc dans l'url), c'est qu'un produit a été demandé

        $resultat = executeRequete("SELECT * FROM produit WHERE id_produit = :id_produit",array(':id_produit'=> $_GET['id_produit']));// on séléctionne le 
        //produit demandé dans l'url par son id
        if($resultat->rowCount() == 0){//si'il n'y a pas de ligne dans $resultat, le produit demandé n'est pas en BDD : on redirige vers la boutique
            header('location:boutique.php');
            exit();
        }

        //Si on passe ici, le produit existe en BDD:
        $produit = $resultat->fetch(PDO::FETCH_ASSOC);// on transforme l'objet $resultat en un 
        //array associatif $produit, sans boucle while car on est certain de n'avoir qu'un seul produit
        /* debug($produit); */
        extract($produit);//on extrait tous les indices sous forme de variables. Exemple
        // $produit['titre] devient un variable $titre dont la valeur $produit['titre']
    }else{
        //on redirige l'internaute vers la boutique car aucun produit n'a été s"lectionné :
        header('location:boutique.php');
    }





//--Affichage-------------
?>

<div class="row">
<div class="col-lg-12">
<h1><?php echo $titre; ?></h1>
</div>
<div class="col-md-8">
<img class="img-fluid" src="<?php echo $photo;?>" alt="<?php echo $titre; ?>">
</div>
<div class="col-md-4">
<h3>Description</h3>
<p><?php echo $description; ?></p>
<h3>Détails</h3>
<ul>
<li>Catégorie : <?php echo $categorie; ?></li>
<li>Couleur : <?php echo $couleur; ?></li>
<li>Taille : <?php echo $taille; ?></li>
</ul>
<h4>Prix:  <?php echo $prix; ?>€</h4>
<?php echo $panier;?>

<a href="boutique.php?categorie=<?php echo $categorie; ?>">Retour vers votre selection</a>


</div> <!-- col md-4 -->

</div> <!-- row -->

<?php


require_once 'inc/haut.inc.php'; 

require_once 'inc/bas.inc.php';