<?php 
//----------- FONCTION CONNECTE 
// fonction permettant de savoir si l'utilisatueur est connecté ou pas
function connect()
{
    // la l'indice 'membre' dans la session n'est pas définit, cela veut dire que l'internaute ne s'est pas connecté et peut-être ne s'est pas inscrit
    if(!isset($_SESSION['membre']))
    {
        return false;
    }
    else // sinon l'indice 'membre' est définit, l'internaute est connecté
    {
        return true;
    }
}

//---------- FONCTION CONNECTE ET ADMIN
// fonction permettant de savoir si l'internaute est connecté et est administrateur du site
function connecteAdmin()
{
    // Si l'internaute est connecté et que l'indice 'statut' de la session a pour valeur '1', cela veut dire que l'internaute est admin
    if(connect() && $_SESSION['membre']['statut'] == 1)
    {
        return true;
    }
    else // sinon l'internaute n'est pas admin et peut-être pas connecté
    {
        return false;
    }
}

//-----------------------------------------
// Fonction pour créer le panier

// Les informations du panier ne sont pas conservés en BDD, nous les stockons directement dans la session de l'utilisateur
function creationPanier()
{
    // Si l'indice 'panier' dans la session n'est pas définit, alors le crée
    if(!isset($_SESSION['panier']))
    {
        // On crée différent tableau array afin de stocker les informations des produits ajoutés dans le panier
        $_SESSION['panier'] = array();
        $_SESSION['panier']['titre'] = array();
        $_SESSION['panier']['id_produit'] = array();
        $_SESSION['panier']['quantite'] = array();
        $_SESSION['panier']['prix'] = array();
    }
}