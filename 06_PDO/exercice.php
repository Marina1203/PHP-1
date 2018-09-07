<?php
echo'<h1>Les commerciaux et leur salaire</h1>';

//Exercice : 
//-afficher dans une liste <ul><li> le prenom, le nom et le salaire des employés, appartenant au service commercial (un <li> par commercial); 
//en utilisant une requâte préparé
//-afficher le nombre de commerciaux

function debug($param) {
    echo '<pre>';
    var_dump($param);
    echo '</pre>';
}



$pdo = new PDO('mysql:host=localhost;dbname=entreprise',
                'root', 
                '', 
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
                      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') 
                    );

      $service = 'commercial';         
                   
 $resultat = $pdo->prepare("SELECT prenom, nom, salaire FROM employes WHERE service =:service");
 $resultat->bindParam(':service',$service);

 $resultat->execute();

echo'<ul>';
 while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)){
   
   
    echo '<li>'.$donnees['prenom'].' '.$donnees['nom'].' '.$donnees[0]['salaire'].'</li>';
}
echo'</ul>';

    
  

   
 echo 'Nombre de commerciaux :'. $resultat->rowCount() .'<br>';
 echo '<hr>';
            echo '<br>';
            echo '<hr>';
            echo '<br>';


 //-----------------
 // Version table HTML

 $resultat->execute();
 
 echo '<table border="1">';

   
 echo '<tr>';

 echo '<th>prénom</th>';
 echo '<th>nom</th>';
 echo '<th>salaire</th>';
 echo '</tr>';
 while($donnees = $resultat->fetch(PDO::FETCH_ASSOC)){
   
   
    echo '<td>'.$donnees['prenom'].'</td>'.'<td>'.$donnees['nom'].'</td>'.'<td>'.$donnees['salaire'].'</td>';
}
 echo '</table>';







 















