<?php
require_once('../inc/init.inc.php');

//Si l'internaute n'est pas admin ou pas connecté il n'a rien à faire sur cette page, on le redirige vers la page connexion 
if(!connecteAdmin())
{
    header('Location:' . URL . 'connexion.php' );
}

//----------------------SUPPRESSION COMMANDE 
if (isset($_GET['action']) && $_GET['action'] == 'suppression')
{
    //requete de suppression préparé
    $supp = $bdd->prepare("DELETE FROM commande WHERE id_commande = :id_commande");
    $supp->bindValue(':id_commande',$_GET['id_commande'], PDO::PARAM_INT);
    // on envoie l'id_avis récupéré dans l'URL dans le marqueur :id_commande
    $supp->execute();

    $_GET['action'] = 'affichage' ; 

    $validsupp = "<p class='col-md-6 p-3 rounded bg-success mx-auto text-white text-center'>La commande <strong>ID $_GET[id_commande]</strong> a bien été supprimé </p>";
}

require_once('../inc/header.inc.php');
?>
<!-- AFFICHAGE LIEN MENU GESTION COMMANDE -->
<div><p class="col-md-4 offset-md-4 bg-secondary text-center rounded text-white mt-2 p-3">BACKOFFICE</p></div>
<div><a href="?action=affichage" class="col-md-4 offset-md-4 btn btn-info p-2 mb-1 mt-3">AFFICHAGE DES COMMANDES</a></div>



<!--001 Si l'indice 'action' est définit dans l'URL et à pour valeur 'affichage', alors on entre dans la condition et on execute le code de l'affichage des commandes, 
on entre dans le IF seulement dans le cas ou l'on a cliqué sur le lien 'AFFICHAGE DES COMMANDES' (ci dessus) -->


    <!--Requete de selection des commandes-->
    <?php $data = $bdd ->query("SELECT *
    FROM commande
    ORDER BY commande.date_enregistrement"); ?>

    <!--------------- AFFICHAGE DES COMMANDES--------------------->

    <?php if(isset($validsupp)) echo $validsupp ?>

    <h3 class="display-4 text-center mt-2">Les commandes</h3>
    <?php
    if(isset($validDelete)) echo $validDelete;
    if(isset($validInsert)) echo $validInsert;
    if(isset($validUpdate)) echo $validUpdate; 
    ?>
    <div class="container col-12 overflow-auto">
        <table  id="opentable" class="table table-striped table-bordered text-center" style="width:100%">
            <thead>
                <tr>
                    <?php 
                    //columnCount() : méthode PDOStatement qui retourne le nombre de colonne selectionné dans la requete SELECT
                            for ($i = 0; $i < $data->columnCount(); $i++):
                                //getColumnMeta() : permet de recolter les informations liés aux champs/colonne de la table (primary key, not null, nom du champs..)
                            $colonne = $data->getColumnMeta($i) 
                    ?>
                    <th><?= $colonne['name'] // on va crocheter à l'indice 'name' afin d'afficher chaque nom de colonne dans les entetes du tableau?></th>
                    <?php endfor; ?>
                    <th>Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <!--On associe la méthode fetch à l'objet PDOStatement, ce qui retourne un ARRAY d'un produit par tour de boucle WHILE-->
                <?php while($products = $data->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                    <!--La boucle foreach passe en revue chaque tableau ARRAY de chaque produits-->
                    <?php foreach($products as $key => $value): ?>
                        <td><?= $value ?></td>
                    <?php endforeach; ?>
                    <!--On créer un lien 'suppression' pour chaque produits en envoyant l'id_avis dans l'URL-->
                            <td><a href="?action=suppression&id_commande=<?=$products['id_commande']?>" class="btn btn-danger"> Supprimer</a></td>
                    </tr>
                    <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <!------------------FIN AFFICHAGE DES COMMANDES------------------->
    <!--Balise de fermeture de la condition d'affichage 001-->


</main>
<?php 
require_once('../inc/footer.inc.php');