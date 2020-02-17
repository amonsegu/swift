<?php 
require_once('inc/init.inc.php');

// Si l'internaute n'est pas connecté, il n'a rien à faire sur la page profil, on redirige l'internaute vers la page connexion
if(!connect())
{
    header('Location:connexion.php');
}

require_once('inc/header.inc.php');

//echo '<pre>'; print_r($_SESSION); echo '</pre>';
?>

<h1 class="display-4 text-center mt-2">Profil</h1><hr>

<table class="col-md-6 mx-auto table table-dark text-center rounded">

    <?php foreach($_SESSION['membre'] as $key => $value): ?>

        <?php if($key != 'statut' && $key != 'id_membre'): ?>

            <tr>
                <th><?= $key ?></th>
                <td><?= $value ?></td>
            </tr>

        <?php endif; ?>

    <?php endforeach; ?>
    
    <tr><td colspan="2"><a href="" class="btn btn-info">Modifier vos informations</a></td></tr>
</table>

<?php 
require_once('inc/footer.inc.php');