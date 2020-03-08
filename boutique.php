<?php 
require_once('inc/init.inc.php');

    $data = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
    FROM produit
    LEFT JOIN salle 
    ON produit.id_salle = salle.id_salle
    ORDER BY produit.id_produit;");
    $produits = $data->fetchALL(PDO::FETCH_ASSOC);

require_once('inc/header.inc.php');
?>
<!--container-->
<div class="container">

<div class="row">

  <div class="col-lg-3">

    <!-- Faites en sorte d'afficher les catégories de salle stockés en bdd et envoyer la catégorie dans l'URL-->

        <!--Requete de selection de salle-->
        <h4 class="my-4 text-center">Selectionner</h4>
        

 <!-- VILLE DE LA SALLE-->
 <select name="ville" onchange="showUser(this.value)">
  <option value="">Sélectionner une ville:</option>
  <option value="paris">Paris</option>
  <option value="lyon">Lyon</option>
  <option value="marseille">Marseille</option>
  </select> 





        </div>
  <!-- /.col-lg-3 -->

  <div class="col-lg-9">

    <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
      <ol class="carousel-indicators">
        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="carousel-item active">
          <img class="d-block img-fluid" src="photo/ban.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid" src="photo/ban.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
          <img class="d-block img-fluid" src="photo/ban.jpg" alt="Third slide">
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

    <div class="row">



    <!-- Affichage produit SELECTION AJAX-->
    <div class="container row" id="txtHint" >

    <!-- Affichage produit SELECTION CLASSIQUE-->
    <?php foreach($produits as $key => $value): ?>

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

    <?php endforeach;  ?>
</div>
    </div>
    <!-- /.row -->

  </div>
  <!-- /.col-lg-9 -->

</div>
<!-- /.row -->

</div>
<!-- /.container -->






<script
src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous">
</script>
 <script
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js">
 </script>




<?
require_once('inc/footer.inc.php');
