<?php 
require_once('inc/init.inc.php');
require_once('inc/fonction.inc.php');
require_once('inc/header.inc.php');
    $data = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat
    FROM produit
    LEFT JOIN salle 
    ON produit.id_salle = salle.id_salle
    ORDER BY produit.id_produit;");
    $produits = $data->fetchALL(PDO::FETCH_ASSOC);


?>
<!--container-->
<div class="container">

  <div class="row">

    <div class="col-lg-9 ">
          
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
      
      </div>







    <div class="col-lg-3 ">
        <!--REQUETE DE SELECTION POUR LES INPUT SELECT-->
        <?php $datasalle = $bdd ->query("SELECT DISTINCT ville FROM salle ");?>
        <?php $cpsalle = $bdd ->query("SELECT DISTINCT cp FROM salle ");?>
        <?php $catsalle = $bdd ->query("SELECT DISTINCT categorie FROM salle ");?>
        <?php $capsalle = $bdd ->query("SELECT DISTINCT capacite FROM salle ");?>

      <p style="margin-top:30px;text-align:center;" ><b>Menu de navigation rapide</b></p>
      <p style="text-align:center;">Vos criteres nos dispos</p> 
      
      <form>     
      <!-- VILLE DE LA SALLE-->
      <div class="form-group">
          <label for="selectVille">Ville</label>
          <select class="form-control" id="selectVille" onchange="showProductVille(this.value)">
          <option value="" selected disabled >selectionner</option>
          <?php
                      while($cat = $datasalle->fetch(PDO::FETCH_ASSOC)):
                  ?>
                      <option value='<?php echo (string)$cat['ville'] ?>'>
                      <?php
                      echo $cat['ville'] ;
                      ?>
                      </option>
                  <?php endwhile; ?> 
          </select>
        </div>

        <!-- CP DE LA SALLE-->
        <div class="form-group">
          <label for="selectcp">Code Postal</label>
          <select class="form-control" id="selectcp" onchange="showProductCp(this.value)">
          <option value="" selected disabled >selectionner</option>
          <?php
                      while($cat = $cpsalle->fetch(PDO::FETCH_ASSOC)):
                  ?>
                      <option value='<?php echo (int)$cat['cp'] ?>'>
                      <?php
                      echo $cat['cp'] ;
                      ?>
                      </option>
                  <?php endwhile; ?> 
          </select>
        </div>

        <!-- CATEGORIE DE LA SALLE-->
        <div class="form-group">
          <label for="selectCat">Categorie</label>
          <select class="form-control" id="selectCat" onchange="showProductCat(this.value)">
          <option value="" selected disabled >selectionner</option>
          <?php
                      while($cat = $catsalle->fetch(PDO::FETCH_ASSOC)):
                  ?>
                      <option value='<?php echo (string)$cat['categorie'] ?>'>
                      <?php
                      echo $cat['categorie'] ;
                      ?>
                      </option>
                  <?php endwhile; ?> 
          </select>
        </div>

        <!-- CAPACITE DE LA SALLE-->
          <div class="form-group">
            <label for="selectSalle">Capacité</label>
            <select class="form-control" id="selectSalle" onchange="showProductCap(this.value)">
            <option value="" selected disabled >selectionner</option>
            <?php
                        while($cat = $capsalle->fetch(PDO::FETCH_ASSOC)):
                    ?>
                        <option value='<?php echo (int)$cat['capacite'] ?>'>
                        <?php
                        echo $cat['capacite'] ;
                        ?>
                        </option>
                    <?php endwhile; ?>
            </select>
          </div>
      </form>

  </div>
  <!-- /.col-lg-3 -->

  
                        </div>
  <!--FIN ROW1-->
  
  
  <!--ROW2-->
  <div class="row" >

    <!-- Affichage produit SELECTION AJAX-->
    <div class="container row" id="txtHint" >

    <!-- Affichage produit SELECTION CLASSIQUE-->
    <?php foreach($produits as $key => $value): ?>
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
        
    <?php endforeach;  ?>
    </div></div>
<!--Fin selection AJAX-->
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
