<?php
require_once('inc/init.inc.php');
  $q=$_GET["ville"];
   
   
  $sql = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
  FROM produit
  LEFT JOIN salle 
  ON produit.id_salle = salle.id_salle
    WHERE salle.ville LIKE  '$q' 
    ORDER BY produit.id_produit
  ");
  $sql->bindValue(':salle.ville', $q, PDO::PARAM_STR);
  $sql->execute();;
  $produits = $sql->fetchALL(PDO::FETCH_ASSOC); 
  $result = $sql;
   

   

        foreach($produits as $key => $value): ?>

<?php
      //On selectionne la date d'arrivée 
$dateArriveeFormat = $value['date_arrivee'] ;
//on selectionne avant le 1er espace de la chaine de caractere  Y-m-d Hms récupérée
$dateCrop = stristr($dateArriveeFormat, ' ', true); 
//on format la selection au format fr 
$dateArrivee = date("d-m-Y", strtotime($dateCrop));

//on selectionne les heure d'arrivée dans la chaine datetime Y-m-d Hms récupéree
$heure = $value['date_arrivee'];
//on selectionne ce qui se trouve aprés le 1espace dans la chaine datetime Y-m-d Hms récupéree donc les heure/min/sec d'arrivée
$heureArrivee = stristr($heure, ' '); 


//On selectionne la date de depart 
$dateDepartFormat = $value['date_depart'] ;
//on selectionne avant le 1er espace de la chaine de caractere  Y-m-d Hms récupérée
$dateCropHeure = stristr($dateDepartFormat, ' ', true); 
//on format la selection au format fr 
$dateDepart = date("d-m-Y", strtotime($dateCropHeure));

//on selectionne les heure d'arrivée dans la chaine datetime Y-m-d Hms récupéree
$heureDepartFormat = $value['date_depart'];
//on selectionne ce qui se trouve aprés le 1espace dans la chaine datetime Y-m-d Hms récupéree donc les heure/min/sec d'arrivée
$heureDepart = stristr($heureDepartFormat, ' '); ?>


        <div class="col-lg-4 col-md-6 mb-4">
        <div class="card h-100 text-right">
          <a href="fiche_produit.php?id_produit=<?= $value['id_produit'] ?>">
            <img class="img" height="150px" width="100%" src="<?= $value['photo'] ?>" alt="">
          </a>
          <div class="card-body text-left">
            <h4>Salle :<a href="fiche_produit.php?id_produit=<?= $value['id_produit'] ?>"><?= ucfirst($value['titre']) ?></a></h4>
            <span style="font-size:15px"><b>Tarif : <?= $value['prix'] ?>€</b></span><br><br>
            <span style="font-size:15px"><i class="fas fa-users"></i><b>Capacité : <?= $value['capacite'] ?> personnes</b></span>
            <br><br>
            <p><?=  substr($value['description'], 0, 100) ?>...</p>
            <p><i class="far fa-calendar-alt"></i><b> Disponible à parti du </b><?= $dateArrivee ?></p>
            <p><i class="fas fa-clock"></i><b> à partir de : </b><?= $heureArrivee ?></p>
            <p><i class="far fa-calendar-alt"></i><b> Jusqu'au </b><?= $dateDepart ?></p>
            <p><i class="fas fa-clock"></i><b> a : </b><?= $heureDepart ?></p>
            </div>
            <div class="card-footer">
              <a href="fiche_produit.php?id_produit=<?= $value['id_produit'] ?>" class="btn btn-dark">Détails</a> 
              </div>
            </div>
          </div>
        <?php endforeach; ?>
