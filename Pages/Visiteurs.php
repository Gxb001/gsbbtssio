<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB</title>
    <link rel="stylesheet" href="Scripts/styles_loader.css">
    <link rel="stylesheet" href="Scripts/styles_Visiteurs.css">
    <link rel="icon" href="Medias/GSB-icon.ico" type="image/logo">
    <script>
        function moisActuel(){
            const moisEnLettres = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout","Septembre", "Octobre", "Novembre", "Décembre"];
            const dateActuelle = new Date();
            const moisActuel = dateActuelle.getMonth();
            const moisEnLettreACtuel = moisEnLettres[moisActuel];
            return moisEnLettreACtuel;
        }
        function anneeActuelle(){
            const dateActuelle = new Date();
            const anneeActuelle = dateActuelle.getFullYear();
            return anneeActuelle;
        }
        function afficherLaDate(){
            var mois = moisActuel();
            var annee = anneeActuelle();
            document.getElementById("date").innerHTML = "PERIODE D'ENGAGEMENT : " + mois + ' ' + annee;
        }
        function all(){
            alert("Vous avez une fiche de frais en cours de saisie, vous pouvez la modifier ou bien attendre le mois suivant !");
        }
        function valid(){
            alert("Fiche de frais envoyée avec succès ! Vous pouvez la consulter dans la rubrique 'Mes Factures'");
        }
        const params = new URLSearchParams(window.location.search);
        const action = params.get('action');
        if (action == "all") {
            all();
        }
        else if (action == "valid") {
            valid();
        }
        if (action=="paiement"){
            alert("Votre fiche de frais a été envoyé à la compta !")
        }
    </script>
    <?php
    session_start();
    if(isset($_SESSION['ok']) && $_SESSION['role'] == "C"){
        header("Location: Comptables.php");
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
</head> 
<body>
    <video autoplay muted loop id="player">
        <source src="Medias/video.mp4" type="video/mp4">
    </video>
    <div class="container">
        <div class="content">
            <nav class="navbar">
                <h2 class="gsb"><a style="text-decoration: none; color: inherit" href="Visiteurs.php">GSB</a></h2>
                <ul>
                    <li><a href="MesFichesDeFrais.php" class="liens">Mes Factures</a></li>
                    <li> <div id="visiteur">Visiteur</div></li>
                    <li><form action="PHP/deconnexion.php" method="post">
                        <button type="submit" name="deconnexion" class="deconnexion">Déconnexion</button>
                    </form></li>
                    <li><div id="heure"></div></li>
                </ul>
            </nav>
            <a href="https://gabrielfe.notion.site/Guide-Visiteurs-6fe40123c6244148912ed2ba0037463f"><div class="help-btn">Guide</div></a>
            <div class="headline">
                <h2>Suivi de factures</h2>
                <p>
                    Bienvenue sur notre site dédié à la gestion des factures des employés de l'entreprise GSB. Nous vous offrons un outil efficace pour faciliter la gestion de vos factures. N'hésitez pas à explorer toutes les fonctionnalités que nous avons à mises en place et à nous contacter si vous avez des questions ou des préoccupations.
                </p>
                <div class="buttons">
                    <a class="demander" id="demander">Demander</a>
                    <a href="mailto:contact-assistance@gsb.fr" class="aide">Nous contacter</a>
                </div>
            </div>
        </div>
    </div>
    <div id="fiche" class="fiche">
        <form name="formSaisieFrais" id="formulaire_fiche" method="post" action="PHP/saisieFrais.php" onsubmit="envoyerform();">
            <h1>Saisie Frais : </h1>

            <label id="date" class="titre"></label>

            <p class="titre" /><div style="clear:left;"><h2>Frais au forfait</h2></div>
            <div>
                <label class="titre">Repas midi :</label>
                <input type="number" size="2" name="FRA_REPAS" class="zone" placeholder="ex : 2" required/>
            </div>
            <div>
                <label class="titre">Nuitées :</label>
                <input type="number" size="2" name="FRA_NUIT" class="zone" placeholder="ex : 3" required/>
            </div>
            <div>
                <label class="titre">Etape :</label>
                <input type="number" size="5" name="FRA_ETAP" class="zone" placeholder="ex : 50" required/>
            </div>
            <div>
                <label class="titre">Km :</label>
                <input type="number" size="5" name="FRA_KM" class="zone" placeholder="ex : 200" required/>
            </div>
            <p class="titre" /><div style="clear:left;"><h2>Hors Forfait</h2></div>
            <div style="clear:left;" id="lignes">
                <div>
                    <label class="titre" > 1 :</label>
                    <input type="date" size="12" name="FRA_AUT_DAT1" class="zone"/>
                    <input type="text" size="30" name="FRA_AUT_LIB1" class="zone" placeholder="ex : Frais de déplacement" />
                    <input class="zone" size="3" name="FRA_AUT_MONT1" type="number" placeholder="ex : 30" />
                    <input type="button" id="but1" value="+" onclick="ajouterLigne()" class="zone" /><input type="button" id="but2" value="-" onclick="supprLigne()" class="zone" />
                </div>
            </div>
            <p class="titre" /><label class="titre">&nbsp;</label><input class="btn-form zone"  type="reset" onclick="supprimerToutesLignes()" /><p class="titre" /><button class="btn-form zone" onclick="verifform(); return false;">Envoyer</button>
        </form>
        <button id="fermer">&times;</button>
    </div>
    <div class="loader" id="loader">
        <div class="spinner"></div>
    </div>
    <script>afficherLaDate();</script>
    <script src="Scripts/script_load.js"></script>
    <script src="Scripts/script_visiteurs.js"></script>
    <script src="Scripts/script_heure.js"></script>
</body>
</html>
