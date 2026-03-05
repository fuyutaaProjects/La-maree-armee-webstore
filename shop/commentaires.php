<?php
include("db.php");

if (isset($_GET['p'])) {
    $prod_id = $_GET['p'];
} else {
    echo "L'ID du produit n'est pas spécifié dans l'URL.";
    exit();
}
?>

<div class="espace_commentaires">
    <h3 class="titre_commentaire">Commentaires</h3>

    <?php
    if (isset($_SESSION['uid'])) {
        echo "<div class='laisser_commentaire'>";
        echo "<h3>Laissez un commentaire</h3>";
        echo "<form action='ajouter_commentaire.php' method='post' enctype='multipart/form-data'>";
        echo "<input type='hidden' name='prod_id' value='$prod_id'>";
        echo "<input type='hidden' name='pseudo' value='" . $_SESSION['pseudo'] . "'>";
        echo "<textarea name='texte_commentaire' placeholder='Votre commentaire'></textarea><br>";
        echo "<input type='file' name='media_commentaire'><br>";
        echo "<input type='submit' value='Poster'>";
        echo "</form>";
        echo "</div>";
    } else {
        echo "<p>Veuillez vous connecter pour laisser un commentaire.</p>";
    }
    ?>

    <?php
    // Affichage des commentaires
    $requete_commentaires = "SELECT * FROM commentaires WHERE id_produit=$prod_id";
    $resultat_commentaires = mysqli_query($con, $requete_commentaires);

    if (mysqli_num_rows($resultat_commentaires) > 0) {
        while ($commentaire = mysqli_fetch_array($resultat_commentaires)) {
            $texte_commentaire = $commentaire['texte'];
            $auteur_commentaire = $commentaire['pseudo'];
            $media_commentaire = $commentaire['media'];

            // Afficher le commentaire avec ou sans le média img
            echo "<div class='chaque_commentaire'>";
            echo "<p><strong>$auteur_commentaire :</strong> $texte_commentaire</p>";
            if (!empty($media_commentaire)) {
                echo "<img src='$media_commentaire' alt='Média du commentaire'>";
            }
            echo "</div>";
        }
    } else {
        echo "
        <div class='chaque_commentaire'>
            <p>Pas de commentaires sur ce produit</p>
        </div>";
    }
    ?>
</div>
