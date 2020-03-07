<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
    <link href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" rel="stylesheet" >
    <title>Swift location bureau & salle</title>
</head>
<body style="height:100%">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Swift</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample04" aria-controls="navbarsExample04" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExample04">
        <ul class="navbar-nav mr-auto">

        <?php if(connect()): // accés membre connecté ?>

            <?php 
            if(isset($_SESSION['panier']))
                $nbProduct = array_sum($_SESSION['panier']['quantite']);
            else
                $nbProduct = 0;
            ?>

            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>profil.php">Profil</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>boutique.php">Boutique</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>panier.php">Panier <span class="badge badge-info"><?= $nbProduct ?></span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>connexion.php?action=deconnexion">Deconnexion</a>
            </li>
        
        <?php else: // visiteur non connécté et non inscrit ?>

            <?php 
            if(isset($_SESSION['panier']))
                $nbProduct = array_sum($_SESSION['panier']['quantite']);
            else
                $nbProduct = 0;
            ?>

            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>inscription.php">Inscription</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>connexion.php">Connexion</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>boutique.php">Boutique</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="<?= URL ?>panier.php">Panier <span class="badge badge-info"><?= $nbProduct ?></span></a>
            </li>

        <?php endif; ?>

        <?php if(connecteAdmin()): // accés administrateur ?>

            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="dropdown04" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administration</a>
                <div class="dropdown-menu" aria-labelledby="dropdown04">
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_salle.php">Gestion salle</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_produit.php">Gestion Produit</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_membre.php">Gestion Membre</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_avis.php">Gestion Avis</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_commande.php">Gestion Commande</a>
                <a class="dropdown-item" href="<?= URL ?>admin/gestion_statistique.php">Gestion Statistique</a>
                </div>
            </li>

        <?php endif; ?>

        </ul>
    </div>
    </nav>
    <main class="container-fluid" style="min-height:890px">