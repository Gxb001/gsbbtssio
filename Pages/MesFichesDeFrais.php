<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Scripts/styles_fiches.css">
    <link rel="stylesheet" href="Scripts/styles_loader.css">
    <link rel="icon" href="Medias/GSB-icon.ico" type="image/logo">
    <script>
        const params = new URLSearchParams(window.location.search);
        const action = params.get('action');
        if(action =="modif"){
            alert("Fiche de frais modifiée avec succès !")
        }
    </script>
<?php
include 'PHP/connect_bd.php';
session_start();
if (isset($_SESSION['ok']) && $_SESSION['role'] == "C") {
    header("Location: Comptables.php");
    exit();
} else if (!isset($_SESSION['ok']) || $_SESSION['ok'] != "oui") {
    header("Location: Connexion.php");
    exit();
}
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header("Location: Connexion.php");
    exit();
}
?>
</head>
<body>
<div class="container">
    <nav class="navbar">
        <h2 class="gsb"><a style=" color: inherit" href="Visiteurs.php">Accueil</a></h2>
    </nav>
    <h1>Fiche de frais du mois courant</h1>
<?php
function moisEnLettres($mois) {
    $moisEnLettres = [
        'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin',
        'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'
    ];
    if ($mois >= 1 && $mois <= 12) {
        return $moisEnLettres[$mois - 1];
    } else {
        return 'Mois invalide';
    }
}

// Utilisation de la fonction
$moisCourant = date('n');
$moisCourantEnLettres = moisEnLettres($moisCourant);
$id_visiteur = $_SESSION['ID'];
$mois = date("m")+0;

//listage des fiches de frais en fonction de l'id de l'utilisateur
$req_ficheF = ("SELECT * FROM fichefrais WHERE idVisiteur = '$id_visiteur' AND mois = '$mois' AND idEtat = 'CR'");
$req_ficheF_clos = ("SELECT * FROM fichefrais WHERE idvisiteur = '$id_visiteur' AND (idEtat = 'Cl' or idEtat = 'RB')");
$req_ficheHF = ("SELECT * FROM lignefraishorsforfait WHERE idVisiteur = '$id_visiteur' AND mois = '$mois'");
$result_ficheF = $connexion->query($req_ficheF);
$ligne_ficheF = $result_ficheF ->fetch();
$nb = $result_ficheF->rowCount();

if ($ligne_ficheF){//tableau de la fiche de ce mois ci encore modifiable
    echo "En attente de votre validation pour le passage en compta.";
    echo "<table>";
    echo "<tr>";
    echo "<th>" . "Mois" . "</th>";
    echo "<th>" . "Montant" . "</th>";
    echo "<th>" . "Derniere modification" . "</th>";
    echo "<th>" . "x" . "</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . moisEnLettres($ligne_ficheF['mois']) . "</td>";
    echo "<td>" . $ligne_ficheF['montantValide']."€" . "</td>";
    echo "<td>" . $ligne_ficheF['dateModif']. "</td>";
    echo "<td>" . "<div style='cursor: pointer' class='buttons'><a class='demander' id='demander'>Consulter</a></div>" . "</td>";
    echo "</tr>";
    echo "</table>";
}
else {
    echo "<strong><p style='color: red'>Vous n'avez pas encore de fiche de frais pour ce mois ci !</p></strong>";
    echo "<a style='color: inherit' href='Visiteurs.php'>Réaliser une demande.</a>";
}
?>
    <h2>Fiches clôturées</h2>
<?php // tableau des fiches deja fermées
$result_ficheF_close = $connexion->query($req_ficheF_clos);
$ligne_ficheF_close = $result_ficheF_close ->fetch();

function verifEtat($ligne_ficheF_close){
    if ($ligne_ficheF_close['idEtat'] == "CL"){
        $conclusion = "Refusée";
    }
    elseif($ligne_ficheF_close['idEtat'] == "RB"){
        $conclusion = "Remboursée";
    }
    else{
        $conclusion = "Erreur";
    }
    return $conclusion;
}

if (!$ligne_ficheF_close){
    echo "<strong><p style='color: red'>Vous n'avez pas encore de fiche de frais clôturées</p></strong>";
}
else{
    echo "<table>";
    echo "<tr>";
    echo "<th>" . "Date de fermeture " . "</th>";
    echo "<th>" . "Mois " . "</th>";
    echo "<th>" . "Montant " . "</th>";
    echo "<th>" . "Finalité " . "</th>";
    echo "</tr>";
    echo "<tr>";
    echo "<td>" . $ligne_ficheF_close['dateModif'] . "</td>";
    echo "<td>" . moisEnLettres($ligne_ficheF_close['mois']) . "</td>";
    echo "<td>" . $ligne_ficheF_close['montantValide'] . "</td>";
    echo "<td>" . verifEtat($ligne_ficheF_close) . "</td>";
    echo "</tr>";
    while (($ligne_ficheF_close = $result_ficheF_close ->fetch())==true){
        echo "<tr>";
        echo "<td>" . $ligne_ficheF_close['dateModif'] . "</td>";
        echo "<td>" . $ligne_ficheF_close['mois'] . "</td>";
        echo "<td>" . $ligne_ficheF_close['montantValide'] . "</td>";
        echo "<td>" . verifEtat($ligne_ficheF_close) . "</td>";
        echo "</tr>";

    }
echo "</table>";
}


if ($ligne_ficheF){
    $req_lignefraisforfait = ("SELECT * FROM lignefraisforfait WHERE idVisiteur = '$id_visiteur' AND mois = '$mois'");
    $result_lignefraisforfait = $connexion->query($req_lignefraisforfait);
    while($ligne_lignefraisforfait = $result_lignefraisforfait ->fetch()){
        if ($ligne_lignefraisforfait['idFraisForfait'] == "ETP"){
            $ETP = $ligne_lignefraisforfait['quantite'];
        }
        if ($ligne_lignefraisforfait['idFraisForfait'] == "KM"){
            $KM = $ligne_lignefraisforfait['quantite'];
        }
        if ($ligne_lignefraisforfait['idFraisForfait'] == "NUI"){
            $NUI = $ligne_lignefraisforfait['quantite'];
        }
        if ($ligne_lignefraisforfait['idFraisForfait'] == "REP"){
            $REP = $ligne_lignefraisforfait['quantite'];
        }
    }
}
else{
    $ETP = 0;
    $KM = 0;
    $NUI = 0;
    $REP = 0;
}
?>
    <div id="fiche" class="fiche">
        <form name="formSaisieFrais" id="formulaire_fiche" method="post" action="PHP/update_Comptable.php" onsubmit="envoyerform();">
            <h1>Votre fiche de frais : </h1>

            <label id="date" class="titre"></label>

            <p class="titre" /><div style="clear:left;"><h2>Frais au forfait</h2></div>
            <div>
                <label class="titre">Repas midi :</label>
                <?php echo '<input type="number" size="2" name="FRA_REPAS" class="zone" required value="'.htmlspecialchars($REP).'"/>'; ?>
            </div>
            <div>
                <label class="titre">Nuitées :</label>
                <?php echo '<input type="number" size="2" name="FRA_NUIT" class="zone" required value="'.htmlspecialchars($NUI).'"/>'; ?>
            </div>
            <div>
                <label class="titre">Etape :</label>
                <?php echo '<input type="number" size="2" name="FRA_ETAP" class="zone" required value="'.htmlspecialchars($ETP).'"/>'; ?>
            </div>
            <div>
                <label class="titre">Km :</label>
                <?php echo '<input type="number" size="2" name="FRA_KM" class="zone" required value="'.htmlspecialchars($KM).'"/>'; ?>
            </div>
            <div>
                <label for="paiement" class="titre">Mettre en paiement :</label>
                <?php echo "<input type='checkbox' name='paiement'>"?>
            </div>
            <p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
            <div style="clear:left;" id="lignes">
                <div>
                    <?php
                    $i = 1;
                    $res_ficheHF = $connexion->query($req_ficheHF);
                    $ligne_ficheHF = $res_ficheHF ->fetch();;
                    if (!$ligne_ficheHF){
                        $numLigne = 1;
                        echo '
                    <label class="titre" > 1 :</label>
                    <input type="date" size="12" name="FRA_AUT_DAT1" class="zone"/>
                    <input type="text" size="30" name="FRA_AUT_LIB1" class="zone" placeholder="ex : Frais de déplacement" />
                    <input class="zone" size="3" name="FRA_AUT_MONT1" type="number" placeholder="ex : 30" />            
                    <input type="button" id="but1" value="+" onclick="ajouterLigne()" class="zone" />   
                </div>';
                    }
                    else{
                        $numLigne = 1;
                        echo '
                    <label class="titre" >'."$i ". ':</label>
                    <input type="date" size="12" name="FRA_AUT_DAT'.$i.'" class="zone"   value="'.htmlspecialchars($ligne_ficheHF['date']).'"/>
                    <input type="text" size="30" name="FRA_AUT_LIB'.$i.'" class="zone" placeholder="ex : Frais de déplacement" value="'.htmlspecialchars($ligne_ficheHF['libelle']).'" />
                    <input class="zone" size="3" name="FRA_AUT_MONT'.$i.'" type="number" placeholder="ex : 30" value="'.htmlspecialchars($ligne_ficheHF['montant']).'" /><br>                              
                ';
                        $i++;
                        while(($ligne_ficheHF=$res_ficheHF ->fetch())==true){
                            $numLigne++;
                            echo '
                    <label class="titre" >'."$i ". ':</label>
                    <input type="date" size="12" name="FRA_AUT_DAT'.$i.'" class="zone"   value="'.htmlspecialchars($ligne_ficheHF['date']).'"/>
                    <input type="text" size="30" name="FRA_AUT_LIB'.$i.'" class="zone" placeholder="ex : Frais de déplacement" value="'.htmlspecialchars($ligne_ficheHF['libelle']).'" />
                    <input class="zone" size="3" name="FRA_AUT_MONT'.$i.'" type="number" placeholder="ex : 30" value="'.htmlspecialchars($ligne_ficheHF['montant']).'" /><br>                              
                ';
                            $i++;
                        }
                        echo '<input type="button" id="but1" value="+" onclick="ajouterLigne()" class="zone" /> </div> ';
                    }
                    ?>
                    <p class="titre" /><label class="titre">&nbsp</label><p class="titre" /><button class="btn-form zone" onclick="verifform();">Mettre à jour</button><br><br><input type="button" id="fermer">&times;</input>
            </div>
        </form>
    </div>
    <div class="loader" id="loader">
        <div class="spinner"></div>
    </div>
</div>
    <script>
        var numLigne = <?php echo json_encode($numLigne); ?>;
    </script>
    <script src="Scripts/script_load.js"></script>
    <script src="Scripts/script_heure.js"></script>
    <script src="Scripts/script_MesFiches.js"></script>
</body>
</html>




