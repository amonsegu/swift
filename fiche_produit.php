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
      <img class="img-fluid" src="<?= $photolien ?>" alt="">
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
        <p class="card-text text-left"><i class="fas fa-calendar-alt"></i><b> Date d'arrivée : </b><?php echo "$dateArrivee" . '<b> à partir de :</b>' . "$heureArrivee" ?></p>
        <p class="card-text text-left"><i class="fas fa-calendar-alt"></i><b> Date de départ : </b><?php echo "$dateDepart" . '<b> à partir de :</b>' . "$heureDepart" ?></p>
        <p class="card-text text-left"><i class="fas fa-users"></i><b> Capacité : </b><?= $prod['capacite'] ?></p>
        <p class="card-text text-left"><i class="fas fa-inbox"></i><b> Categorie de la salle : </b><?= ucfirst($prod["categorie"]) ?></p>
        <p class="card-text text-left"><i class="fas fa-map-marker-alt"></i><b> Adresse : </b><?= $prod['adresse'] . ' ' . $prod['cp'] . ' ' . $prod['ville'] ?></p>
        <p class="card-text text-left"><i class="fas fa-euro-sign"></i><b> Tarif : </b><?= $prod['prix'] ?> €</p><hr>




</div>
        
    <!--Bloc commentaire-->
    <?php
    $numeroSalle=$prod['id_salle'];
    $dat2 = $bdd->query("SELECT avis.id_avis, avis.id_membre, avis.id_salle, avis.commentaire, avis.note, avis.date_enregistrement, salle.id_salle, membre.id_membre, membre.pseudo
    FROM avis
    LEFT JOIN salle 
    ON avis.id_salle = salle.id_salle
    LEFT JOIN membre
    ON avis.id_membre = membre.id_membre
    WHERE avis.id_salle = $numeroSalle");
 


    $data3 = $bdd->prepare("SELECT AVG(note) FROM avis WHERE id_salle = $numeroSalle");
    $data3->execute();
    

    $noteRecup = $data3->fetch(PDO::FETCH_NUM);
    //echo "<pre>"; var_dump($noteRecup); echo"</pre>";
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

    <?php while($prod = $dat2->fetch(PDO::FETCH_ASSOC)): ?>       
  </div>
  <div class="p-1">
  <p><?= $prod['commentaire'] ?></p>
  <small class="text-muted">
  <p>
    <b>Posté par :</b>
    <?= ucfirst($prod['pseudo']) ?> Le <?= $prod['date_enregistrement'] ?>
  </small>
    <?php endwhile; ?>
  </div>
</div>
<!--Fin commentaire-->
        
        <!-- /.card -->
        <?php if(connect()): // accés membre connecté ?>
        <div class="container row justify-content-between">
            <div>
              <h5>Formulaire envoi avis</h5>
            </div>
            
            <div>
            <a href="index.php"class="btn btn-dark" style="margin-top:5px">Retour boutique</a>
            </div>
          </div>
            

            <?php else: // visiteur non connécté ?>

            <div class="container row justify-content-between mt-1 mb-3">
            <div>
              <a href="connexion.php"><h6 class="rounded p-1" style="background-color: lightgray">Veuillez vous connecter afin de laisser un avis</h6></a>
            </div>
            
            <div>
            <a href="<?php echo $_SERVER['HTTP_REFERER']; ?>"class="btn btn-dark" style="margin-top:5px">Retour</a>
            </div>
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