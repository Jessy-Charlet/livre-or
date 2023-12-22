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
// Si inscription, récupération des valeurs du formulaire en variables
if (isset($_POST['inscription'])) {
    // Variables
    $login = $_POST['login'];
    $password = $_POST['password'];
    // Set cookies
    $_SESSION['login'] = $login;
    $_SESSION['password'] = $password;
    // Set up des messsages d'erreurs
    $sql = "SELECT * FROM utilisateurs WHERE login='" . $_POST['login'] . "'";
    $sql_resultat = $sql_connexion->query($sql);
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe et sa confirmation ne
        sont pas identiques !</span>";
    } elseif (strlen($_POST['password']) < 6) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe est trop court, il doit contenir
        au moins 6 caractères</span>";
    } elseif (mysqli_num_rows($sql_resultat)) {
        $error = true;
        $error_message = "<span class='error'>Cet identifiant existe déjà, merci d'en renseigner
        un nouveau</span>";
    } else {
        // Requête SQL 
        $sql = "INSERT INTO utilisateurs (login, password)
        VALUE ('$login', '$password')";
        // Exécution de la requête
        $sql_resultat = $sql_connexion->query($sql);
        $_SESSION['validation'] = true;
        header("Location: ./connexion.php");
    }
}


//------------------------------------------------------------------
if (isset($_SESSION['connexion'])) {
    if ($_SESSION['connexion'] == true) {
        header("Location: ./profil.php");
    }
}
if (empty($_SESSION['login'])) {
    $_SESSION['login'] = "";
}
?>


<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>inscription</title>
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
        <h1>Inscription</h1>
        <?php
        // Messages d'erreure
        if ($error == true) {
            echo $error_message;
        }
        // Affichage du tableau
        if ($validation == false) {
            echo "<form method='post' action='inscription.php'>
    <input type='text' name='login' value='" . $_SESSION['login'] . "' placeholder='Identifiant' required>
    <input type='password' name='password' placeholder='Mot de passe' required>
    <input type='password' name='confirm_password' placeholder='Confirmation du mot de passe' required>
    <button class='button' type='submit' name='inscription'>Inscription</button>
</form>";
        }
        ?>
    </section>
    <footer>
        <p>./ Jessy Charlet // $Job ['livre-d.or']</p>
    </footer>
</body>