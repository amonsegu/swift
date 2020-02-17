<?php 
//------- CONNEXION BDD
$bdd = new PDO('mysql:host=localhost;dbname=swift', 'root', '', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));

//------- SESSION
session_start();

//------- CONSTANTE
define("RACINE_SITE", $_SERVER['DOCUMENT_ROOT'] . '/swift/');
// cette constante retourne le chemin physique du dossier boutique sur le serveur, lors de l'ulpoad d'images, nous aurons besoin du chemin complet vers le dossier photo pour enregistrer la photo
// echo RACINE_SITE . '<hr>';

define("URL", "http://localhost/swift/");
// cette constante servira par exemple à enregistrer l'URL d'une image dans la BDD, on ne conserve pas l'image dans le BDD, ce serait trop lour pour le serveur 

//------- FAILLES XSS 
foreach($_POST as $key => $value)
{
    $_POST[$key] = strip_tags($value);
}

//------- INCULSIONS 
require_once("fonction.inc.php"); 