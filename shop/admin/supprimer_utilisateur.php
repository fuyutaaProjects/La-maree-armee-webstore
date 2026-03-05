<?php
include("header_admin.php");
include("../db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["user_id"])) {
    $user_id = $_POST["user_id"];
    $sql_1 = "DELETE FROM produits WHERE id_vendeur = $user_id";
    $result = mysqli_query($con, $sql_1);

    $sql_2 = "DELETE FROM panier WHERE id_user = $user_id";
    $result = mysqli_query($con, $sql_2);

    $sql_3b = "SELECT pseudo FROM comptes WHERE user_id = $user_id";
    $result = mysqli_query($con, $sql_3b);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $pseudo = $row['pseudo'];
            $sql_3 = "DELETE FROM commentaires WHERE pseudo = '$pseudo'";
            $result = mysqli_query($con, $sql_3);
        }
    }

    $sql_4 = "DELETE FROM historique_achat WHERE id_acheteur = $user_id OR id_vendeur = $user_id";
    $result = mysqli_query($con, $sql_4);

    $sql_5 = "DELETE FROM liste_de_souhaits WHERE id_compte = $user_id";
    $result = mysqli_query($con, $sql_5);

    $sql = "DELETE FROM comptes WHERE user_id = $user_id";
    $result = mysqli_query($con, $sql);

    if ($result) {
        echo "<p>Suppression réussie.</p>";
        header("Refresh: 2; URL=liste_des_utilisateurs.php");
        exit;
    } else {
        echo "<p>Échec de la suppression.</p>";
        header("Refresh: 2; URL=liste_des_utilisateurs.php");
        exit;
    }
}
?>
