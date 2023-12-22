<?php
session_start();
//--SQL-------------------------------------------------------------
$sql_serveur = "localhost:3306";
$sql_utilisateur = "jessy-charlet";
$sql_motDePasse = "Test1304+++";
$sql_baseDeDonnees = "jessy-charlet_livreor";

$sql_connexion = new mysqli($sql_serveur, $sql_utilisateur, $sql_motDePasse, $sql_baseDeDonnees);

if (empty($_SESSION['login'])) {
    $_SESSION['login'] = "";
}


$sql = "SELECT login, date, commentaire FROM commentaires
INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
ORDER BY date DESC";

if (isset($_POST['trier'])) {
    $recuptrie = $_POST['trier'];
    if ($recuptrie == 'old') {
        $sql = "SELECT login, date, commentaire FROM commentaires
    INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
    ORDER BY date ASC";
    } elseif ($recuptrie == 'new') {
        $sql = "SELECT login, date, commentaire FROM commentaires
    INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
    ORDER BY date DESC";
    } elseif ($recuptrie == 'az') {
        $sql = "SELECT login, date, commentaire FROM commentaires
    INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
    ORDER BY login ASC";
    } elseif ($recuptrie == 'za') {
        $sql = "SELECT login, date, commentaire FROM commentaires
    INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
    ORDER BY login DESC";
    } else {
        $sql = "SELECT login, date, commentaire FROM commentaires
    INNER JOIN utilisateurs ON commentaires.id_utilisateur = utilisateurs.id
    ORDER BY date DESC";
    }



}
?>
<!--HEAD-------------------------------------------------------->
<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Livre d'or</title>
    <meta charset="UTF-8">
    <meta name="description" content="Livre d'or du Club des baby-sitters">
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
        <h1>Livre d'or</h1>
        <nav>
            <a class="bouton" href="commentaire.php">Écrire un commentaire</a>

        <form class="trier" method="post" action="livre-or.php">
            <select name="trier" id="trier" onChange="this.form.submit()">
                <option value="">Trier les commentaires par</option>
                <option value="old">Plus ancien</option>
                <option value="new">Plus récent</option>
                <option value="az">Profil de A à Z</option>
                <option value="za">Profil de Z à A</option>
            </select>
        </form>
        </nav>
        <!--Affichage des commentaires---------------------------------------------------------------------->
        <?php
        if (isset($_SESSION['validation'])) {
            echo "<span class='validation'>Votre message a bien pubilé !</span>";
            unset($_SESSION['validation']);
        }
        // Requête SQL
        if (isset($_POST['trier'])) {

        }
        $sql_resultat = $sql_connexion->query($sql);
    
        //-------------------------------------------------------------------------------
        while ($row = mysqli_fetch_array($sql_resultat, MYSQLI_ASSOC)) {
            if ($_SESSION['login'] == $row["login"]){
                $idc = 'commentaireperso';
            }
            else {
                $idc = 'commentaire';
            }
            echo "<div class='".$idc."'>";
            echo "<span class='pseudo'>Publié par : <span>" . $row["login"] . "</span> </span>";
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