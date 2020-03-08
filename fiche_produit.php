<?php
require_once('inc/init.inc.php');

//on vérifie si un ID produit est bien présent dans l'URL, on entre dans le IF
if(isset($_GET['id_produit']))
{   
    $id_produit=$_GET['id_produit'];
    $data = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
    FROM produit
    LEFT JOIN salle 
    ON produit.id_salle = salle.id_salle
    WHERE produit.id_produit = $id_produit");
    $produits = $data->fetchALL(PDO::FETCH_ASSOC);

 //echo '<pre>'; var_dump($produits); echo '</pre>';
 //echo $produits["id_produit"];


            //On compte le nombre de ligne, si la requete de selection à retourné un résultat, le produit est existant en BDD on entre dans le IF
            if($data->rowCount())     //rowncount permet de compter le nombre de lignes par selection
                {
                    $produits = $data->fetchALL(PDO::FETCH_ASSOC);
                    
                }
                else{   // sinon l'id produit n'est pas connu en BDD, on redirige l'internaute vers la page boutique
                    header('Location: ' . URL . 'boutique.php');
                }
        
}else // si il n'y a pas d'id dans l'URL on entre dans le ELSE et l'internaute est redirigé vers la boutique
{
    header('Location: ' . URL . 'boutique.php');
}

require_once('inc/header.inc.php');
?>



<!--container-->
<div class="container">

<div class="row">

<?php
    $id_prod=$_GET['id_produit'];
    $dat = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
    FROM produit
    LEFT JOIN salle 
    ON produit.id_salle = salle.id_salle
    WHERE produit.id_produit = $id_produit");
    $prod = $dat->fetch(PDO::FETCH_ASSOC);
    $titreMaj = $prod["titre"]; 
    $titreMaj = trim($titreMaj);         
    $titreMaj = ucfirst($titreMaj);        

     //echo '<pre>'; var_dump($prod); echo '</pre>';
?>




      <!-- /.col-lg-3 -->

  <div>
     <a href="javascript:history.back()"class="btn btn-dark" style="margin-top:5px">Retour boutique</a>
  </div>
  <div class="container row justify-content-between" style="margin-top:20px">
  
  <div>
    <h3 >
      <p><b>Salle : </b><?php echo $titreMaj; ?></p>
    </h3>
  </div>

  <div>
          <form method="post" action="panier.php">
            <input type="hidden" name="id_produit" value="<?= $prod['id_produit'] ?>">
              <button type="reserver" class="btn btn-danger" style="margin-top:5px">Réserver</button>
          </form>
  </div>
</div>

<div class="col-lg-12 m-0 p-0">
  <div class="row m-0 p-0">
      <div class="col-lg-8">
      <?php 
      $photolien=$prod["photo"];
      ?>
      <img class="img-fluid border rounded" src="<?= $photolien ?>" alt="">
      </div>
  
  <div class="col-lg-4 p-0">
    <p class="card-text text-left"><b>Description de la salle :</b><br> <?= $prod['description'] ?></p>
    <p><b>Localisation :</b> <br></p>
    
<?php
$ville = $prod["ville"];
$adresse = $prod["adresse"];
$cp = $prod["cp"];
 
$ville_url = str_replace(' ', '+', $ville); // remplace espace par +
$adresse_url = str_replace(' ', '+', $adresse); // remplace espace par +
$MapCoordsUrl = $cp.'+'.$ville_url.'+'.$adresse_url; //url_encode : encodage pour URL
?>
 
<div class="block overflow-hidden">
    <iframe id="frame" width="350" height="250" src="http://maps.google.fr/maps?q=<?php echo $MapCoordsUrl; ?>&amp;t=h&amp;output=embed" 
    frameborder="0" scrolling="no" marginheight="0" marginwidth="20" ></iframe>
</div>
    
</div>
</div>
<?php
//On selectionne la date d'arrivée 
$dateArriveeFormat = $prod['date_arrivee'] ;
//on selectionne avant le 1er espace de la chaine de caractere  Y-m-d Hms récupérée
$dateCrop = stristr($dateArriveeFormat, ' ', true); 
//on format la selection au format fr 
$dateArrivee = date("d-m-Y", strtotime($dateCrop));

//on selectionne les heure d'arrivée dans la chaine datetime Y-m-d Hms récupéree
$heure = $prod['date_arrivee'];
//on selectionne ce qui se trouve aprés le 1espace dans la chaine datetime Y-m-d Hms récupéree donc les heure/min/sec d'arrivée
$heureArrivee = stristr($heure, ' '); 


//On selectionne la date d'arrivée 
$dateDepartFormat = $prod['date_depart'] ;
//on selectionne avant le 1er espace de la chaine de caractere  Y-m-d Hms récupérée
$dateCropHeure = stristr($dateDepartFormat, ' ', true); 
//on format la selection au format fr 
$dateDepart = date("d-m-Y", strtotime($dateCropHeure));

//on selectionne les heure d'arrivée dans la chaine datetime Y-m-d Hms récupéree
$heureDepartFormat = $prod['date_depart'];
//on selectionne ce qui se trouve aprés le 1espace dans la chaine datetime Y-m-d Hms récupéree donc les heure/min/sec d'arrivée
$heureDepart = stristr($heureDepartFormat, ' '); 
?>
<div class="container col-12 mt-2">
   <div class="row">   
      <div class="col-5">
        <p class="card-text text-left"><i class="fas fa-calendar-alt"></i><b> Date d'arrivée : </b><?php echo "$dateArrivee" . '<b> à partir de :</b>' . "$heureArrivee" ?></p>
        <p class="card-text text-left"><i class="fas fa-calendar-alt"></i><b> Date de départ : </b><?php echo "$dateDepart" . '<b> à partir de :</b>' . "$heureDepart" ?></p>
      </div>
      <div class="col">
        <p class="card-text text-left"><i class="fas fa-users"></i><b> Capacité : </b><?= $prod['capacite'] ?></p>
        <p class="card-text text-left"><i class="fas fa-inbox"></i><b> Categorie de la salle : </b><?= ucfirst($prod["categorie"]) ?></p>
    </div>
    <div class="col>  
        <p class="card-text text-left"><i class="fas fa-map-marker-alt"></i><b> Adresse : </b><?= $prod['adresse'] . ' ' . $prod['cp'] . ' ' . $prod['ville'] ?></p>
        <p class="card-text text-left"><i class="fas fa-euro-sign"></i><b> Tarif : </b><?= $prod['prix'] ?> €</p>
    </div>
    </div>
</div>
<hr>


<?php
$cpsalle = $prod['cp'];
$numeroSalle=$prod['id_salle'];
$dataPhoto = $bdd->prepare("SELECT salle.id_salle, salle.titre, salle.photo, salle.cp, produit.id_produit
FROM salle
LEFT JOIN produit 
ON produit.id_salle = salle.id_salle
WHERE salle.cp = $cpsalle
AND salle.id_salle != $numeroSalle
AND produit.id_produit IS NOT NULL");
$dataPhoto->execute();
$dp = $dataPhoto->fetchALL(PDO::FETCH_ASSOC);
echo "<pre>"; var_dump($dp); echo"</pre>";



?>







</div>
        
    <!--Bloc commentaire-->
    <?php
    $numeroSalle=$prod['id_salle'];
    $dat2 = $bdd->prepare("SELECT avis.id_avis, avis.id_membre, avis.id_salle, avis.commentaire, avis.note, avis.date_enregistrement, salle.id_salle, salle.titre, membre.id_membre, membre.pseudo
    FROM avis
    LEFT JOIN salle 
    ON avis.id_salle = salle.id_salle
    LEFT JOIN membre
    ON avis.id_membre = membre.id_membre
    WHERE avis.id_salle = $numeroSalle");
    $dat2->execute();


    $data3 = $bdd->prepare("SELECT AVG(note) FROM avis WHERE id_salle = $numeroSalle");
    $data3->execute();
    
    
    $noteRecup = $data3->fetch(PDO::FETCH_NUM);
    //echo "<pre>"; var_dump($_SESSION); echo"</pre>";
    //$noteRecup = (int)$noteRecup;
    $noteRecup = round($noteRecup[0], 0, PHP_ROUND_HALF_UP);
    $noteRecup = (int)$noteRecup;
   // echo "<pre>"; var_dump($noteRecup); echo"</pre>";
  if($noteRecup==1){
    $noteaffichage = '<span style="color:gold; font-size: 30px;">★</span>';
  }elseif($noteRecup==2){
    $noteaffichage = '<span style="color:gold; font-size: 30px;">★★</span>';
  }
  elseif($noteRecup==3){
    $noteaffichage = '<span style="color:gold; font-size: 30px;">★★★</span>';
  }
  elseif($noteRecup==4){
    $noteaffichage = '<span style="color:gold; font-size: 30px;">★★★★</span>';
  }
  elseif($noteRecup==5){
    $noteaffichage = '<span style="color:gold; font-size: 30px;">★★★★★</span>';
  }
    ?>

<div class="container border  rounded col-12 p-0">
  <div style="background-color: #F5F5F5; height:50px">
    <h5 class="p-1"><b>Les avis sur la Salle :</b> <?= $titreMaj . ' ' .$noteaffichage ?></h5> 

    <?php while($prod = $dat2->fetch(PDO::FETCH_ASSOC)): 
      $prod['note'] = round($prod['note'], 0, PHP_ROUND_HALF_UP);
      $prod['note'] = (int)$prod['note'];
      if($prod['note']==1){
        $noteUser = '<span style="color:gold; font-size: 20px;">★</span>';
      }elseif($prod['note']==2){
        $noteUser = '<span style="color:gold; font-size: 20px;">★★</span>';
      }
      elseif($prod['note']==3){
        $noteUser = '<span style="color:gold; font-size: 20px;">★★★</span>';
      }
      elseif($prod['note']==4){
        $noteUser = '<span style="color:gold; font-size: 20px;">★★★★</span>';
      }
      elseif($prod['note']==5){
        $noteUser = '<span style="color:gold; font-size: 20px;">★★★★★</span>';
      }
        ?>
      
  </div>
  <div class="p-1">
  <p><?= $prod['commentaire'] ?></p>
  <small class="text-muted">
  <p>
    <b>Posté par :</b>
    <?= ucfirst($prod['pseudo']) . ' Le ' .  $prod['date_enregistrement'] . ' ' . $noteUser ?>
  </small>
    <?php endwhile; ?>
  </div>
</div>
<!--Fin commentaire-->

        
        <!-- /.card -->
        <?php if(connect()): // accés membre connecté 
        extract($_POST);

        
        if($_POST)
        {



              $commentaire = $_POST["commentaire"];
              $commentaire = trim($commentaire);
              $commentaire = stripslashes($commentaire);
              $commentaire = htmlspecialchars($commentaire);

              echo $commentaire;
              

              $infosFormulaire = $bdd->query("SELECT avis.id_avis, avis.id_membre, avis.id_salle, avis.commentaire, avis.note, avis.date_enregistrement, salle.id_salle, salle.titre, membre.id_membre, membre.pseudo
              FROM avis
              LEFT JOIN salle 
              ON avis.id_salle = salle.id_salle
              LEFT JOIN membre
              ON avis.id_membre = membre.id_membre
              WHERE avis.id_salle = $numeroSalle");
              $recupFormulaire = $infosFormulaire->fetch(PDO::FETCH_ASSOC);
  
                $insert = $bdd->prepare("INSERT INTO avis (id_membre, id_salle, commentaire, note, date_enregistrement) VALUES (:id_membre, :id_salle, :commentaire, :note, now() )");
        
                $insert->bindValue(':id_membre', $_SESSION['membre']['id_membre'], PDO::PARAM_INT);
                $insert->bindValue(':id_salle', $recupFormulaire['id_salle'], PDO::PARAM_INT);
                $insert->bindValue(':commentaire', $commentaire, PDO::PARAM_STR);
                $insert->bindValue(':note', $noteUser, PDO::PARAM_INT);
        
                $insert->execute();


        }

          $infosFormulaire = $bdd->query("SELECT avis.id_avis, avis.id_membre, avis.id_salle, avis.commentaire, avis.note, avis.date_enregistrement, salle.id_salle, salle.titre, membre.id_membre, membre.pseudo
          FROM avis
          LEFT JOIN salle 
          ON avis.id_salle = salle.id_salle
          LEFT JOIN membre
          ON avis.id_membre = membre.id_membre
          WHERE avis.id_salle = $numeroSalle");
          $recupFormulaire = $infosFormulaire->fetch(PDO::FETCH_ASSOC);
         // echo "<pre>"; var_dump($recupFormulaire); echo"</pre>";
         // echo "<pre>"; var_dump($_SESSION); echo"</pre>";

          
          ?>
        <h6 class="display-4 text-center mt-2">Laisser un avis</h6><hr>
        <div class="container row justify-content-between">
        <form method="post">
          <div class="form-row">
              <div class="form-group col-md-12">
              <label for="pseudo">Pseudo</label>
              <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $_SESSION['membre']['pseudo'] ?>" disabled required>
              </div>

              <div class="form-row col-md-12">
                <div class="form-group col-md-6">
                  <label for="pseudo">Salle</label>
                  <input type="text" class="form-control" id="pseudo" name="pseudo" value="<?= $recupFormulaire['titre'] ?>" disabled required>
                </div>

                <div class="form-group col-md-6">
                  <label for="noteUser">Note :</label>
                  <select id="noteUser" name="noteUser" class="form-control" required>
                    <option value=1>★</option>
                    <option value=2>★★</option>
                    <option value=3>★★★</option>
                    <option value=4>★★★★</option>
                    <option value=5>★★★★★</option>
                  </select>
               </div>
                </div>      

               <div class="form-row col-md-12">
               <label for="commentaire">Avis :</label>
                <textarea type="textarea" class="form-control" id="commentaire" name="commentaire" placeholder="Entrer ici votre avis" rows=3 maxlength="555" required></textarea>    
               <small><p>555 caractères maximum<p><small>
              </div>

              <button type="submit" class="btn btn-dark mt-2 mb-3" >Poster</button>

            </form>


            <?php else: // visiteur non connécté ?>

            <div class="container row justify-content-between mt-1 mb-3">
              <a href="connexion.php"><h6 class="rounded p-1" style="background-color: lightgray">Veuillez vous connecter afin de laisser un avis</h6></a>  
          </div>

          <?php endif; ?>
                        <!-- /.card -->
              </div>
                        <!-- /.col-lg-9 -->
            </div>
            
  </div>
  <!-- /.container -->



  <?
require_once('inc/footer.inc.php');