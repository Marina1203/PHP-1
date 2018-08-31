<?php
require_once 'inc/init.inc.php';

//1-Affichage des catégories des vetements:

$resultat = executeRequete("SELECT DISTINCT categorie FROM produit"); //DISTINCT pour dedoublonner des
//catégories existantes. $resultat est un objet PDOStatement

$contenu_gauche .='<div class="list-group">';

//Affichage de la categorie "tous":

$contenu_gauche .= '<a href="?categorie=tous" class="list-group-item">Tous</a>';

//Affichage des autres catégories (provenant de la BDD)

while($cat = $resultat->fetch(PDO::FETCH_ASSOC)){
    /* debug($cat); */ //on voit que les categories sont dans cet array $cat à l'indice "categorie"
    $contenu_gauche .= '<a href="?categorie='.$cat['categorie'] .'" class="list-group-item">'.$cat['categorie'].'</a>';
    //on met l'array $cat['categorie'] a la place de 'tous' pour recuperer à chaque tour de boucle chacune des categories presentent dans cet array (
        //voir le debug ci-dessus)
}

$contenu_gauche .='</div>';

//---Affichage des produits selon la catégorie choisie:
if(isset($_GET['categorie']) && ($_GET['categorie']) !='tous'){
    // si existe 'categorie' dans$_GET (donc dans l'url), c'est qu'on a cliqué sur categorie en
    
    // particulier(robe,pull...).On selectionne tous les produits de cette categorie:
    $donnees = executeRequete("SELECT * FROM produit WHERE categorie=:categorie",array(':categorie'=>$_GET['categorie']));
}else{
//dans le cas contraire on affiche TOUS les produits:
$donnees = executeRequete("SELECT * FROM produit");
}
while ($produit = $donnees->fetch(PDO:: FETCH_ASSOC)){
   /*  debug($produit); */ //on a 1 array avec un seul produit à l'interieur à chaque tour de boucle
    //ici on met tout le HTML de presentation du produit:
    $contenu_droite .= '<div class="col-sm-4 mb-4">';
    $contenu_droite .= '<div class="card">';

    //Image cliquable du produit:
    $contenu_droite .= '<a href="fiche_produit.php?id_produit='.$produit['id_produit'].'"><img class="card-img-top" 
    src="' .$produit['photo'].'" alt="'.$produit['titre'].'">
    
    






    </a>';
    
    //Les infos du produit :
    $contenu_droite.= '<div class="card-body">';
    $contenu_droite .='<h4>' .$produit['titre'] . '</h4>';
    $contenu_droite .='<h5>' .$produit['prix'] . '€</h5>';
    $contenu_droite .='<p>' .$produit['description'] . '</p>';
    $contenu_droite .='</div>'; //card body


    $contenu_droite .='</div>'; //card
    $contenu_droite .='</div>';//col sm

}



//-----Affichage-------

require_once 'inc/haut.inc.php'; 

?>
<h1 class="mt-4">Vetements</h1>

<div class="row">
<div class="col-md-3">
<?php echo $contenu_gauche;?>
</div> <!-- fin de col3 -->

<div class="col-md-9">
<?php echo $contenu_droite;?>



</div> <!-- fin de col9 -->
</div> <!-- fin de row -->






<?php

require_once 'inc/bas.inc.php';