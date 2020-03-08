<?php
require_once('inc/init.inc.php');
  $q=$_GET["ville"];
   
   
  $sql = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
  FROM produit
  LEFT JOIN salle 
  ON produit.id_salle = salle.id_salle
    WHERE salle.cp LIKE  '$q' 
    ORDER BY produit.id_produit
  ");
  $sql->bindValue(':salle.ville', $q, PDO::PARAM_STR);
  $sql->execute();;
  $produits = $sql->fetchALL(PDO::FETCH_ASSOC); 
  $result = $sql;
   

   

        foreach($produits as $key => $value): ?>

            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card h-100">
                <a href="fiche_produit.php?id_produit=<?= $value['id_produit'] ?>">
                  <img class="card-img-top" src="<?= $value['photo'] ?>" alt="">
                </a>
                <div class="card-body">
                    <h4 class="<?= $value['titre']?>">
                    <a href="fiche_produit.php?id_produit=<?= $value['id_produit'] ?>"><?= $value['titre'] ?></a>
                    </h4>
                    <h5><?= $value['prix']?>€</h5>
                    <p class="card-text"><?= substr($value['description'], 0, 100)?>... <br><?= $value['date_arrivee'] ?><br><?= $value['date_depart'] ?></p>
                </div>
                <div class="card-footer">
                    <a href="fiche_produit.php?id_produit=<?= $value['id_produit'] ?>" class="btn btn-dark">Détails</a>
                </div>
                </div>
            </div>
        <?php endforeach; ?>
