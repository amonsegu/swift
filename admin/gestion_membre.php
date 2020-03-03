<?php
require_once('../inc/init.inc.php');

//Si l'internaute n'est pas admin ou pas connecté il n'a rien à faire sur cette page, on le redirige vers la page connexion 
if(!connecteAdmin())
{
    header('Location:' . URL . 'connexion.php' );
}

//----------------------SUPPRESSION SALLE 
if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{



    //requete de suppression préparé
    $supp = $bdd->prepare("DELETE FROM membre WHERE id_membre = :id_membre");
    $supp->bindValue(':id_membre',$_GET['id_membre'], PDO::PARAM_INT);
    // on envoie l'id_produit récupéré dans l'URL dans le marqueur :id_produit
    $supp->execute();

    $_GET['action'] = 'affichage' ; 

    $validsupp = "<p class='col-md-6 p-3 rounded bg-success mx-auto text-white text-center'>Le membre <strong>ID $_GET[id_membre]</strong> a bien été supprimé </p>";



}

if($_POST)
{
    extract($_POST);
    //echo'<pre>';print_r($_FILES); echo '</pre>';


    $errorUpload = '';

    if (!isset($error))
    {

        if(isset($_GET['action']) && $_GET['action'] == 'ajout')
        {
            //requete d'insertion  ENREGISTREMENT SALLE   
            $insert = $bdd->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite,statut,date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite,0, now())");
            

            $_GET['action'] = 'affichage'; // Redéfini l'indice action en affichage pour qu'aprés modification du produit on revienne a l'affichage des produits 

            $validInsert = '<p class="col-md-6 p-3 rounded bg-success mx-auto text-white text-center">La membre <strong>' . $pseudo . '</strong> à bien été enregistré </p>';
        }
        else{
            //requete d'update MODIFICATION SALLE
            $insert = $bdd->prepare("UPDATE membre SET pseudo=:pseudo , mdp=:mdp , nom=:nom , prenom=:prenom , email=:email , civilite=:civilite WHERE id_membre=:id_membre");
            $insert->bindValue(':id_membre',$_GET['id_membre'], PDO::PARAM_INT);
            
            $_GET['action'] = 'affichage';
            $validUpdate = '<p class="col-md-6 p-3 rounded bg-success mx-auto text-white text-center">Le membre <strong>' . $pseudo . '</strong> à bien été modifié </p>';
            
        }
    }

        $insert->bindValue(':pseudo',$pseudo, PDO::PARAM_STR);
        $insert->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $insert->bindValue(':nom',$nom, PDO::PARAM_STR);
        $insert->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $insert->bindValue(':email', $email, PDO::PARAM_STR);
        $insert->bindValue(':civilite', $civilite, PDO::PARAM_STR);

        $insert->execute();

        
        //echo '<pre>'; var_dump($_POST) ;echo'</pre>';
    }



require_once('../inc/header.inc.php');
?>

<!-- AFFICHAGE LIENS MENU GESTION SALLE -->
<div><p class="col-md-4 offset-md-4 bg-secondary text-center rounded text-white mt-2 p-3">BACKOFFICE</p></div>
<div><a href="?action=affichage" class="col-md-4 offset-md-4 btn btn-info p-2 mb-1 mt-3">AFFICHAGE DES MEMBRES</a></div>
<div><a href="?action=ajout" class="col-md-4 offset-md-4 btn btn-info p-2 my-1">AJOUTER UN MEMBRE</a></div>



<!--001 Si l'indice 'action' est définit dans l'URL et a pour valeur 'affichage', alors on entre dans la condition et on execute le code de l'affichage des produits, on entre dans le IF seulement dans le cas ou l'on a cliqué sur le lien 'AFFICHAGE DES PRODUITS' (ci dessus) -->
<?php if(isset($_GET['action']) && $_GET['action'] == 'affichage'): ?>

<!--Requete de selection salle-->
<?php $data = $bdd ->query("SELECT * FROM membre ORDER BY id_membre"); ?>




<!--------------- AFFICHAGE SALLE--------------------->

<?php if(isset($validsupp)) echo $validsupp ?>

<h3 class="display-4 text-center mt-2">Les membres</h3>

<?php
if(isset($validDelete)) echo $validDelete;
if(isset($validInsert)) echo $validInsert;
if(isset($validUpdate)) echo $validUpdate; 
?>

<table class="table table-bordered text-center"><tr>
<?php 
//columnCount() : méthode PDOStatement qui retourne le nombre de colonne selectionné dans la requete SELECT
        for ($i = 0; $i < $data->columnCount(); $i++):
            //getColumnMeta() : permet de recolter les informations liés aux champs/colonne de la table (primary key, not null, nom du champs..)
        $colonne = $data->getColumnMeta($i) 
        ?>
        <th><?= $colonne['name'] // on va crocheter à l'indice 'name' afin d'afficher chaque nom de colonne dans les entetes du tableau?></th>
        <?php endfor; ?>
        <th>Edit</th>
        <th>Supp</th>
    </tr>
    <!--On associe la méthode fetch à l'objet PDOStatement, ce qui retourne un ARRAY d'un produit par tour de boucle WHILE-->
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
                <td><a href="?action=modification&id_membre=<?=$products['id_membre']?>" class="btn btn-dark"> Modifier</a></td>
                <td><a href="?action=suppression&id_membre=<?=$products['id_membre']?>" class="btn btn-danger"> Supprimer</a></td>

    </tr>
        <?php endwhile; ?>

</table>
<!------------------FIN AFFICHAGE SALLE------------------->
<!--Balise de fermeture de la condition d'affichage 001-->
<?php endif; ?>


<!--Condition d'affichage du formulaire 002  la valeur "ajout" est defini dans les liens AFFICHAGE 
si il y a action et ajout dans L'URL on lance le formulaire OU si dans l'url il y a action et modification on lance le meme formulaire-->
<?php if(isset($_GET['action']) && ($_GET['action'] == 'ajout' || $_GET['action'] == 'modification')): 
    
    if(isset($_GET['id_membre']))
    {
        $data = $bdd->prepare("SELECT * FROM membre WHERE id_membre = :id_membre");
        $data->bindValue(':id_membre', $_GET['id_membre'], PDO::PARAM_INT);
        $data->execute();

        $produitactuel = $data->fetch(PDO::FETCH_ASSOC);



        foreach($produitactuel as $key => $value)
        {
            $$key = (isset($produitactuel["$key"])) ? $produitactuel["$key"] : '';

        }
    }    


?>

<!---Formulaire table salle --->

<h3 class="display-4 text-center mt-2"><?= ucfirst($_GET['action']) ?> Membre</h3>
<form class="container" action="#" method="POST" enctype="multipart/form-data" style="margin-top:35px; margin-bottom:35px;">
<?php if (isset($validInsert)) echo $validInsert ?>
    
<!-- PSEUDO-->
        <div class="form-group">        
        <label style="margin-top:20px" for="pseudo" >Pseudo</label>
        <input type="text" class="form-control" id="pseudo" placeholder="pseudo" name="pseudo" minlength=2 value="<?php if(isset($pseudo)) echo ("$pseudo") ?> ">
        </div>    
      
<!-- MDP -->

        <div class="form-group">
        <label for="mdp">Mot de passe</label>
        <input type="password" class="form-control" id="mdp" name="mdp" value="<?php if(isset($mdp)) echo ("$mdp") ?> ">
        </div>


<!--NOM-->
        <div class="form-group">        
        <label style="margin-top:20px" for="nom" >Nom</label>
        <input type="text" class="form-control" id="nom" placeholder="nom" name="nom" minlength=2 value="<?php if(isset($nom)) echo ("$nom") ?> ">
        </div>  

<!--PRENOM-->
        <div class="form-group">        
        <label style="margin-top:20px" for="prenom" >Prenom</label>
        <input type="text" class="form-control" id="prenom" placeholder="prenom" name="prenom" minlength=2 value="<?php if(isset($prenom)) echo ("$prenom") ?> ">
        </div>   

<!--EMAIL-->
        <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($email)) echo ("$email") ?> ">
        </div>

<!-- CIVILITE-->
<div class="form-group">        
        <label for="civilite" style="margin-top:20px">CIVILITE</label>
        <select id="civilite" name="civilite" class="form-control">
            <option value="f" <?php if(isset($civilite) && $civilite == "f") echo 'selected'?>>Femme</option>
            <option value="m"  <?php if(isset($civilite) && $civilite == "m") echo 'selected'?>> Homme</option>
        </select>
        </div>




        <button type="submit" class="btn btn-primary" style="margin:5px 0px 0px 0px"><?= ucfirst($_GET['action']) ?> Membre</button>

</form>


</main>
<?php 
//fin de la condition d'affichage du formulaire 002
endif;
require_once('../inc/footer.inc.php');