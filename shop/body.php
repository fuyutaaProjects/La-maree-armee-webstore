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
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['ajout_a_la_liste_de_souhaits'])) {
    $produit_id = $_POST['produit_id'];
    if(isset($_SESSION['uid'])) {
        $utilisateur_id = $_SESSION['uid'];
        $ajout_query = "INSERT INTO liste_de_souhaits (id_produit, id_compte) VALUES ('$produit_id', '$utilisateur_id')";
        mysqli_query($con, $ajout_query);
        echo "<script>alert('Produit ajouté à la wishlist avec succès!');</script>";
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
    <div class="populaire">
        <div class="populaire_titre">
            <h3>Produits populaires !!!</h3>
        </div>     
        <div class="populaires_produits">
            <?php
            $produit_query = "SELECT * FROM produits,categories WHERE categorie=cat_id ORDER BY num_order DESC LIMIT 5";
            $run_query = mysqli_query($con,$produit_query);
            if(mysqli_num_rows($run_query) > 0){
                while($row = mysqli_fetch_array($run_query)){
                    $pro_id    = $row['id'];
                    $pro_cat   = $row['categorie'];
                    $pro_nom = $row['nom'];
                    $pro_prix = $row['prix'];
                    $pro_image = $row['image'];
                    $cat_nom = $row["cat_title"];

                    // Récupérer le pseudo du vendeur
                    $query_vendeur = "SELECT pseudo FROM comptes WHERE user_id = " . $row['id_vendeur'];
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
                                <button type='submit' name='ajout_au_panier' class='add-to-panier-btn'>Ajouter au panier</button>
                            </form>
                            <form method='post'>
                                <input type='hidden' name='produit_id' value='$pro_id'>
                                <button type='submit' name='ajout_a_la_liste_de_souhaits' class='add-to-panier-btn'>Ajouter à la wishlist</button>
                            </form>
                            </div>
                    </div>";                            
                }
            }
            ?>
        </div>
    </div>
    <div class="boutique">
        <h3>Boutique</h3>
    </div> 
    <div class="main main-raised">
        <div class="section">
            <div class="container">
                <div class="produits-container">
                    <?php
                    $produit_query = "SELECT * FROM produits,categories WHERE categorie=cat_id  order by RAND()";
                    $run_query = mysqli_query($con,$produit_query);
                    if(mysqli_num_rows($run_query) > 0){
                        while($row = mysqli_fetch_array($run_query)){
                            $pro_id    = $row['id'];
                            $pro_cat   = $row['categorie'];
                            $pro_nom = $row['nom'];
                            $pro_prix = $row['prix'];
                            $pro_image = $row['image'];
                            $cat_nom = $row["cat_title"];
                            
                            // Récupérer le pseudo du vendeur
                            $query_vendeur = "SELECT pseudo FROM comptes WHERE user_id = " . $row['id_vendeur'];
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
                                        <button type='submit' name='ajout_au_panier' class='add-to-panier-btn'>Ajouter au panier</button>
                                    </form>
                                    <form method='post'>
                                        <input type='hidden' name='produit_id' value='$pro_id'>
                                        <button type='submit' name='ajout_a_la_liste_de_souhaits' class='add-to-panier-btn'>Ajouter à la wishlist</button>
                                    </form>
                                </div>
                            </div>";                              
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
