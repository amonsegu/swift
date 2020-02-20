<?php
require_once('../inc/init.inc.php');

//Si l'internaute n'est pas admin ou pas connecté il n'a rien à faire sur cette page, on le redirige vers la page connexion 
if(!connecteAdmin())
{
    header('Location:' . URL . 'connexion.php' );
}


//----------------------SUPPRESSION PRODUIT 
if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    //requete de suppression préparé
    $supp = $bdd->prepare("DELETE FROM salle WHERE id_salle = :id_salle");
    $supp->bindValue(':id_salle',$_GET['id_salle'], PDO::PARAM_INT);
    // on envoie l'id_produit récupéré dans l'URL dans le marqueur :id_produit
    $supp->execute();

    $_GET['action'] = 'affichage' ; 

    $validsupp = "<p class='col-md-6 p-3 rounded bg-success mx-auto text-white text-center'>Le produit <strong>ID $_GET[id_salle]</strong> a bien été supprimé </p>";
}

if($_POST)
{
    extract($_POST);

    $photoBdd ='';

    $errorUpload = '';

    if (!isset($error))
    {
        if(isset($_GET['action']) && $_GET['action'] == 'ajout')
        {
            //requete d'insertion  ENREGISTREMENT SALLE   
            $insert = $bdd->prepare("INSERT INTO produit (id_salle, date_arrivee, date_depart, prix, etat) VALUES (:id_salle, :date_arrivee, :date_depart, :prix, :etat)");
            

            $_GET['action'] = 'affichage'; // Redéfini l'indice action en affichage pour qu'aprés modification du produit on revienne a l'affichage des produits 

            $validInsert = '<p class="col-md-6 p-3 rounded bg-success mx-auto text-white text-center">Le produit à bien été enregistré </p>';
        }
        else{
            //requete d'update MODIFICATION SALLE
            $insert = $bdd->prepare("UPDATE produit SET id_salle =:id_salle , date_arrivee =:date_arrivee , date_depart=:date_depart , prix=:prix , etat=:etat WHERE id_produit=:id_produit");
            $insert->bindValue(':id_produit',$_GET['id_produit'], PDO::PARAM_INT);
            
            $_GET['action'] = 'affichage';
            $validUpdate = '<p class="col-md-6 p-3 rounded bg-success mx-auto text-white text-center">Le produit  à bien été modifié </p>';
            
        }
    }

        $insert->bindValue(':id_salle', $id_salle, PDO::PARAM_INT);
        $insert->bindValue(':date_arrivee', $date_arrivee, PDO::PARAM_STR);
        $insert->bindValue(':date_depart', $date_depart, PDO::PARAM_STR);
        $insert->bindValue(':prix', $prix, PDO::PARAM_INT);
        $insert->bindValue(':etat', $etat, PDO::PARAM_STR);

        $insert->execute();

    }
require_once('../inc/header.inc.php');
?>

<!-- AFFICHAGE LIENS MENU PRODUIT -->
<div><p class="col-md-4 offset-md-4 bg-secondary text-center rounded text-white mt-2 p-3">BACKOFFICE</p></div>
<div><a href="?action=affichage" class="col-md-4 offset-md-4 btn btn-info p-2 mb-1 mt-3">AFFICHAGE DES PRODUITS</a></div>
<div><a href="?action=ajout" class="col-md-4 offset-md-4 btn btn-info p-2 my-1">AJOUTER UN PRODUIT</a></div>

<!--001 Si l'indice 'action' est définit dans l'URL et a pour valeur 'affichage', alors on entre dans la condition et on execute le code de l'affichage des produits, on entre dans le IF seulement dans le cas ou l'on a cliqué sur le lien 'AFFICHAGE DES PRODUITS' (ci dessus) -->
<?php if(isset($_GET['action']) && $_GET['action'] == 'affichage'): ?>

<!--Requete de selection produit-->
<?php $data = $bdd ->query("SELECT * FROM produit ORDER BY id_produit"); ?>

<!--------------- AFFICHAGE SALLE--------------------->

<?php if(isset($validsupp)) echo $validsupp ?>

<h3 class="display-4 text-center mt-2">Les produits</h3>

<?php
if(isset($validDelete)) echo $validDelete;
if(isset($validInsert)) echo $validInsert;
if(isset($validUpdate)) echo $validUpdate; 
?>

<table class="table table-bordered text-center"><tr>
<?php 
//columnCount() : méthode PDOStatement qui retourne le nombde de colonne selectionné dans la requete SELECT
        for ($i = 0; $i < $data->columnCount(); $i++):
            //getColumnMeta() : permet de recolter les informations liés aux champs/colonne de la table (primary key, not null, nom du champs..)
        $colonne = $data->getColumnMeta($i) 
        ?>
        <th><?= $colonne['name'] // on va crocheter à l'indice 'name' afin d'afficher chaque nom de colonne dans les entetes du tableau?></th>
        <?php endfor; ?>
        <th>Edit</th>
        <th>Supp</th>
    </tr>
    <!--On associe la méthode fetch à l'objet PDOStatement, ce qui retourne un ARRAY d'1 produit par tour de boucle WHILE-->
    <?php while($products = $data->fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
        <!--La boucle foreach passe en revue chaque tableau ARRAY de chaque produits-->
        <?php foreach($products as $key => $value): ?>

            <!--Si l'indice du tableau est 'photo' on envoi l'URL de l'image dans l'attribut 'src' de la balise 'img' afin d'afficher l'image et pas l'URL de l'image-->
        <?php if($key == 'photo'): ?>
        <td><img src="<?= $value ?>" alt="" style="width : 100px;"></td>
        <?php else: //sinon on affiche chaque donnée normalement dans des cellules <td>?> 
            <td><?= $value ?></td>
        <?php endif; ?>
        <?php endforeach; ?>
        <!--On créer 2liens 'modification' et 'suppression' pour chaque produits en envoyant l'ID du produit dans l'URL-->
                <td><a href="?action=modification&id_produit=<?=$products['id_produit']?>" class="btn btn-dark"> Modifier</a></td>
                <td><a href="?action=suppression&id_produit=<?=$products['id_produit']?>" class="btn btn-danger"> Supprimer</a></td>

    </tr>
        <?php endwhile; ?>

</table>
<!------------------FIN AFFICHAGE SALLE------------------->
<!--Balise de fermeture de la condition d'affichage 001-->
<?php endif; ?>


<!--Condition d'affichage du formulaire 002  la valeur "ajout" est defini dans les liens AFFICHAGE LIENS MENU PRODUIT
si il y a action et ajout dans L'URL on lance le formulaire OU si dans l'url il y a action et modification on lance le meme formulaire-->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')): 
    
    if(isset($_GET['id_produit']))
    {
        $data = $bdd->prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
        $data->bindValue(':id_produit', $_GET['id_produit'], PDO::PARAM_INT);
        $data->execute();

        $produitactuel = $data->fetch(PDO::FETCH_ASSOC);



        foreach($produitactuel as $key => $value)
        {
            $$key = (isset($produitactuel["$key"])) ? $produitactuel["$key"] : '';

        }
    }    


?>

<!---Formulaire table salle --->

<h3 class="display-4 text-center mt-2"><?= ucfirst($_GET['action']) ?> Produit</h3>
<form class="container" action="#" method="POST" enctype="multipart/form-data" style="margin-top:35px; margin-bottom:35px;">
<?php if (isset($validInsert)) echo $validInsert ?>
    
<!-- SALLE-->
        <div class="form-group">        
        <label for="id_salle" style="margin-top:20px">salle</label>
        <select id="id_salle" name="id_salle" class="form-control">
            <option value="6" <?php if(isset($taille) && $taille == "6") echo 'selected'?>>Cezanne</option>
            <option value="7"  <?php if(isset($taille) && $taille == "7") echo 'selected'?>> Mozart</option>
            <option value="8"  <?php if(isset($taille) && $taille == "8") echo 'selected'?>> Verdi</option>
            <option value="9"  <?php if(isset($taille) && $taille == "9") echo 'selected'?>> Bach</option>
        </select>
        </div>

<!-- DATE ARRIVEE-->
<div class="form-group">        
        <label style="margin-top:20px" for="date_arrivee" >Date d'arrivée</label>
        <input type="date" class="form-control" id="date_arrivee"  name="date_arrivee">
        </div>    
      
<!-- DATE DEPART -->
<div class="form-group">        
        <label style="margin-top:20px" for="date_depart" >Date de départ</label>
        <input type="date" class="form-control" id="date_depart"  name="date_depart">
        </div>   

<!-- CP DE LA SALLE-->
<div class="form-group">        
        <label style="margin-top:20px" for="prix" >Tarif</label>
        <input type="number" class="form-control" id="prix" placeholder="tarif" name="prix"  value="<?php if(isset($prix)) echo ("$prix") ?> ">
        </div>   

<!-- ETAT-->
<div class="form-group">        
        <label for="etat" style="margin-top:20px">Etat</label>
        <select id="etat" name="etat" class="form-control">
            <option value="libre" <?php if(isset($etat) && $etat == "libre") echo 'selected'?>>libre</option>
            <option value="reservation"  <?php if(isset($etat) && $etat == "reservation") echo 'selected'?>> reservation</option>
        </select>
        </div>

        <button type="submit" class="btn btn-primary" style="margin:5px 0px 0px 0px"><?= ucfirst($_GET['action']) ?> Produit</button>

</form>


</main>
<?php 
//fin de la condition d'affichage du formulaire 002
endif;
require_once('../inc/footer.inc.php');