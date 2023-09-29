<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GSB</title>
    <link rel="stylesheet" href="Scripts/styles_loader.css">
    <link rel="stylesheet" href="Scripts/styles_Comptables.css">
    <link rel="ico" type="image/x-icon" href="Medias/GSB-icon.ico">

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
</head> 
<body>
    <video autoplay muted loop id="player">
        <source src="Medias/video.mp4" type="video/mp4">
    </video>

    <div class="container">
        <div class="content">
            <nav class="navbar">
                <h2 class="gsb"><a style="text-decoration: none; color: inherit" href="Comptables.php">GSB</a></h2>
                <ul>
                    <li> <div id="comptable">Comptable</div></li>
                    <li><form action="PHP/deconnexion.php" method="post">
                        <button type="submit" name="deconnexion" class="deconnexion">Déconnexion</button>
                    </form></li>
                    <li><div id="heure"></div></li>
                </ul>
            </nav>
            <a href="https://gabrielfe.notion.site/Guide-Comptable-4785d408c9964505b21936677bdd1927"><div class="help-btn">Guide</div></a>
            <div class="headline">
                <h2>Suivi de factures</h2>
                <p>
                    Bienvenue sur notre site dédié à la gestion des factures des employés de l'entreprise GSB. Nous vous offrons un outil efficace pour faciliter la gestion de vos factures. N'hésitez pas à explorer toutes les fonctionnalités que nous avons à mises en place et à nous contacter si vous avez des questions ou des préoccupations.
                </p>
                <div class="buttons">
                    <a class="demander" id="demander" href="Validation.php">Consulter</a>
                    <a href="mailto:contact-assistance@gsb.fr" class="aide">Nous contacter</a>
                </div>
            </div>
        </div>
    </div>
    <div class="loader" id="loader">
        <div class="spinner"></div>
    </div>
    <script src="Scripts/script_load.js"></script>
    <script src="Scripts/script_heure.js"></script>
</body>
</html>
