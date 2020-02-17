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
    //realiser le script permettant de supprimer un produit avec une requete préparée


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
    //echo'<pre>';print_r($_FILES); echo '</pre>';
    $photoBdd ='';
    if(isset($_GET['action']) && $_GET['action'] == 'modification')
    {
        $photoBdd = $photo_actuelle; // si on souhaite conserver le même photo en cas de modification, on affecte la valeur du champ type hidden, c'est a dure l'url de la photo actuelle en bdd
    }

    $errorUpload = '';


    //Si l'internaute a uploader une image, on entre dans le if 
    if(!empty($_FILES['photo']['name']))
    {
        //on définit une liste d'éxtension de fichier autorisé 
        $listExt = array(1 => 'jpg', 2 => 'jpeg', 3=>'png');
        
        //SplFileinfo() : classe prédéfinie pour le traitement des fichiers uploadé
        $fichier = new SplFileInfo($_FILES['photo']['name']);
        
        // on stock l'extension du fichier dans êxt grace à la méthode getExtension qui permet de récupérer l'extension de l'image
        $ext = strtolower($fichier->getExtension());
        //echo $ext. '<hr>';

        //array_search(): fonction prédéfinie permettant de trouver à quel position d'une élément dans un tableau ARRAY, à quel indice se trouve un élément dans un tableau ARRAY 
        $positionExt = array_search($ext, $listExt);
        //echo $positionExt. '<hr>';
        //var_dump(positionEXT)

        //si l'extension n'est pas trouvé dans un tableau ARRAY, on envoie un message d'erreur 
        if($positionExt == false)
        {
            $errorUpload .='<p class="font-italic text-danger">Type de fichier non autorisé</p>';
        }
        else{
            // on renomme l'image avec la référence concaténé avec le nom du fichier 
            // on remplace les espaces par des tirets dans la référence (str_replace())
            $nomphoto = str_replace(' ','-',$reference) . '-' . $_FILES['photo']['name'];
            //echo $nomphoto . '<hr>';

            //definition URL de l'image stockée en BDD
            $photoBdd = URL . "photo/$nomphoto";
            //echo $photoBdd . '<hr>';

            //chemin physique du dossier ou l'image est stocké
            $photoDossier = RACINE_SITE . "photo/$nomphoto";
            //echo $photoDossier . '<hr>';

            //copy() : fonction prédéfinie permettant de copier l'image dans le bon dossier 
            //2 parametre : le nom temporaire de l'image et le chemin physique complet de l'image
            copy($_FILES['photo']['tmp_name'], $photoDossier);

        }
    }
    elseif(isset($_GET['action']) && $_GET['action'] == 'ajout' && empty($_FILES['photo']['name']))
    { 
        $errorUpload .= '<p class="font-italic text-danger">Merci d\'uploader une image </p>';
        $error = true; 
    }
    if (!isset($error))
    {

        if(isset($_GET['action']) && $_GET['action'] == 'ajout')
        {
        //requete d'insertion  ENREGISTREMENT PRODUIT   
        $insert = $bdd->prepare("INSERT INTO salle (titre, description, photo, pays, ville, adresse, cp, capacite, categorie,) VALUES (:titre, :description, :photo, :pays, :ville, :adresse, :cp, :capacite, :categorie,)");
        

        $_GET['action'] = 'affichage'; // Redéfini l'indice action en affichage pour qu'aprés modification du produit on revienne a l'affichage des produits 

        $validInsert = '<p class="col-md-6 p-3 rounded bg-success mx-auto text-white text-center">Le produit <strong>' . $reference . '</strong> à bien été enregistré </p>';
        }
        else{
            //requete d'update MODIFICATION PRODUIT
            $insert = $bdd->prepare("UPDATE produit SET titre =:titre , description =:description , photo=:photo , pays=:pays , ville=:ville , adresse=:adresse , cp =:cp , capacite =:capacite , categorie=:categorie WHERE id_salle=:id_salle");
            $insert->bindValue(':id_salle',$_GET['id_salle'], PDO::PARAM_INT);
            
            $_GET['action'] = 'affichage';
            $validUpdate = '<p class="col-md-6 p-3 rounded bg-success mx-auto text-white text-center">Le produit <strong>' . $reference . '</strong> à bien été modifié </p>';
            
        }
        }

        $insert->bindValue(':titre',$titre, PDO::PARAM_STR);
        $insert->bindValue(':description', $description, PDO::PARAM_STR);
        $insert->bindValue(':photo',$photobdd, PDO::PARAM_STR);
        $insert->bindValue(':pays', $pays, PDO::PARAM_STR);
        $insert->bindValue(':ville', $ville, PDO::PARAM_STR);
        $insert->bindValue(':adresse', $adresse, PDO::PARAM_STR);
        $insert->bindValue(':cp', $cp, PDO::PARAM_STR);
        $insert->bindValue(':capacite', $capacite, PDO::PARAM_STR);
        $insert->bindValue(':categorie', $categorie, PDO::PARAM_INT);

        $insert->execute();

        
        
    }



require_once('../inc/header.inc.php');
?>

<!-- AFFICHAGE LIENS MENU PRODUIT -->
<div><p class="col-md-4 offset-md-4 bg-secondary text-center rounded text-white mt-2 p-3">BACKOFFICE</p></div>
<div><a href="?action=affichage" class="col-md-4 offset-md-4 btn btn-info p-2 mb-1 mt-3">AFFICHAGE DES SALLES</a></div>
<div><a href="?action=ajout" class="col-md-4 offset-md-4 btn btn-info p-2 my-1">AJOUTER UNE SALLE</a></div>



<!--001 Si l'indice 'action' est définit dans l'URL et a pour valeur 'affichage', alors on entre dans la condition et on execute le code de l'affichage des produits, on entre dans le IF seulement dans le cas ou l'on a cliqué sur le lien 'AFFICHAGE DES PRODUITS' (ci dessus) -->
<?php if(isset($_GET['action']) && $_GET['action'] == 'affichage'): ?>

<!--Requete de selection produit-->
<?php $data = $bdd ->query("SELECT * FROM salle ORDER BY id_salle"); ?>




<!--------------- AFFICHAGE PRODUIT--------------------->

<?php if(isset($validsupp)) echo $validsupp ?>

<h3 class="display-4 text-center mt-2">Les salles</h3>

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
                <td><a href="?action=modification&id_produit=<?=$products['id_salle']?>" class="btn btn-dark"> Modifier</a></td>
                <td><a href="?action=suppression&id_produit=<?=$products['id_salle']?>" class="btn btn-danger"> Supprimer</a></td>

    </tr>
        <?php endwhile; ?>

</table>
<!------------------FIN AFFICHAGE PRODUIT------------------->
<!--Balise de fermeture de la condition d'affichage 001-->
<?php endif; ?>


<!--Condition d'affichage du formulaire 002  la valeur "ajout" est defini dans les liens AFFICHAGE LIENS MENU PRODUIT
si il y a action et ajout dans L'URL on lance le formulaire OU si dans l'url il y a action et modification on lance le meme formulaire-->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')): 
    
    if(isset($_GET['id_salle']))
    {
        $data = $bdd->prepare("SELECT * FROM salle WHERE id_salle = :id_salle");
        $data->bindValue(':id_salle', $_GET['id_salle'], PDO::PARAM_INT);
        $data->execute();

        $produitactuel = $data->fetch(PDO::FETCH_ASSOC);



        foreach($produitactuel as $key => $value)
        {
            $$key = (isset($produitactuel["$key"])) ? $produitactuel["$key"] : '';

        }
    }    


?>

<!---
Formulaire table salle 
--->

<h3 class="display-4 text-center mt-2"><?= ucfirst($_GET['action']) ?> Salles</h3>
<form class="container" action="#" method="POST" enctype="multipart/form-data" style="margin-top:35px; margin-bottom:35px;">
<?php if (isset($validInsert)) echo $validInsert ?>
    

        <div class="form-group">        
        <label style="margin-top:20px" for="reference" >Reference</label>
        <input type="text" class="form-control" id="reference" placeholder="reference" name="reference" minlength=2 value="<?php if(isset($reference)) echo ("$reference") ?> ">
        </div>    
      

        <div class="form-group">    
        <label style="margin-top:20px" for="categorie">Categorie :</label>
        <input type="text" class="form-control" id="categorie" placeholder="categorie" name="categorie" minlength=2 value="<?php if(isset($categorie)) echo ("$categorie") ?> ">
        </div>

        <div class="form-group">    
        <label for="titre" style="margin-top:20px">Titre :</label>
        <input type="text" class="form-control" id="titre" placeholder="titre" name=titre minlength=2 value="<?php if(isset($titre)) echo ("$titre") ?> ">
        </div>

        <div class="form-group">    
        <label for="description" style="margin-top:20px">description</label>
        <input type="text" class="form-control" id="description" placeholder="description" name="description" value="<?php if(isset($description)) echo ("$description") ?> ">
        </div>

        <div class="form-group">    
        <label for="couleur" style="margin-top:20px">Couleur</label>
        <input type="text" class="form-control" id="couleur" placeholder="couleur" name="couleur" value="<?php if(isset($couleur)) echo ("$couleur") ?> ">
        </div>

        <div class="form-group">        
        <label for="taille" style="margin-top:20px">Taille</label>
        <select id="taille" name="taille" class="form-control">
            <option value="S" <?php if(isset($taille) && $taille == "S") echo 'selected'?>>S</option>
            <option value="M"  <?php if(isset($taille) && $taille == "M") echo 'selected'?>> M</option>
            <option value="L"  <?php if(isset($taille) && $taille == "L") echo 'selected'?>> L</option>
            <option value="XL"  <?php if(isset($taille) && $taille == "XL") echo 'selected'?>> XL</option>
        </select>
        </div>

        <div class="form-group">        
        <label for="public" style="margin-top:20px">public</label>
        <select id="public" name="public" class="form-control">
            <option value="m" <?php if(isset($public) && $public == "m") echo 'selected'?>>Homme</option>
            <option value="f"  <?php if(isset($public) && $public == "f") echo 'selected'?>> >femme</option>
        </select>
        </div>

        <div class="form-group" style="margin-top:20px">
        <label for="photo" style="margin-top:20px">Photo:</label>
        <input type="file" id="photo" name="photo" accept="image/png, image/jpeg">
        <?php if(isset($errorUpload)) echo $errorUpload ?>
        </div>

        <?php if(isset($photo) && !empty($photo)): ?>
            <div class="text-center">
            <em>Vous pouvez uploader une nouvelle photo si vous souhaitez la changer<em><br>
            <img src="<?= $photo?>" alt="<?= $titre ?>" class=" col-md-3 mx-auto">
            </div>
        <?php endif; ?>

        <input type="hidden" name="photo_actuelle" value="<?php if(isset($photo)) echo $photo?>">

        <div class="form-group">        
        <label for="prix" style="margin-top:20px">Prix</label>
        <input type="text"  class="form-control" id="prix" placeholder="prix" name="prix" value="<?php if(isset($prix)) echo ("$prix") ?> ">
        </div>    

        <div class="form-group">    
        <label for="stock" style="margin-top:20px">Stock</label>
        <input type="text"  class="form-control" id="stock" placeholder="stock" name="stock" value="<?php if(isset($stock)) echo ("$stock") ?> ">
        </div>

        <button type="submit" class="btn btn-primary" style="margin:5px 0px 0px 0px"><?= ucfirst($_GET['action']) ?> Produit</button>

</form>


</main>
<?php 
//fin de la condition d'affichage du formulaire 002
endif;
require_once('../inc/footer.inc.php');

