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

  <div class="col-lg-3">

    <!-- Faites en sorte d'afficher les catégories de salles stockés en bdd et envoyer la catégorie dans l'URL -->

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


<?php
    $id_prod=$_GET['id_produit'];
    $dat = $bdd->query("SELECT salle.id_salle, salle.titre, salle.description, salle.photo, salle.pays, salle.ville, salle.adresse, salle.cp, salle.capacite, salle.categorie, produit.id_produit,  produit.date_arrivee, produit.date_depart, produit.prix, produit.etat 
    FROM produit
    LEFT JOIN salle 
    ON produit.id_salle = salle.id_salle
    WHERE produit.id_produit = $id_produit");
    $prod = $dat->fetch(PDO::FETCH_ASSOC);


     //echo '<pre>'; var_dump($prod); echo '</pre>';
?>


      <!-- /.col-lg-3 -->
      <div class="col-lg-9">
        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="<?= $prod["photo"] ?>" alt="">
          <div class="card-body">
            <h3 class="card-title"><?= $prod["titre"] ?></h3>
            <p class="card-text">Categorie de la salle : <?= $prod["categorie"] ?></p>
            <p class="card-text">Description de la salle : <?= $prod['description'] ?></p>
            <p class="card-text">Capacité : <?= $prod['capacite'] ?></p><hr>

                    <form method="post" action="panier.php">
                        <input type="hidden" name="id_produit" value="<?= $prod['id_produit'] ?>">
                            <button type="reserver" class="btn btn-dark" style="margin-top:5px">Réserver</button>
                        </div>
                    </form>


                
          </div>
        </div>
        <!-- /.card -->

        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            Product Reviews
          </div>
          <div class="card-body">
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr>
            <a href="#" class="btn btn-success">Leave a Review</a>
          </div>
        </div>
        <!-- /.card -->

      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->





  <?
require_once('inc/footer.inc.php');