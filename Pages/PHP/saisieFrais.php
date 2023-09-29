<?php
//insertion dans la base de données
include 'connect_bd.php';
//recuperation des valeurs
$mois = date('m')+0;
$moisPre = $mois - 1;
$annee = date('Y');
$f_repas = $_POST['FRA_REPAS'];
$f_nuit = $_POST['FRA_NUIT'];
$f_etape = $_POST['FRA_ETAP'];
$f_km = $_POST['FRA_KM'];
$numLigne = $_POST['numLigne'];//viens du javascript
$montant_total = $f_km * 0.62 + $f_nuit * 80.00 + $f_repas * 29.00 + $f_etape * 110.00;
session_start();
$id_visiteur = $_SESSION['ID'];

$tab_dates = array();
array_push($tab_dates, 0);
$tab_libelles = array();
array_push($tab_libelles, 0);
$tab_montants = array();
array_push($tab_montants, 0);

for ($i = 1; $i <= $numLigne; $i++) {//faire un tableau et inserer les valeurs dans le tableau
    array_push($tab_dates, $_POST['FRA_AUT_DAT' . $i]);
    array_push($tab_montants, $_POST['FRA_AUT_MONT' . $i]);
    array_push($tab_libelles, $_POST['FRA_AUT_LIB' . $i]);
    $montant_total += (float) $_POST['FRA_AUT_MONT' . $i];
}

function insert_ficheFrais(){
    global $connexion, $id_visiteur, $mois, $montant_total;
    $req_fiche = "INSERT INTO fichefrais (dateModif, idEtat, idVisiteur, mois, montantValide) VALUES (NOW(), 'CR', '$id_visiteur', '$mois', $montant_total)";
    return $connexion->exec($req_fiche);
}

function insert_ficheF(){
    global $connexion, $f_etape, $id_visiteur, $f_km, $mois, $f_nuit, $f_repas;
    $req_ficheF = "INSERT INTO lignefraisforfait(idFraisForfait, idVisiteur, mois, quantite) VALUES ('ETP', '$id_visiteur', '$mois', $f_etape), ('KM', '$id_visiteur', '$mois', $f_km), ('NUI', '$id_visiteur', '$mois', $f_nuit), ('REP', '$id_visiteur', '$mois', $f_repas)";
    return $connexion->exec($req_ficheF);
}

function insert_ficheHF(){
    global $connexion, $tab_dates, $tab_libelles, $tab_montants, $numLigne, $id_visiteur, $mois;
    if ($numLigne > 0){
        for ($i = 1; $i <= $numLigne; $i++) {
            $req_hors_forfait = ("INSERT INTO lignefraishorsforfait (idVisiteur, mois, libelle, date, montant) VALUES ('$id_visiteur', '$mois', '$tab_libelles[$i]', '$tab_dates[$i]', '$tab_montants[$i]')");
            $res_hors_forfait = $connexion->exec($req_hors_forfait);
        }

    }
    return $res_hors_forfait;
}

function verifMoiSPrec(){
    //verification si la fiche de frais existe deja
    global $id_visiteur, $moisPre, $connexion;
    $req_verif = "SELECT idEtat FROM fichefrais WHERE idVisiteur = '$id_visiteur' AND mois = '$moisPre'";
    $res_verif = $connexion->query($req_verif);
    $ligne = $res_verif->fetch();
    if ($ligne){
        if ($ligne['idEtat']=='CL' || $ligne['idEtat']=='RB'){
            return false;
        }
        else{
            return true;
        }
    }
    return false;
}

function insert_all(){
    insert_ficheFrais();
    insert_ficheF();
    insert_ficheHF();
    header('location: ../Visiteurs.php?action=valid');
}

function verifMoiS(){
    //verification si la fiche de frais existe deja
    global $id_visiteur, $connexion, $mois;
    $req_verif = "SELECT idEtat FROM fichefrais WHERE idVisiteur = '$id_visiteur' AND mois = '$mois'";
    $res_verif = $connexion->query($req_verif);
    $ligne = $res_verif->fetch();
    if ($ligne){
        return true;
    }
    else{
        return false;
    }
}

function doall(){
    global $connexion, $id_visiteur, $moisPre;
    if (verifMoiSPrec()){
        //update la fiche, etat = CL, dateModif = NOW(), montantValide = $montant_total
        $req_update = "UPDATE fichefrais SET dateModif = NOW(), idEtat = 'VA' WHERE idVisiteur = '$id_visiteur' AND mois = '$moisPre'";
        $connexion->exec($req_update);
    }
    if(verifMoiS()){
        header('location: ../Visiteurs.php?action=all');
    }
    else{
        insert_all();
    }
}
doall();
?>









