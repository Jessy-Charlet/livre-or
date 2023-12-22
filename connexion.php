<?php
session_start();
//--SQL-------------------------------------------------------------
$sql_serveur = "localhost:3306";
$sql_utilisateur = "jessy-charlet";
$sql_motDePasse = "Test1304+++";
$sql_baseDeDonnees = "jessy-charlet_livreor";

$sql_connexion = new mysqli($sql_serveur, $sql_utilisateur, $sql_motDePasse, $sql_baseDeDonnees);
//------------------------------------------------------------------------------------
if (isset($_SESSION['connexion'])) {
    if (($_SESSION['connexion'] == true)) {
        header("Location: ./profil.php");
    }
}
if (empty($_SESSION['login'])) {
    $_SESSION['login'] = "";
}
if (empty($_SESSION['password'])) {
    $_SESSION['password'] = "";
}
$error = false;
//--Connexion-----------------------------------------------------------
if (isset($_POST['connexion'])) {
    // Requête SQL 
    $sql = "SELECT * FROM utilisateurs";
    // Exécution de la requête
    $sql_resultat = $sql_connexion->query($sql);
    // Connexion et attribution des cookies
    foreach ($sql_resultat as $utilisateur) {
        if ($utilisateur['login'] == $_POST['login'] and $utilisateur['password'] == $_POST['password']) {
            $id = $utilisateur['id'];
            $login = $utilisateur['login'];
            $password = $utilisateur['password'];
            $_SESSION['connexion'] = true;
            $_SESSION['id'] = $id;
            $_SESSION['login'] = $login;
            $_SESSION['password'] = $password;
            header("Location: ./profil.php");
        }
        // Mot de passe incorrect
        else {
            $error = true;
            $error_message = "<span class='error'>Identifiant ou mot de passe incorrect</span>";
        }
    }
}
?>



<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Connexion</title>
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
        <h1>Connexion</h1>
        <?php
        if ($error == true) {
            echo $error_message;
        }
        if (isset($_SESSION['validation'])){
            echo "<span class='validation'>Félicitation pour
            ton inscription</span>";
            unset($_SESSION['validation']);
        }
        ?>
        <form method='post' action='connexion.php'>
            <input type='text' name='login' value='<?= $_SESSION['login'] ?>' placeholder='Identifiant'>
            <input type='password' name='password' value='<?= $_SESSION['password'] ?>' placeholder='Mot de passe'>
            <button class="button" type='submit' name='connexion'>Connexion</button>
        </form>
        <p>Pas encore de compte ?
        <p>
            <?php
            if (isset($_SESSION['connexion'])) {
                echo "<a class='bouton' href='profil.php'>Mon profil</a>";
            } else {
                echo "<a class='bouton' href='inscription.php'>S'inscrire</a>";
            }
            ?>
    </section>
    <footer>
        <p>./ Jessy Charlet // $Job ['livre-d.or']</p>
    </footer>
</body>