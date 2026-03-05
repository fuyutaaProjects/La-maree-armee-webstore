<?php
    include 'db.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_to_panier'])) {
        $produit_id = $_POST['produit_id'];
        if(isset($_SESSION['uid'])) {
            $utilisateur_id = $_SESSION['uid'];
            $insert_query = "INSERT INTO panier (id_produit, id_user) VALUES ('$produit_id', '$utilisateur_id')";
            mysqli_query($con, $insert_query);
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
        <div class="boutique">
            <h3>Résultats de recherche</h3>
        </div>

        <div class="main main-raised">
            <div class="section">
                <div class="container">
                    <div class="produits-container">
                    <?php
                        if(isset($_GET['search'])) {
                            $search = mysqli_real_escape_string($con, $_GET['search']);

                            $sql = "SELECT * FROM produits,categories WHERE categorie=cat_id AND nom LIKE '%$search%' ORDER BY RAND()";
                            $resultat = mysqli_query($con, $sql);

                            if(mysqli_num_rows($resultat) > 0) {
                                while($ligne = mysqli_fetch_assoc($resultat)) {
                                    $pro_id    = $ligne['id'];
                                    $pro_cat   = $ligne['categorie'];
                                    $pro_nom = $ligne['nom'];
                                    $pro_prix = $ligne['prix'];
                                    $pro_image = $ligne['image'];
                                    $cat_nom = $ligne["cat_title"];

                                    // Récupérer le pseudo du vendeur
                                    $query_vendeur = "SELECT pseudo FROM comptes WHERE user_id = " . $ligne['id_vendeur'];
                                    $result_vendeur = mysqli_query($con, $query_vendeur);
                                    $vendeur = "";
                                    if ($result_vendeur && mysqli_num_rows($result_vendeur) > 0) {
                                        $vendeur_row = mysqli_fetch_assoc($result_vendeur);
                                        $vendeur = $vendeur_row['pseudo'];
                                    }

                                    echo "
                                    <div class='produit'>
                                        <a href='produit.php?p=$pro_id'>
                                            <div class='produit-img'>
                                                <img src='img_produit/$pro_image' alt='$pro_nom'>
                                            </div>
                                        </a>
                                        <div class='produit-body'>
                                            <p class='produit-categorie'>$cat_nom</p>
                                            <h3 class='produit-name'><a href='produit.php?p=$pro_id'>$pro_nom</a></h3>
                                            <p class='produit-vendeur'>Vendu par: $vendeur</p>
                                            <h4 class='produit-price'>$pro_prix <img src='img/power_eggs.png' alt='oeufs' class='oeufs-img'></h4>
                                            <form method='post'>
                                                <input type='hidden' name='produit_id' value='$pro_id'>
                                                <button type='submit' name='add_to_panier' class='add-to-panier-btn'>Ajouter au panier</button>
                                            </form>
                                        </div>
                                    </div>";
                                }
                            } else {
                                echo "Aucun résultat trouvé.";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
