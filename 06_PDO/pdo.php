<?php

//----------------------
//      PDO
//------------------

//PDO pour PHP - DATA -OBJECTS est une extension de PHP qui définit une interface pour accéder
//à une base de données depuis PHP (via du SQL).

function debug($param) {
    echo '<pre>';
    var_dump($param);
    echo '</pre>';
}

//-----------------------------
//01 - Connexion à la BDD
//------------------------------

echo '<h3> 01 - Connexion à la BDD</h3>';
$pdo = new PDO('mysql:host=localhost;dbname=entreprise',//driver mysql + serveur+nom de la BDD
                'root', //pseudo de la BDD
                '', // mot de passe de la BDD
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, // option 1 : pour afficher les erreurs SQL
                      PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8') // option 2 : définit le jeu de caractères des echanges avec la BDD
                    );

    //$pdo est un objet issu de la classe prédifinie PDO. Il represente la connexion à la BDD

    //-----------------------------
    //02 - exec() avec INSERT, DELETE, et UPDATE
    //---------------      
    echo '<h3> 02 - exec() avec INSERT, DELETE, et UPDATE</h3>'; 

    //Notre première requête SQL :

    $resultat = $pdo->exec("INSERT INTO employes(prenom,nom,sexe,service,date_embauche,salaire)
                             VALUES('test','test','m','test','2016-02-08',500)");

    // exec() est utilisée pour la formulation de requête ne retournant pas de jeu de resultatas :
        //INSERT, DELETE,UPDATE

    /*Valeur de retour (dans $resultat):
    -en cas de succès : 1 ou plus qui correspond au nombre de lignes crées par la requête
    en cas d'eshec : false
    */

    echo "Nombre d'enregistrements affectés par l'INSERT : $resultat <br>";
    echo 'Dernier id généré après la requête :'. $pdo->lastInsertId(); //méthode qui
    //permet de recuperer depuis le BDD le dernier id inséré par la requête précédente

    $resultat =$pdo->exec("DELETE FROM employes WHERE prenom='test'");
    echo '<br> Nombre d\enregistrements affectés par le DELETE :'. $resultat.'<br>';

    //-----------------------------
    //03 - query() avec SELECT et fetch() avec un seul résultat
    //--------------------------  

    echo '<h3>03 - query() avec SELECT et fetch() avec un seul résultat</h3>';

    $result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");

    //Au contraire de exec(), query() est utilisé pour les requêtes
    // qui retournent un ou plusieurs résultats provenant de la BDD:SELECT.
    //NOtez que query peut etere utiliser avec INSERT, UPDATE, ou DELETE.

    /* Valeurs de retours :
    - en cas de succès : nouvel objet issu de la classe prédéfinie PDOStatement
    - en ces d'échec : false
    */
   /*  debug($result); */

    //$result est le resultat de la requête sous une forme inexploitable 
    //directement: il faut donc le transformer avec la méthode fetch():
        $employe = $result->fetch(PDO::FETCH_ASSOC); //la méthode fetch() avec son paramètre 
        //PDO:: FETCH_ASSOC permet de transformer l'objet $result en un ARRAY ASSOCIATIF
        //exploitable (ici $employe) indexé avec le nom des champs de la table
        debug($employe); /* pour voir l'array associatif */


        echo 'Je suis ' . $employe['prenom'] . ' ' . $employe['nom'] . ' du service'.' '. $employe['service'].'<br>';

        /*
        1- Connexiont à la BDD
        2- Requête de sQL
        3- Fetch
        4- echo
        */ 

        //-------------------------
        // Les trois autres méthodes de fetch():

        $result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
        $employe = $result->fetch(PDO::FETCH_NUM); //transforme $result en un array  indexé numériquement
       
        debug($employe);
        echo $employe[1].'<br>'; //Daniel

//----------------------

        $result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
        $employe = $result->fetch(); //sans paramètres fetch mélange array associatif et array numérique
        debug($employe);
        echo $employe['prenom'].'<br>'; //Daniel
        echo $employe[1].'<br>'; //Daniel

        //----------------------
        $result = $pdo->query("SELECT * FROM employes WHERE prenom = 'daniel'");
        $employe = $result->fetch(PDO::FETCH_OBJ);//transforme en un objet avec 
        //les noms des champs de la table comme propriétés de cet objet
        debug($employe);
       /*  echo $employe->prenom.'<br>'; //Daniel */

        //Attention : après une requête il faut choisir l'un des fetch(). Si l'on veut de refaire un, il 
        //faut refaire la requête : en effet on ne peut pas effectuer plusieurs transformation
        //successives sur le même objet $result

        //--------------
        //Exercice : afficher le service de l'employé dont l'id_employe est 417(production)
        
        $result = $pdo->query("SELECT * FROM employes WHERE id_employes = '417'");
        $employe = $result ->fetch();
        debug($employe);
        echo $employe['service'].'<br';
        echo' <br>';
        echo' <br>';
        
        // OU
        $result = $pdo->query("SELECT * FROM employes WHERE id_employes = '417'");
        $employe = $result ->fetch(PDO::FETCH_OBJ);
        debug($employe);
        echo $employe->service.'<br';
        echo' <br>';
        echo' <br>';
        

        //OU
        $result = $pdo->query("SELECT * FROM employes WHERE id_employes = '417'");
        $employe = $result ->fetch(PDO::FETCH_NUM);
        debug($employe);
        echo $employe['4'].'<br';
        echo' <br>';
        echo' <br>';

        //OU
        $result = $pdo->query("SELECT service FROM employes WHERE id_employes = '417'");
        $employe = $result ->fetch(PDO::FETCH_ASSOC); //on transforme l'objet $result (qui n'est pas exploitable directement)
        //en un array associatif avec pour indice le nom di champ du SELECT (ici service)
        debug($employe);//on voit ici le contenu de l'array associatif
        echo $employe['service'].'<br>';

        //Si la requête retourne qu'un seul résultat => pas de boucle. Si elle peut potentiellement retourner plusieurs resultat => boucle
        
        echo' <br>';
        echo' <br>';

        //-----------------------------
      //04 - fetch() avec boucle WHILE ( plusieurs résultats)
       //--------------------------  

       echo '<h3> 04-fetch() avec boucle while (plusieurs résultats) </h3>';
       $resultat = $pdo->query("SELECT * FROM employes"); //cette requete retourne plusieurs résultats,
       //on fait dons une boucle pour les parcourir

       echo 'Nombre d\' employés :'. $resultat->rowCount() .'<br>'; //permet de compter le nombre des lignes retournées par le
       // SELECT (exemple: nombre de produits selectionnés dans une boutique)
        
       //Comme nous avons plusieurs lignes de résultats, nous devons faire une boucle while :

        while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) { //fetch retourne la ligne SUIVANTE du jeu de résultats en un array associatif.
            //La boucle while permet de faire avancer le curseur dans le jeu de resultatr et s'arrête
            // quand le curseur est arrivé à la fin
            //debug($employe); //$employe est un array associatif qui contient les données d'un seul employé à chaque tour du boucle

            echo '<div>';
            echo $employe['prenom']. '<br>';
            echo $employe['nom']. '<br>';
            echo $employe['service']. '<br>';

            echo '----------</div>';

        }

        //Attention : il n'y a pas UN array avec tous les enregistrements dedans, mais un 
        //array par enregistrement, un array par employé !



         //-----------------------------
         //05 - Exercice
         //--------------------------  

       echo '<h3> Exercice </h3>';
       //Afficher la liste des diférentes services dans une liste <ul><li>.
       $resultat = $pdo->query("SELECT DISTINCT service FROM employes"); //fonctionne aussi ici avec GROUP BY,
       //mais ce dernier est plutot utilisé avec les fonctions d'agrégats comme SUM(), COUNT(),MIN(), MAX() et AVG()

       echo '<ul>';
       while ($employe = $resultat->fetch(PDO::FETCH_ASSOC)) {
        echo '<li>'.$employe['service']. '</li>';
       }
       echo '</ul>';

         //-----------------------------
         //06 - fetchAll()
         //--------------------------  

         echo '<h3> 06 - fetchAll </h3>';

         $resultat = $pdo->query("SELECT * FROM employes");
         debug($resultat);

         $donnees = $resultat->fetchAll(PDO::FETCH_ASSOC);// retourne TOUTES les lignes de résultats dans un tableau multidimensionnel(sans faire de boucle):
         //nous avons 1 array associatif par employé à chaque indice numérique

         debug($donnees); //array multidimensionnel

         //Pour afficher son contenu, on fait une boucle foreach:
            foreach($donnees as $employe){
         debug($employe); //$employe correspond aux sous arrays qui représente 1 employé
         //à chaque tour de boucle

         echo"<div>
            <p>$employe[prenom]</p>
            <p>$employe[nom]</p>
            <p>$employe[salaire]
              </div><hr>";
            }
            //Si nous avions voulu afficher TOUTES les infos de façon
            // dynamique, nous aurions fait 2 foreach imbriquées l'une dans l'autre

            echo '<hr>';
            echo '<br>';
            echo '<hr>';
            echo '<br>';

              //-----------------------------
         //07 - Table HTML
         //-------------------------- 
         
         echo '<h3> 07 - Table HTML </h3>';

         //On veut afficher dynamiquement les resultats de la requête sous forme de table HTML

         $resultat = $pdo->query("SELECT id_employes, prenom, nom, service,salaire FROM employes ORDER BY salaire DESC");

         echo '<table border="1">';

         //La ligne d'entêtes :
         echo '<tr>';
         echo '<th>id employés</th>';
         echo '<th>prénom</th>';
         echo '<th>nom</th>';
         echo '<th>service</th>';
         echo '<th>salaire</th>';
         echo '</tr>';

          //Affichage des autre lignes :
          while($ligne = $resultat->fetch(PDO::FETCH_ASSOC)){
              echo'<tr>';
          //affichage des infos de chaque ligne $ligne:
          foreach($ligne as $info){
          echo '<td>'.$info.'</td>';
          }
                echo'</tr>';
          }


         echo'</table>';

               //-----------------------------
         //08 - Requête préparée et bindParam()
         //-------------------------- 
         
         echo '<h3> 08 -Requête préparée et bindParam() </h3>';

         /*
         1- On prépare la requête 

         2- On lies les marqueurs aux valeurs

         3-On execute la requête 
         */

         $nom = 'sennard';

         // 1 - préparer la requête :
         $resultat = $pdo->prepare("SELECT * FROM employes WHERE nom =:nom"); //:nom est un marqueur nominatif
         //qui attend qu'on lui donne une valeur

         //2 Lier les marqueurs aux valeurs :
         $resultat->bindParam(':nom',$nom); //bindParam reçoit exclusivement une variable

         //3-  Executer la requête :
         $resultat->execute();

         //4 - affichage:
         $donnees = $resultat->fetch(PDO::FETCH_ASSOC);
         debug($donnees);

         /*
         --prepare() permet de préparer le requête mais ne l'execute pas
         --execute() permet d'exécuter une requête préparée

         Valeurs de retour :
         prepare() renvoi toujours un objet PDOStatement
         execute() :
           En cas de succès: TRUE
           En cas d'échec: FALSE

           Les requêtes préparées sont préconisées si vous executez plusieurs fois la même requête 
           et ainsi éviter de refaire le cycle complet analyse/interpretation/execution réalisé par le SGBD (on ne refait que le execute)

           Les requêtes préparées sont souvent utilisees pour assainir les données (ce que nous verrons dans le chapitre ulterieur)

         */

                //-----------------------------
         //09 Requête préparée :points complémentaires
         //-------------------------- 
         echo '<h3> 09 - Requête préparée : points complémentaires </h3>';

         $resultat = $pdo->prepare("SELECT *FROM employes WHERE nom = ? AND prenom = ?");// on prépare dans un premier temps, la requête avec des marqueurs sous forme de "?";

         $resultat->execute(array('durand','damien'));// "durand" va remplacer le premier "?" et "damien" va remplacer le second "?"

         $donnees = $resultat->fetch(PDO::FETCH_ASSOC); // pas de while car il n'y a qu'un seul resultat

         echo $donnees['prenom'] . ' '.$donnees['nom'] .' '. 'du service' . ' '.$donnees['service'];


         //------------
          echo '<h4>execute() sans bindParam() : </h4>';
         $resultat = $pdo->prepare("SELECT *FROM employes WHERE nom = :nom AND prenom = :prenom");
         $resultat->execute(array(':nom'=>'chevel',':prenom' => 'daniel')); //on peut associer directement dans les () de execute() les marqueurs de la requête SQL
         //à leur valeur. Notez qu'il est possible de ne pas mettre les ":" avant le nom des marqueurs de cet array

         $donnees = $resultat->fetch(PDO::FETCH_ASSOC);
         echo $donnees['prenom'] . ' '.$donnees['nom'] .' '. 'du service' . ' '.$donnees['service'];
         





        



















