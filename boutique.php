<?php 
require_once('inc/init.inc.php');

//On vérifie si une catégorie est bien définit dans l'URL
if(isset($_GET['etat']))
{
            $data = $bdd->prepare("SELECT * FROM produit WHERE etat = :etat");
            $data->bindValue(':etat', $_GET['etat'], PDO::PARAM_STR);
            $data->execute();


            //Si la condition IF renvoie TRUE, cela veut dire que le requete a bien retourné des produits liés a la catégorie
            if($data->rowCount())     //rowncount permet de compter le nombre de lignes par selection
                {
                    $produits = $data->fetchALL(PDO::FETCH_ASSOC);
                    //echo'<pre>'; print_r($produits); echo '</pre>';
                }
                else{   // sinon la catégorie dans l'URL n'existe pas en BDD on renvoie vers la page boutique
                    header('Location: ' . URL . 'boutique.php');
                }
        
}else // si il n'y a pas de catégories dans l'URL, nous selectionons l'ensemble des produits
{
    $data = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
    FROM salle
    LEFT JOIN produit 
    ON salle.id_salle = produit.id_salle
    ORDER BY salle.id_salle;");
    $produits = $data->fetchALL(PDO::FETCH_ASSOC);
}
require_once('inc/header.inc.php');
?>
<!--container-->
<div class="container">

<div class="row">

  <div class="col-lg-3">

    <!-- Faites en sorte d'afficher les catégories de produits stockés en bdd et envoyer la catégorie dans l'URL (category=tee-shirt)  -->

        <!--Requete de selection de salle-->
        <h4 class="my-4 text-center">Nos salles</h4>
        <div class="list-group">
            <?php 
            $data = $bdd->query("SELECT DISTINCT etat FROM produit");
            while($cat = $data->fetch(PDO::FETCH_ASSOC)):
                //echo '<pre>'; print_r($cat); echo '</pre>';
            ?>
                <a href="?etat=<?= $cat['etat'] ?>" class="list-group-item alert-link text-dark text-center"><?= $cat['etat'] ?></a>

            <?php endwhile; ?>  
        </div>
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

    <?php endforeach; ?>
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
