<?php
include 'connect_bd.php';
session_start();
$login = $_SESSION['login'];
$mois = date('m')+0;
$id_visiteur = $_SESSION['ID'];
$etp = $_POST['FRA_ETAP'];
$km = $_POST['FRA_KM'];
$nuit = $_POST['FRA_NUIT'];
$repas = $_POST['FRA_REPAS'];
$numLigne = $_POST['numLigne'];


$req_etp = ("UPDATE lignefraisforfait SET quantite = '$etp' WHERE idVisiteur = '$id_visiteur' AND mois = '$mois' AND idFraisForfait = 'ETP'");
$req_km = ("UPDATE lignefraisforfait SET quantite = '$km' WHERE idVisiteur = '$id_visiteur' AND mois = '$mois' AND idFraisForfait = 'KM'");
$req_nuit = ("UPDATE lignefraisforfait SET quantite = '$nuit' WHERE idVisiteur = '$id_visiteur' AND mois = '$mois' AND idFraisForfait = 'NUI'");
$req_repas = ("UPDATE lignefraisforfait SET quantite = '$repas' WHERE idVisiteur = '$id_visiteur' AND mois = '$mois' AND idFraisForfait = 'REP'");


$connexion->exec($req_etp);
$connexion->exec($req_km);
$connexion->exec($req_nuit);
$connexion->exec($req_repas);

$req = ("SELECT id FROM lignefraishorsforfait WHERE idVisiteur = '$id_visiteur' AND mois = '$mois'");
$resultat = $connexion->query($req);

for ($i = 1; $i <= $numLigne; $i++){
    if ($ligne = $resultat->fetch()){
        $id_fiche = $ligne['id'];

        $libelle = $_POST['FRA_AUT_LIB' . $i];
        $montant = $_POST['FRA_AUT_MONT' . $i];
        $date = $_POST['FRA_AUT_DAT' . $i];

        $req_HF = ("UPDATE lignefraishorsforfait SET libelle = '$libelle', montant = '$montant', date = '$date' WHERE idVisiteur = '$id_visiteur' AND mois = '$mois' AND id='$id_fiche'");
        $connexion->exec($req_HF);
    }
    else{
        $libelle = $_POST['FRA_AUT_LIB' . $i];
        $montant = $_POST['FRA_AUT_MONT' . $i];
        $date = $_POST['FRA_AUT_DAT' . $i];

        $req_HF = ("INSERT INTO lignefraishorsforfait (idVisiteur, mois, libelle, date, montant) VALUES ('$id_visiteur', '$mois', '$libelle', '$date', '$montant')");
        $connexion->exec($req_HF);
    }
}

if (isset($_POST['paiement'])){
    $req_paiement = ("UPDATE fichefrais SET idEtat = 'VA' WHERE idVisiteur = '$id_visiteur' AND mois = '$mois'");
    $connexion->exec($req_paiement);
    echo "<script>alert(\"La fiche a bien été mise en paiement\")</script>";
    header('Location: ../Visiteurs.php?action=paiement');
}
else{
    header('location: ../MesFichesDeFrais.php?action=modif');
}

?>
