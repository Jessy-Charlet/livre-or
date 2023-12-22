<?php
session_start();
//--SQL-------------------------------------------------------------
$sql_serveur = "localhost:3306";
$sql_utilisateur = "jessy-charlet";
$sql_motDePasse = "Test1304+++";
$sql_baseDeDonnees = "jessy-charlet_livreor";

$sql_connexion = new mysqli($sql_serveur, $sql_utilisateur, $sql_motDePasse, $sql_baseDeDonnees);

$error = false;
$validation = false;
$id = "";
if ($_SESSION['connexion'] !== true){
    header("Location: ./connexion.php");
}
if (isset($_POST['publier'])) {
    $commentaire = htmlentities($_POST['commentaire']);
    $id = $_SESSION['id'];
     if (strlen($_POST['commentaire']) < 30) {
        $error = true;
        $error_message = "<span class='error'>Votre message est trop court, il doit contenir
        au moins 30 caractères</span>";
    } else {
        // Requête SQL 
        $sql = "INSERT INTO commentaires (commentaire, date, id_utilisateur)
        VALUE ('$commentaire', CURRENT_TIMESTAMP, '$id')";
        // Exécution de la requête
        $sql_resultat = $sql_connexion->query($sql);
        $_SESSION['validation'] = true;
        header("Location: ./livre-or.php");
    }
}

?>
<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Commentaire</title>
    <meta charset="UTF-8">
    <meta name="description" content="??????">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<!-------------------------------------------------------------->

<body> 
    <!--Header------------------------------------------------------>
    <header>
        <a href="index.php"><img src="./media/logo-le-club-des-baby-sitters-nav.png"></a>
        <nav>
            <a href="index.php"><img src="./media/home.png" alt="Accueil"></a>
            <a href="livre-or.php"><img src="./media/livre-d-or.png" alt="Livre d'or"></a>
            <?php
            if (isset($_SESSION['connexion'])) {
                if ($_SESSION['connexion'] == false) {
                    echo "<a href='connexion.php'>Se connecter</a>";
                } elseif ($_SESSION['connexion'] == true) {
                    echo "<a href='profil.php'>" .$_SESSION['login']. "</a><a href='profil.php'><img src='./media/user.png' alt='Mon profil'></a>";

                }
            }
            else {
                echo "<a href='connexion.php'>Se connecter</a>";
            }
            ?>
        </nav>

    </header>
    <!-------------------------------------------------------------->
    <section class="livreOr">
        <h1>Publier un commentaire</h1>
        <?php
        // Messages d'erreure
        if ($error == true) {
            echo $error_message;
        }
        // Affichage du tableau
        if ($validation == false) {
            echo "<form method='post' action='commentaire.php'>
    <textarea name='commentaire' placeholder='Laissez un petit message décrivant votre experience avec notre équipe' required></textarea>
    <button class='button' type='submit' name='publier'>Envoyer</button>
</form>";
        }
        ?>
    </section>
    <footer>
        <p>./ Jessy Charlet // $Job ['livre-d.or']</p>
    </footer>
    </body>