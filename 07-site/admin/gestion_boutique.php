<?php
require_once '../inc/init.inc.php';


//1-On verifie si membre est admin:
    if(!internauteEstConnecteEtAdmin()){
        header('location:../connexion.php'); //si pas admin on le redirige vers la ,page de
        // connexion
        exit();
    }

    //Suppression d'un produit :
    debug($_GET);
    if(isset($_GET['id_produit'])){
        $resultat = executeRequete("DELETE FROM produit WHERE id_produit = :id_produit", array(':id_produit'=>$_GET['id_produit']));
        if($resultat->rowCount() == 1){//si j'ai une ligne dans$resultat, j'ai supprimé 1 produit
            $contenu.='<div class="bg-success">Le produit a bien été supprimé !</div>';

        }else{
            $contenu.='<div class="bg-danger">Erreur lors de la suppression du produit !</div>';
        }
    }


    //2-----Affichage des produits dans le back-office:
    //Exercice: affciher tous les produits sous forme de table HTML que vous stocker dans la variable $contenu.
    //Tous les champs doivent être affichés. Pour la photo, affichez une image (du 90px de côté)

    $resultat = $pdo->query("SELECT * FROM produit");


    $contenu .='<table border="1">';

    //La ligne d'entêtes :
     $contenu .='<tr>';
     $contenu .='<th>id_produit</th>';
     $contenu .='<th>reference</th>';
     $contenu .='<th>categorie</th>';
     $contenu .='<th>titre</th>';
     $contenu .='<th>description</th>';
     $contenu .='<th>couleur</th>';
     $contenu .='<th>taille</th>';
     $contenu .='<th>public</th>';
     $contenu .='<th>photo</th>';
     $contenu .='<th>prix</th>';
     $contenu .='<th>stock</th>';
     $contenu .='<th>action</th>';
    
     $contenu .='</tr>';

     //Affichage des autre lignes :
     while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
          $contenu .='<tr>';
    
     foreach($ligne as $indice=>$value){
         if($indice == 'photo'){
      $contenu .= '<td><img src="../'.$value.'" width ="90px" alt="'.$ligne['titre'].'"></td>';
    }else{
        $contenu .='<td>'.$value.'</td>';
    }
     }  //fin de foreach
     $contenu .='<td><a href="?id_produit='.$ligne['id_produit'] .'"onclick="return(confirm(\'Etes vous certains de vouloir supprimer ce produit,\'))">supprimer</a></td>';
     //$ligne['id_produit']contient l'id de chaque produit à chaque tour de boucle while :
        //ainsi le lien est dynamique, l'id passé en GET change selon le produit sur lequel je clique
            $contenu .='</tr>';
     }

     $contenu .='</table>';
  






//---------Affichage-----------

require_once '../inc/haut.inc.php'; 

?>
<h1 class="mt-4">Gestion boutique</h1>
<ul class="nav-tabs">
    <li><a class="nav-link active" href="gestion_boutique.php">Affichage des produits</a></li>
    <li><a class="nav-link" href="ajout_produit.php">Ajout d'un produit</a></li>
   
</ul>

<?php

echo $contenu;






require_once '../inc/bas.inc.php'; 