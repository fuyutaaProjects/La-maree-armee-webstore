<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remove_from_panier'])) {
    $produit_id = $_POST['product_id'];
    if(isset($_SESSION['uid'])) {
        $id_utilisateur = $_SESSION['uid'];
        $suppr_query = "DELETE FROM panier WHERE id_produit='$produit_id' AND id_user='$id_utilisateur' LIMIT 1";
        mysqli_query($con, $suppr_query);
        echo "
        <script>alert('Produit supprimé au panier avec succès!');</script>";
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
    <?php
        if (!isset($_SESSION['uid'])) {
            echo "<p class='no_profil'><br><br>Vous n'êtes pas connecté, veuillez aller à l'accueil et vous (re)connecter si vous voulez accéder à votre panier.</p>";
            return;
        }
    ?>
    <div class='panier'>
        <h3 class='panier_titre'>Panier :</h3>
        <div class='panier_produit'>
            <div class='panier_produit_sub'>
            <?php
            $produit_query = "SELECT * FROM panier WHERE id_user={$_SESSION["uid"]}";
            $produit_query = "SELECT * FROM produits,categories,panier WHERE categorie=cat_id AND panier.id_user={$_SESSION["uid"]} AND panier.id_produit=produits.id";
            $run_query = mysqli_query($con,$produit_query);
            if(mysqli_num_rows($run_query) > 0){
                while($row = mysqli_fetch_array($run_query)){
                    $pro_id    = $row['id_produit'];
                    $pro_cat   = $row['categorie'];
                    $pro_title = $row['nom'];
                    $pro_price = $row['prix'];
                    $pro_image = $row['image'];
                    $cat_name = $row["cat_title"];
                    echo "
                    <div class='produit'>
                    <a href='produit.php?p=$pro_id'>
                    <div class='produit-img'>
                    <img src='img_produit/$pro_image' alt='$pro_title'>
                    </div>
                    </a>
                        <div class='produit-body'>
                            <p class='produit-categorie'>$cat_name</p>
                            <h3 class='produit-name'><a href='produit.php?p=$pro_id'>$pro_title</a></h3>
                            <h4 class='produit-price'>$pro_price <img src='img/power_eggs.png' alt='oeufs' class='oeufs-img'></h4>
                            <form method='post'>
                                <input type='hidden' name='product_id' value='$pro_id'>
                                <button type='submit' name='remove_from_panier' class='remove-from-panier-btn'>Retirer du panier</button>
                            </form>
                        </div>
                    </div>";
                }
            } else {
                $empty = 0;
            }
            ?>
        </div>
        <?php
        if(isset($empty)){
            echo "
            Votre panier est vide, mais vous pouvez le remplir avec les articles de notre boutique en ligne<br>";
        }
        ?>
        </div>
        <a href="transaction.php" class="pay-btn">
            <img src="./img/checkout.png" alt="Payer">
        </a>
    </div>
</body>
</html>
