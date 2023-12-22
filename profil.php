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


//--Déconnexion-----------------------------------------------------------------------
if (isset($_POST['deco'])) {
    session_destroy();
    header("Location: ./connexion.php");
}


//--Modification du login-------------------------------------------------------------
if (isset($_POST['update_login'])) {
    $id = $_SESSION['id'];
    $login = $_POST['login'];
    $_SESSION['login'] = $login;
    $sql = "SELECT * FROM utilisateurs WHERE login='" . $_POST['login'] . "'";
    $sql_resultat = $sql_connexion->query($sql);
    if (mysqli_num_rows($sql_resultat)) {
        $error = true;
        $error_message = "<span class='error'>Cet identifiant existe déjà, merci d'en renseigner
        un nouveau</span>";
    } else {
        $sql = "UPDATE utilisateurs SET login='$login' WHERE id='$id'";
        $sql_resultat = $sql_connexion->query($sql);
        $validation = true;
        $validation_message = "<span class='validation'>Votre identifiant a bien été modifié.</span>";
    }

}
//--Modification du mot de passe------------------------------------------------------
elseif (isset($_POST['update_password'])) {
    $password = $_POST['password'];
    $_SESSION['password'] = $password;
    if ($_POST['password'] !== $_POST['confirm_password']) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe et sa confirmation ne
        sont pas identiques !</span>";
    } elseif (strlen($_POST['password']) < 6) {
        $error = true;
        $error_message = "<span class='error'>Votre mot de passe est trop court, il doit contenir
        au moins 6 caractères</span>";
    } else {
        $sql = "UPDATE utilisateurs SET password='$password' WHERE id='$id'";
        $sql_resultat = $sql_connexion->query($sql);
        $validation = true;
        $validation_message = "<span class='validation'>Votre mot de passe a bien été modifié.</span>";
    }
}

?>

<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Profil</title>
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
                    echo "<a href='profil.php'>" . $_SESSION['login'] . "</a><a href='profil.php'><img src='./media/user.png' alt='Mon profil'></a>";

                }
            } else {
                echo "<a href='connexion.php'>Se connecter</a>";
            }
            ?>
        </nav>

    </header>
    <!-------------------------------------------------------------->

    <section class="livreOr">
        <h1>Mon profil</h1>
        <?php
        // Requête SQL 
        $sql = "SELECT  login AS 'Identifiant', password AS 'Mot de passe'
    FROM utilisateurs WHERE id='" . $_SESSION['id'] . "'";
        $sql_resultat = $sql_connexion->query($sql);
        //-------------------------------------------------------------------------------
        echo "<span class='info'>Identifiant : " . $_SESSION['login'] . " / Mot de passe : " . $_SESSION['password'] . "</span>";
        if ($error == true) {
            echo $error_message;
        } elseif ($validation == true) {
            echo $validation_message;
        }
        ?>
        <div class="modif">
            <span>Modifier mes informations</span>
            <div class="modif_int">
                <form method='post' action='profil.php'>
                    <label for='login'>Identifiant</label>
                    <input type='text' name='login' id='login' value='<?= $_SESSION['login'] ?>'
                        placeholder='Identifiant' required>
                    <button type='submit' name='update_login'>Ok</button>
                </form>

                <form method='post' action='profil.php'>
                    <label for='mdp'>Mot de passe</label>
                    <div>
                        <input type='password' name='password' id='mdp' placeholder='Mot de passe' required>
                        <input type='password' name='confirm_password' placeholder='Confirmation du mot de passe'
                            required>
                    </div>
                    <button type='submit' name='update_password'>Ok</button>
                </form>
            </div>
        </div>
        <form method='post' action='profil.php'>
            <button class="deconnexion" type='submit' name='deco'>Déconnexion</button>
        </form>
        <h2>Mes commentaires</h2>
        <!--Affichage des commentaires---------------------------------------------------------------------->
        <?php
        // Requête SQL
        $sql = "SELECT date, commentaire
    FROM commentaires WHERE id_utilisateur='" . $_SESSION['id'] . "'";
        $sql_resultat = $sql_connexion->query($sql);
        //-------------------------------------------------------------------------------
        while ($row = mysqli_fetch_array($sql_resultat, MYSQLI_ASSOC)) {
            echo "<div class='commentaire'>";
            echo "<span class='date'>le : <span>" . substr($row["date"],8,-9) . " / " . substr($row["date"],5,-12) . " / " . substr($row["date"],0,4) .  "</span> à <span>" . substr($row["date"],11) . "</span></span>";
            echo "<span class='message'><span>“ </span>" . ($row["commentaire"]) . "<span> ”</span></span></div>";
        }
        ?>
        <!---------------------------------------------------------------------------------------------------->




    </section>
    <footer>
        <p>./ Jessy Charlet // $Job ['livre-d.or']</p>
    </footer>
</body>