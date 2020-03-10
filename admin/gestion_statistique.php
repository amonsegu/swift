<?php
require_once('../inc/init.inc.php');

//Si l'internaute n'est pas admin ou pas connecté il n'a rien à faire sur cette page, on le redirige vers la page connexion 
if(!connecteAdmin())
{
    header('Location:' . URL . 'connexion.php' );
}


require_once('../inc/header.inc.php');
?>

<!-- AFFICHAGE LIEN MENU STATISTIQUES -->
<div><p class="col-md-4 offset-md-4 bg-secondary text-center rounded text-white mt-2 p-3">BACKOFFICE</p></div>
<div><a href="?action=affichage" class="col-md-4 offset-md-4 btn btn-info p-2 mb-1 mt-3">AFFICHAGE DES STATISTIQUES</a></div>




<!--001 Si l'indice 'action' est définit dans l'URL et à pour valeur 'affichage', alors on entre dans la condition et on execute le code de l'affichage des statistiques, 
on entre dans le IF seulement dans le cas ou l'on a cliqué sur le lien 'AFFICHAGE DES STATISTIQUES' (ci dessus) -->
<?php if(isset($_GET['action']) && $_GET['action'] == 'affichage'): ?>

<!--Requete de selection statistiques 5 meilleurs salles-->
<?php 

$dataSalle = $bdd ->query("SELECT id_produit, COUNT(id_produit) AS nombre_de_commande
FROM commande
GROUP BY id_produit ORDER BY COUNT(id_produit) DESC LIMIT 5"); 
$products = $dataSalle->fetchALL(PDO::FETCH_NUM);
$nom1 = (int)$products[0][0];
$commande1 = (int)$products[0][1];
$nom2 = (int)$products[1][0];
$commande2 = (int)$products[1][1];
$nom3 = (int)$products[2][0];
$commande3 = (int)$products[2][1];
$nom4 = (int)$products[3][0];
$commande4 = (int)$products[3][1];
$nom5 = (int)$products[4][0];
$commande5 = (int)$products[4][1];


$dataSalle2 = $bdd ->query("SELECT salle.titre, salle.id_salle
FROM salle
LEFT JOIN produit
ON  salle.id_salle=produit.id_salle
WHERE produit.id_produit LIKE '$nom1' "); 
$test1 = $dataSalle2->fetch(PDO::FETCH_ASSOC);

$dataSalle3 = $bdd ->query("SELECT salle.titre, salle.id_salle
FROM salle
LEFT JOIN produit
ON  salle.id_salle=produit.id_salle
WHERE produit.id_produit LIKE '$nom2' "); 
$test2 = $dataSalle3->fetch(PDO::FETCH_ASSOC);

$dataSalle4 = $bdd ->query("SELECT salle.titre, salle.id_salle
FROM salle
LEFT JOIN produit
ON  salle.id_salle=produit.id_salle
WHERE produit.id_produit LIKE '$nom3' "); 
$test3 = $dataSalle4->fetch(PDO::FETCH_ASSOC);

$dataSalle5 = $bdd ->query("SELECT salle.titre, salle.id_salle
FROM salle
LEFT JOIN produit
ON  salle.id_salle=produit.id_salle
WHERE produit.id_produit LIKE '$nom4' "); 
$test4 = $dataSalle5->fetch(PDO::FETCH_ASSOC);

$dataSalle6 = $bdd ->query("SELECT salle.titre, salle.id_salle
FROM salle
LEFT JOIN produit
ON  salle.id_salle=produit.id_salle
WHERE produit.id_produit LIKE '$nom5' "); 
$test5 = $dataSalle6->fetch(PDO::FETCH_ASSOC);
//REQUETE DE SELECTION STAT MEILLEURS NOTES



?>


<!--Affichage tableau row 1-->
<div class="container mt-3">
<div class="row">
    <div class="col-sm">
        <h4 class="text-center">Vos 5 salles les plus commandées</h4>
        <table class="table table-hover border">
        <thead class="thead-dark">
            <tr class="text-center">
            <th scope="col">Place</th>
            <th scope="col">Nom de la salle</th>
            <th scope="col">id de la salle</th>
            <th scope="col">Nombre de Commandes</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
            <th scope="row">1</th>
            <td><?php echo "$test1[titre]" ?></td>
            <td><?php echo "$test1[id_salle]" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$commande1" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">2</th>
            <td><?php echo "$test2[titre]" ?></td>
            <td><?php echo "$test2[id_salle]" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$commande2" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">3</th>
            <td><?php echo "$test3[titre]" ?></td>
            <td><?php echo "$test3[id_salle]" ?></td>
            <td><span class="badge badge-info p-2"><?php echo "$commande3" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">4</th>
            <td><?php echo "$test4[titre]" ?></td>
            <td><?php echo "$test4[id_salle]" ?></td>
            <td><span class="badge badge-warning p-2"><?php echo "$commande4" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">5</th>
            <td><?php echo "$test5[titre]" ?></td>
            <td><?php echo "$test5[id_salle]" ?></td>
            <td><span class="badge badge-danger p-2"><?php echo "$commande5" ?></span></td>
            </tr>
        </tbody>
        </table>
    </div>

<!--REQUETE DE SELECTION STAT MEILLEURS NOTES-->
<?php 

$dataSalle2 = $bdd ->query("SELECT avis.id_salle, AVG(avis.note) , salle.titre
FROM avis
LEFT JOIN salle
ON avis.id_salle = salle.id_salle
GROUP BY avis.id_salle ORDER BY AVG(note) DESC LIMIT 5"); 
$products2 = $dataSalle2->fetchALL(PDO::FETCH_NUM);

$idMnote1 = (string)$products2[0][0];
$noteMnote1 = (int)$products2[0][1];
$nomMnote1 = (string)$products2[0][2];

$idMnote2 = (string)$products2[1][0];
$noteMnote2 = (int)$products2[1][1];
$nomMnote2 = (string)$products2[1][2];

$idMnote3 = (string)$products2[2][0];
$noteMnote3 = (int)$products2[2][1];
$nomMnote3 = (string)$products2[2][2];

$idMnote4 = (string)$products2[3][0];
$noteMnote4 = (int)$products2[3][1];
$nomMnote4 = (string)$products2[3][2];

$idMnote5 = (string)$products2[4][0];
$noteMnote5 = (int)$products2[4][1];
$nomMnote5 = (string)$products2[4][2];

?>



    <div class="col-sm">
        <h4 class="text-center">Les 5 salles les mieux notées</h4>
        <table class="table table-hover border">
        <thead class="thead-dark">
            <tr class="text-center">
            <th scope="col">Place</th>
            <th scope="col">Nom de la salle</th>
            <th scope="col">id de la salle</th>
            <th scope="col">Note</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
            <th scope="row">1</th>
            <td><?php echo "$nomMnote1" ?></td>
            <td><?php echo "$idMnote1" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$noteMnote1" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">2</th>
            <td><?php echo "$nomMnote2" ?></td>
            <td><?php echo "$idMnote2" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$noteMnote2" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">3</th>
            <td><?php echo "$nomMnote3" ?></td>
            <td><?php echo "$idMnote3" ?></td>
            <td><span class="badge badge-info p-2"><?php echo "$noteMnote3" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">4</th>
            <td><?php echo "$nomMnote4" ?></td>
            <td><?php echo "$idMnote4" ?></td>
            <td><span class="badge badge-warning p-2"><?php echo "$noteMnote4" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">5</th>
            <td><?php echo "$nomMnote5" ?></td>
            <td><?php echo "$idMnote5" ?></td>
            <td><span class="badge badge-danger p-2"><?php echo "$noteMnote5" ?></span></td>
            </tr>
        </tbody>
        </table>
    </div>
</div>
</div>
<!--Affichage tableau row 1-->

<!--Requete SELECTION MEMBRE QUI ONT LE PLUS COMMANDES-->
<?php 
$dataSalle3 = $bdd ->query("SELECT membre.id_membre, COUNT(commande.id_membre) , membre.pseudo
FROM membre
LEFT JOIN commande
ON membre.id_membre = commande.id_membre
GROUP BY membre.id_membre ORDER BY COUNT(commande.id_membre) DESC LIMIT 5"); 
$products3 = $dataSalle3->fetchALL(PDO::FETCH_NUM);

$idMembrePC1 = (string)$products3[0][0];
$noteMemnbrePC1 = (int)$products3[0][1];
$nomMembrePC1 = (string)$products3[0][2];

$idMembrePC2 = (string)$products3[1][0];
$noteMemnbrePC2 = (int)$products3[1][1];
$nomMembrePC2 = (string)$products3[1][2];

$idMembrePC3 = (string)$products3[2][0];
$noteMemnbrePC3 = (int)$products3[2][1];
$nomMembrePC3 = (string)$products3[2][2];

$idMembrePC4 = (string)$products3[3][0];
$noteMemnbrePC4 = (int)$products3[3][1];
$nomMembrePC4 = (string)$products3[3][2];

$idMembrePC5 = (string)$products3[4][0];
$noteMemnbrePC5 = (int)$products3[4][1];
$nomMembrePC5 = (string)$products3[4][2];

?>


<!--Affichage tableau row 2-->
<div class="container mt-3">
<div class="row">
    <div class="col-sm">
        <h4 class="text-center">TOP 5 des membres qui ont le plus commandés</h4>
        <table class="table table-hover border">
        <thead class="thead-dark">
            <tr class="text-center">
            <th scope="col">Place</th>
            <th scope="col">id</th>
            <th scope="col">Nom </th>
            <th scope="col">Nombre </th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
            <th scope="row">1</th>
            <td><?php echo "$idMembrePC1" ?></td>
            <td><?php echo "$nomMembrePC1" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$noteMemnbrePC1" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">2</th>
            <td><?php echo "$idMembrePC2" ?></td>
            <td><?php echo "$nomMembrePC2" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$noteMemnbrePC2" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">3</th>
            <td><?php echo "$idMembrePC3" ?></td>
            <td><?php echo "$nomMembrePC3" ?></td>
            <td><span class="badge badge-info p-2"><?php echo "$noteMemnbrePC3" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">4</th>
            <td><?php echo "$idMembrePC4" ?></td>
            <td><?php echo "$nomMembrePC4" ?></td>
            <td><span class="badge badge-warning p-2"><?php echo "$noteMemnbrePC4" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">5</th>
            <td><?php echo "$idMembrePC5" ?></td>
            <td><?php echo "$nomMembrePC5" ?></td>
            <td><span class="badge badge-danger p-2"><?php echo "$noteMemnbrePC5" ?></span></td>
            </tr>
        </tbody>
        </table>
    </div>




<?php 
$dataSalle4 = $bdd ->query("SELECT membre.pseudo,  SUM(produit.prix)
FROM commande
LEFT JOIN produit
ON commande.id_produit = produit.id_produit
LEFT JOIN membre
ON commande.id_membre = membre.id_membre
GROUP BY commande.id_membre ORDER BY SUM(produit.prix) DESC LIMIT 5"); 
$products5 = $dataSalle4->fetchALL(PDO::FETCH_NUM);

$pseudoDepense1 = (string)$products5[0][0];
$montantDepense1 = (int)$products5[0][1];

$pseudoDepense2 = (string)$products5[1][0];
$montantDepense2 = (int)$products5[1][1];

$pseudoDepense3 = (string)$products5[2][0];
$montantDepense3 = (int)$products5[2][1];

$pseudoDepense4 = (string)$products5[3][0];
$montantDepense4 = (int)$products5[3][1];

$pseudoDepense5 = (string)$products5[4][0];
$montantDepense5 = (int)$products5[4][1];

?>












    <div class="col-sm">
        <h4 class="text-center">TOP 5 des membres qui dépensent le plus</h4>
        <table class="table table-hover border">
        <thead class="thead-dark">
            <tr class="text-center">
            <th scope="col">Place</th>
            <th scope="col">Pseudo</th>
            <th scope="col">Montant</th>
            </tr>
        </thead>
        <tbody>
            <tr class="text-center">
            <th scope="row">1</th>
            <td><?php echo "$pseudoDepense1" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$montantDepense1" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">2</th>
            <td><?php echo "$pseudoDepense2" ?></td>
            <td><span class="badge badge-success p-2"><?php echo "$montantDepense2" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">3</th>
            <td><?php echo "$pseudoDepense3" ?></td>
            <td><span class="badge badge-info p-2"><?php echo "$montantDepense3" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">4</th>
            <td><?php echo "$pseudoDepense4" ?></td>
            <td><span class="badge badge-warning p-2"><?php echo "$montantDepense4" ?></span></td>
            </tr>
            <tr class="text-center">
            <th scope="row">5</th>
            <td><?php echo "$pseudoDepense5" ?></td>
            <td><span class="badge badge-danger p-2"><?php echo "$montantDepense5" ?></span></td>
            </tr>
        </tbody>
        </table>
    </div>
</div>
</div>
<!--Affichage tableau row 2-->









<!------------------FIN AFFICHAGE AVIS------------------->
<!--Balise de fermeture de la condition d'affichage 001-->
<?php endif; ?>
</main>




<?php 
require_once('../inc/footer.inc.php');