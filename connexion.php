<?php 
require_once('inc/init.inc.php');

// Nous entrons dans la condition IF seulement dans le cas où l'internaute clique sur le lien deconnexion
if(isset($_GET['action']) && $_GET['action'] == 'deconnexion')
{
    session_destroy(); // on supprime le fichier session
}

// Si l'internaute est connecté, il n'a rien à faire sur la page connexion, on redirige l'internaute vers sa page profil
if(connect())
{
    header('Location:profil.php');
}

if(isset($_GET['inscription']) && $_GET['inscription'] == 'valid')
{
    $inscriptionValid = "<p class='bg-success rounded col-md-5 text-white mx-auto text-center p-2 mt-2'>Vous êtes maintenant inscrit, vous pouvez dès à présent vous connecter !</p>";
}

if($_POST)
{
    extract($_POST);
    $ErrorConnect = '';

    // On selectionne tout dans la BDD à condition que le champs email ou pseudo soit égal à ce que l'internaute a saisie dans le formulaire
    $data = $bdd->prepare("SELECT * FROM membre WHERE pseudo = :pseudo || email = :email");
    $data->bindValue(':pseudo', $email_pseudo, PDO::PARAM_STR);
    $data->bindValue(':email', $email_pseudo, PDO::PARAM_STR);
    $data->execute();

    // si la requete retourne au moins 1 résultat, cela veut dire que le pseudo ou l'email est connu en BDD
    if($data->rowCount() > 0)
    {
        // echo 'pseudo ou email valid';
        // On récupère les données de l'internaute qui a saisi le bon pseudo ou email afin de controler le mot de passe
        $membre = $data->fetch(PDO::FETCH_ASSOC);
        // echo '<pre>'; print_r($membre); echo '</pre>';
        // $mdp == $membre['mdp']
        // password_verify() : fonction prédéfinie permettant de comparer un clé de hachage à une chaine de caractères
        if(password_verify($mdp, $membre['mdp']))
        {
            // echo 'mot de passe OK';
            // on passe en revue les données de l'utilisateur connecté afin de les stocker dans son fichier session
            foreach($membre as $key => $value)
            {
                if($key != 'mdp') // on exclu le mot de passe qui n'est pas conservé dans le fichier session
                {
                    $_SESSION['membre'][$key] = $value; // on créer un indice 'membre' dans le fichier session dans lequel on stock les données de l'utilisateur connecté
                }
            }
            // echo '<pre>'; print_r($_SESSION); echo '</pre>';
            header('Location:profil.php');
        }
        else
        {
            $ErrorConnect .= "<p class='bg-danger rounded col-md-5 text-white mx-auto text-center p-3 mt-2'>Identifiants incorrect</p>";
        }

    }
    else // sinon l'email ou pseudo saisie par l'internaute n'existe pas en BDD
    {
        $ErrorConnect .= "<p class='bg-danger rounded col-md-5 text-white mx-auto text-center p-3 mt-2'>Identifiants incorrect</p>";
    }
}

require_once('inc/header.inc.php');
?>

<?php if(isset($inscriptionValid)) echo $inscriptionValid; ?>

<h1 class="display-4 text-center mt-2">Connexion</h1><hr>

    <?php if(isset($ErrorConnect)) echo $ErrorConnect; ?>
    <div class="container col-5 justify-content-center bg-secondary text-white rounded p-5">
    <form method="post" class="col-md-6 mx-auto">
        <div class="form-group">
            <label for="email_pseudo">Email ou Pseudo</label>
            <input type="text" class="form-control" id="email_pseudo" name="email_pseudo">
        </div>
        <div class="form-group">
            <label for="mdp">Mot de passe</label>
            <input type="password" class="form-control" id="mdp" name="mdp">
        </div>
        <div class="text-center">
        <button type="submit" class="btn bg-info">Connexion</button>
        </div>
    </form>
</div>

<?php 
require_once('inc/footer.inc.php');