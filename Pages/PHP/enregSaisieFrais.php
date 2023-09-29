<?php
include 'connect_bd.php';

// Récupération des données du formulaire
$ENG_mois = $_POST['FRA_MOIS'];
$ENG_annee = $_POST['FRA_AN'];
$repas = $_POST['FRA_REPAS'];
$nuitee = $_POST['FRA_NUIT'];
$etape = $_POST['FRA_ETAP'];
$km = $_POST['FRA_KM'];
$date = $_POST['FRA_AUT_DAT1'];
$libelle = $_POST['FRA_AUT_LIB1'];
$montant = $_POST['FRA_AUT_MONT1'];

//requete sql pour insérer les données dans la base de données
$sql = "INSERT INTO `fichefrais` (`FRA_MOIS`, `FRA_AN`, `FRA_REPAS`, `FRA_NUIT`, `FRA_ETAP`, `FRA_KM`, `FRA_AUT_DAT1`, `FRA_AUT_LIB1`, `FRA_AUT_MONT1`) VALUES ('$ENG_mois', '$ENG_annee', '$repas', '$nuitee', '$etape', '$km', '$date', '$libelle', '$montant')";
//execution de la requete
$connexion->exec($sql);
//redirection vers la page d'accueil
header('Location: ../index.php');