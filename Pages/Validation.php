<?php
session_start();
if(isset($_SESSION['ok']) && $_SESSION['role'] == "V"){
    header("Location: Visiteurs.php");
    exit();
}
else if(!isset($_SESSION['ok']) || $_SESSION['ok'] != "oui"){
    header("Location: Connexion.php");
    exit();
}
if(isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)){
    session_unset();
    session_destroy();
    header("Location: Connexion.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Gestions fiches de frais</title>
    <link rel="stylesheet" type="text/css" href="Scripts/styles_Validation.css">
    <link rel="stylesheet" href="Scripts/styles_loader.css">
    <link rel="icon" href="Medias/GSB-icon.ico" type="image/logo">
    <script>
        const params = new URLSearchParams(window.location.search);
        const action = params.get('action');
        if(msg =="valider"){
            alert("Fiche de frais validée !")
        }
        if(msg =="refuser"){
            alert("Fiche de frais refusée !")
        }
    </script>
</head>
<body>
<nav class="navbar">
    <h2 class="gsb"><a style="color: inherit" href="Visiteurs.php">Accueil</a></h2>
</nav>
<h1>Liste des Utilisateurs</h1>

<?php
include 'PHP/connect_bd.php';

// Récupération de tous les utilisateurs de la table Visiteurs
$query = "SELECT * FROM visiteur WHERE role = 'V'";
$result = $connexion->query($query);
?>

<form action="Validation.php" method="POST" id="liste">
    <select name="utilisateur" id="utilisateur">
        <?php
        if ($result->rowCount() > 0) {
            while ($lignes = $result->fetch()) {
                echo '<option value="' . $lignes['login'] . '">' . $lignes['prenom']." " .$lignes['nom']. '</option>';
            }
        }
        ?>
    </select>
    <button type="submit">Afficher la fiche de frais</button>
    </form>

<?php
$id_utilisateur = null;
function get_id(){
    global $connexion, $id_utilisateur;
    if (isset($_POST['utilisateur'])){
        $utilisateur = $_POST['utilisateur'];
        $req = "SELECT * FROM visiteur WHERE login = '$utilisateur'";
        $result = $connexion->query($req);
        if ($result->rowCount() > 0) {
            $id_utilisateur = $result->fetchColumn();
        }
    }
    return $id_utilisateur;
}
$id_utilisateur = get_id();
$montant_frais_forfait = 0;
$req_fraisF = ("SELECT * FROM lignefraisforfait WHERE idVisiteur = '$id_utilisateur'");
$res_fraisF = $connexion->query($req_fraisF);
$ligne_fraisF = $res_fraisF ->fetchall();
$lignes_fraisF = $res_fraisF->rowCount();
if ($lignes_fraisF == 0 || $ligne_fraisF == null){
    $montant_frais_forfait = 0;
}
elseif($lignes_fraisF>=1){
    for ($i = 1; $i <= $lignes_fraisF; $i++){
        if ($ligne_fraisF[$i-1]['idFraisForfait'] == "ETP"){
            $montant_frais_forfait += $ligne_fraisF[$i-1]['quantite'] * 110.00;
        }
        if ($ligne_fraisF[$i-1]['idFraisForfait'] == "KM"){
            $montant_frais_forfait += $ligne_fraisF[$i-1]['quantite'] * 0.62;
        }
        if ($ligne_fraisF[$i-1]['idFraisForfait'] == "NUI"){
            $montant_frais_forfait += $ligne_fraisF[$i-1]['quantite'] * 80.00;
        }
        if ($ligne_fraisF[$i-1]['idFraisForfait'] == "REP"){
            $montant_frais_forfait += $ligne_fraisF[$i-1]['quantite'] * 29.00;
        }

    }
}

if (isset($_POST['Valider'])){
    $id_utilisateur = get_id();
    if ($id_utilisateur!=null){
        $mois = date("m")+0;
        $req_v = ("UPDATE `fichefrais` SET `idEtat` = 'RB' WHERE `fichefrais`.`idVisiteur` = '$id_utilisateur' AND `fichefrais`.`mois` = '$mois'");
        $connexion->exec($req_v);
        header('location: Validation.php?msg=valider');
        exit();
    }

}
if (isset($_POST['Refuser'])){
    $id_utilisateur = get_id();
    if ($id_utilisateur!=null){
        $mois = date("m")+0;
        $req_r = ("UPDATE `fichefrais` SET `idEtat` = 'RB' WHERE `fichefrais`.`idVisiteur` = '$id_utilisateur' AND `fichefrais`.`mois` = '$mois'");
        $connexion->exec($req_r);
        header('location: Validation.php?msg=refuser');
        exit();
    }
}
?>

<div style="clear:left;" id="lignes"><br><br>
    <div style="text-align: center">
        <?php
        if (get_id()==null){
            echo "Veuillez selectionner un visiteur !";
        }
        elseif(get_id() != null){
            $id_utilisateur = get_id();
            $mois = date("m")+0;
            $req_va = ("SELECT * FROM fichefrais WHERE idVisiteur = '$id_utilisateur' AND mois = '$mois'");
            $res_va = $connexion->query($req_va);
            if ($ligne_va = $res_va->fetch()){
                if($ligne_va['idEtat']=='VA'){
                    $req_ficheHF = ("SELECT * FROM lignefraishorsforfait WHERE idVisiteur = '$id_utilisateur'");
                    $res_ficheHF = $connexion->query($req_ficheHF);
                    $ligne_ficheHF = $res_ficheHF->fetchall();
                    $lignes = $res_ficheHF->rowCount();
                    if ($lignes >= 1) {
                        $total = 0;
                        echo '<h3>Frais Forfaitaire : ' . $montant_frais_forfait . '€</h3>';
                        echo "<center><table>";
                        echo "<tr><th>" . "Date " . "</th><th>" . "Libelle " . "</th><th>" . "Montant " . "</th></tr>";
                        for ($i = 1; $i <= $lignes; $i++) {
                            $total += $ligne_ficheHF[$i - 1]['montant'];
                            echo "<tr><td>" . $ligne_ficheHF[$i - 1]['date'] . "</td><td>" . $ligne_ficheHF[$i - 1]['libelle'] . "</td><td>" . $ligne_ficheHF[$i - 1]['montant'] . "</td></tr>";
                        }
                        echo "</table></center>";
                        echo "<center><table><tr><th>Montant Total HF :</th></tr></table>";
                        echo "<tr><td>$total €</td></tr>";
                        echo "<br><br>";
                        echo "<form method='POST'>";
                        echo "<button name='Valider' id='Valider'>Valider</button>";
                        echo "<button name='Refuser' id='Refuser'>Refuser</button>";
                        echo "</form>";
                    }
                }
                else{
                    echo "Le visiteur n'a pas encore validé sa fiche de frais !";
                }
            }
            else{
                echo "Le visiteur n'a pas encore de fiche de frais !";
            }
        }

        ?>
    </div>
</div>

<?php
// Fermeture de la connexion à la base de données
$connexion= null;
?>

<div class="loader" id="loader">
    <div class="spinner"></div>
</div>
<script src="Scripts/script_load.js"></script>
<script src="Scripts/script_validation.js"></script>
</body>
</html>