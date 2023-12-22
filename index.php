<?php
session_start();




?>


<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Index</title>
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
    <section class="logo">
        <img src="./media/logo-le-club-des-baby-sitters-home.png" alt="Logo du club des baby-sitters">
    </section>
    <footer>
        <p>./ Jessy Charlet // $Job ['livre-d.or']</p>
    </footer>
</body>