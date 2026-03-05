<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La marée armée</title>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
</head>
<body class="body-background">
    <div class="transaction">
        <div class="transaction_info">
            <?php
            include "db.php";
            $utilisateur_id = $_SESSION['uid'];
            $select_query = "SELECT id_produit, id_user, id_vendeur FROM panier,produits WHERE panier.id_produit=produits.id";
            $select_run = mysqli_query($con,$select_query);
            if(mysqli_num_rows($select_run) > 0){
                while($select_ligne = mysqli_fetch_array($select_run)){
                    $trn_produit = $select_ligne['id_produit'];
                    $trn_acheteur = $select_ligne['id_user'];
                    $trn_vendeur = $select_ligne['id_vendeur'];
                    $maj_query = "UPDATE produits SET num_order = num_order + 1 WHERE id = $trn_produit";
                    mysqli_query($con,$maj_query);
                    $ajout_query = "INSERT INTO historique_achat(id_produit, id_acheteur, id_vendeur) VALUES ('$trn_produit', '$trn_acheteur', '$trn_vendeur')";
                    mysqli_query($con,$ajout_query);
                }
                $delete_query = "DELETE FROM panier WHERE id_user='$utilisateur_id'";
                mysqli_query($con, $delete_query);    
                $rand = rand(1, 5);
                sleep($rand);
                echo '
                <div class=trn_text>Transaction effectué avec succès, merci de votre achat</div>
                <img class=trn_img src="./img/thumbs_up_splatoon.png">';
            } else {
                echo "
                Votre panier est vide, remplissez le avant avec nos fabuleux articles";
            }
            ?>
        </div>
    </div>
</body>
</html>