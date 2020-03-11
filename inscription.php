<?php 
require_once("inc/init.inc.php");

// Si l'internaute est connecté, il n'a rien à faire sur la page inscription, on redirige l'internaute vers sa page profil
if(connect())
{
    header('Location:profil.php');
}

extract($_POST);
// echo '<pre>'; print_r($_POST); echo '</pre>';

if($_POST)
{
    // 1.Controler la disponibilité du pseudo et de l'email 
    $errorPseudo = '';
    $verif_pseudo = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
    $verif_pseudo->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
    $verif_pseudo->execute();
    if($verif_pseudo->rowCount() > 0)
    {
        $errorPseudo .= '<p class="font-italic text-danger">Ce Pseudo est déjà existant, merci d\'en saisir un nouveau.</p>';
        $error = true;
    }

    // 3.Caractères autorisés pour le pseudo [a-zA-Z0-9._-]
    if(!preg_match('#^[a-zA-Z0-9._-]{2,20}+$#', $pseudo))
    {
        $errorPseudo .= '<p class="font-italic text-danger">Caractères autorisés (entre 2 et 20) : [a-zA-Z0-9._-]</p>';
        $error = true;
    }

    $errorEmail = '';
    $verif_email = $bdd->prepare("SELECT * FROM membre WHERE email = :email");
    $verif_email->bindValue(':email', $email, PDO::PARAM_STR);
    $verif_email->execute();
    if($verif_email->rowCount() > 0)
    {
        $errorEmail .= '<p class="font-italic text-danger">Un compte existant à cette adresse. Merci de vous connecter.</p>';
        $error = true;
    }

    // 2.Controler la validité de l'email (fonction prédéfinie)
    if(!filter_var($email, FILTER_VALIDATE_EMAIL))
    {   
        $errorEmail .= '<p class="font-italic text-danger">Email format invalide</p>';
        $error = true;
    }

    // 4.Informer l'internaute si les mots de passe ne correspondent pas
    if($mdp !== $mdp_confirm)
    {
        $errorMdp = '<p class="font-italic text-danger">Vérifier les mots de passe</p>';
        $error = true;
    }
    
    // 5.Si l'internaute a correctement rempli le formulaire, on execute le requete d'insertion
    if(!isset($error))
    {
        $mdp = password_hash($mdp, PASSWORD_DEFAULT);
        // on ne conserve jamais les mots de passe en clair dans la BDD
        // password_hash() : fonction prédéfinie permettant de créer un clé de hachage à partir d'une chaine de caractères

        $insert = $bdd->prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite,statut,date_enregistrement) VALUES (:pseudo, :mdp, :nom, :prenom, :email, :civilite,0, now())");

        $insert->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
        $insert->bindValue(':mdp', $mdp, PDO::PARAM_STR);
        $insert->bindValue(':nom', $nom, PDO::PARAM_STR);
        $insert->bindValue(':prenom', $prenom, PDO::PARAM_STR);
        $insert->bindValue(':email', $email, PDO::PARAM_STR);
        $insert->bindValue(':civilite', $civilite, PDO::PARAM_STR);

        $insert->execute();

        header('Location:connexion.php?inscription=valid'); // aprés l'inscription, on redirige l'internaute vers la page connexion
        //var_dump($_POST);
    }
}
    
require_once("inc/header.inc.php");
?>

<!-- Réaliser un formulaire HTML correspondant à la table 'membre' (sauf ID et statut) + champs 'confirmer mot de passe' -->


<h1 class="display-4 text-center mt-2">Inscription</h1><hr>
<div class="container col-5 justify-content-center">
    <form method="post">

        <div class="form-group">
        <label for="civilite">Civilité</label>
        <select id="civilite" name="civilite" class="form-control">
            <option value="f">Madame</option>
            <option value="m">Monsieur</option>
        </select>
        </div>
      
        <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom">
        </div>

        <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom">
        </div>

        <div class="form-group ">
        <label for="pseudo">Pseudo</label>
        <input type="text" class="form-control" id="pseudo" name="pseudo">
        <?php if(isset($errorPseudo)) echo $errorPseudo ?>
        </div>


        <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email">
        <?php if(isset($errorEmail)) echo $errorEmail ?>
        </div>


        <div class="form-group ">
        <label for="mdp">Mot de passe</label>
        <input type="password" class="form-control" id="mdp" name="mdp">
        <?php if(isset($errorMdp)) echo $errorMdp ?>
        </div>

        <div class="form-group ">
        <label for="mdp_confirm">Confirmer mot de passe</label>
        <input type="password" class="form-control" id="mdp_confirm" name="mdp_confirm">
        </div>

    <div class="text-center">
    <button type="submit" class="btn btn-info">Inscription</button>
    </div>

    </form>
</div>

<?php 
require_once("inc/footer.inc.php");