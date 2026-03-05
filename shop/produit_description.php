<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout_au_panier'])) {
    $produit_id = $_POST['produit_id'];
    if(isset($_SESSION['uid'])) {
        $utilisateur_id = $_SESSION['uid'];
        $ajout_query = "INSERT INTO panier (id_produit, id_user) VALUES ('$produit_id', '$utilisateur_id')";
        mysqli_query($con, $ajout_query);
        echo "<script>alert('Produit ajouté au panier avec succès!');</script>";
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La marée armée</title>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
</head>
<body class="body-background">
    <div class="produit_desc">
        <div class="description-container">
            <?php
            $produit_query = "SELECT * FROM produits, categories WHERE categorie=cat_id AND id=$prod_id";
            $run_query = mysqli_query($con,$produit_query);
            if(mysqli_num_rows($run_query) > 0){
                $row = mysqli_fetch_array($run_query);
                $pro_id    = $row['id'];
                $pro_cat   = $row['categorie'];
                $pro_nom = $row['nom'];
                $pro_prix = $row['prix'];
                $pro_image = $row['image'];
                $cat_nom = $row["cat_title"];

                // Description
                $niveau = $row['niveau'];
                $portee = $row['portee'];
                $vitesse_encrage = $row['vitesse_encrage'];
                $legeretee = $row['legeretee'];
                echo "
                <div class='produit-img-desc'>
                    <img src='img_produit/$pro_image' alt='$pro_nom'>
                </div>
                <div class='produit-body-desc'>
                    <h3 class='produit-name-desc'>$pro_nom</h3>
                    <p class='produit-categorie-desc'><a href='categorie.php?cat=$pro_cat'>$cat_nom</a></p>
                    <ul>
                        <li>Niveau requis: $niveau</li>
                        <li>Portée: $portee</li>
                        <li>Vitesse d'encrage: $vitesse_encrage</li>
                        <li>Légèreté: $legeretee</li>
                        </ul>
                    <h4 class='produit-price-desc'>$pro_prix <img src='img/power_eggs.png' alt='oeufs' class='oeufs-img'></h4>
                    ";
                // Affiche le bouton si le user est connecté
                if (isset($_SESSION['uid'])) {
                    echo "
                    <form method='post'>
                        <input type='hidden' name='produit_id' value='$pro_id'>
                        <button type='submit' name='ajout_au_panier' class='add-to-panier-btn'>Ajouter au panier</button>
                    </form>";
                } else {
                    echo "<p class='connexion-msg'>Connectez-vous pour ajouter au panier</p>";
                }
                echo "</div>";

                include 'commentaires.php';
            }
            ?>
        </div>
    </div>
</body>
</html>
