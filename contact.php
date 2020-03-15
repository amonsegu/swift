<?php
require_once("inc/init.inc.php");
require_once("inc/header.inc.php");
 
 if($_POST){
    $message=$_POST["message"];
    $sujet=$_POST["sujet"];
    $nom=$_POST["nom"];
    $prenom=$_POST["prenom"];
    $email=$_POST["email"];
 
    $from = "contact@bottinvar.fr";
 
    $to = "a.monsegu95170@gmail.com";
 
    $subject = $sujet;
 
    $message = $email . $message;
 
    $headers = "From:" . $from;
 
    mail($to,$subject,$message, $headers);
 
    echo '<div class="alert alert-success col-5 text-center">Email envoyé</div></div>';
 }


?>

<div class="container col-5 justify-content-center">
<h1 style="text-align:center">Contactez nous !</h1>
<form method="post">

      
        <div class="form-group">
        <label for="nom">Nom</label>
        <input type="text" class="form-control" id="nom" name="nom">
        </div>

        <div class="form-group">
        <label for="prenom">Prénom</label>
        <input type="text" class="form-control" id="prenom" name="prenom">
        </div>
        
        <div class="form-group">
        <label for="sujet">Sujet</label>
        <input type="text" class="form-control" id="sujet" name="sujet">
        </div>

        <div class="form-group">
        <label for="message">Message</label>
        <input type="text-area" class="form-control" id="message" name="message">
        </div>


        <div class="form-group">
        <label for="email">Email</label>
        <input type="text" class="form-control" id="email" name="email">
        </div>


    <div class="text-center">
    <button type="submit" class="btn btn-info">Envoyer</button>
    </div>

    </form>
</div>

<?php 
require_once("inc/footer.inc.php");