<?php
        if (!isset($_SESSION['uid'])) {
            echo "<p class='no_profil'><br><br>Vous n'êtes pas connecté, veuillez aller à l'accueil et vous (re)connecter si vous voulez accéder à votre profil.</p>";
            return;
        }
?>
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

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['supprimer_de_la_liste'])) {
    $produit_id = $_POST['produit_id'];
    $utilisateur_id = $_SESSION['uid'];
    
    $suppression_query = "DELETE FROM liste_de_souhaits WHERE id_produit = '$produit_id' AND id_compte = '$utilisateur_id'";
    mysqli_query($con, $suppression_query);

    echo "<script>alert('Produit supprimé de la liste avec succès!');</script>";
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

    <div class="liste-de-souhaits">
        <div class="liste-de-souhaits-header">
            <h1>Liste des souhaits (achats pour plus tard)</h1>
        </div>
        <div class="liste-de-souhaits-content">
            <?php
            $user_id = $_SESSION['uid'];

            $query = "SELECT * FROM liste_de_souhaits WHERE id_compte = '$user_id'";
            $result = mysqli_query($con, $query);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $pro_id = $row['id_produit'];

                    $query_produit = "SELECT * FROM produits WHERE id = '$pro_id'";
                    $result_produit = mysqli_query($con, $query_produit);
                    $row_produit = mysqli_fetch_assoc($result_produit);
                    
                    
                    if ($row_produit) {
                        $pro_nom = $row_produit['nom'];
                        $pro_image = $row_produit['image'];
                        $cat_nom = $row_produit['categorie'];
                        $pro_prix = $row_produit['prix'];
                        
                        // Récupérer le titre de la catégorie
                        $query_cat = "SELECT cat_title FROM categories WHERE cat_id = '$cat_nom'";
                        $result_cat = mysqli_query($con, $query_cat);
                        $row_cat = mysqli_fetch_assoc($result_cat);
                        $cat_nom = $row_cat['cat_title'];

                        // Récupérer le pseudo du vendeur
                        $id_vendeur = $row_produit['id_vendeur'];
                        $query_vendeur = "SELECT pseudo FROM comptes WHERE user_id = '$id_vendeur'";
                        $result_vendeur = mysqli_query($con, $query_vendeur);
                        $row_vendeur = mysqli_fetch_assoc($result_vendeur);
                        $vendeur = $row_vendeur['pseudo'];

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
                                    <button type='submit' name='supprimer_de_la_liste' class='red-btn'>Supprimer de la liste</button>
                                </form>
                            </div>
                        </div>";
                    }
                }
            } else {
                echo "<p>Votre liste de souhaits est vide.</p>";
            }
            ?>
        </div>
    </div>
</body>