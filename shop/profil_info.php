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
    <?php
        if (!isset($_SESSION['uid'])) {
            echo "<p class='no_profil'><br><br>Vous n'êtes pas connecté, veuillez aller à l'accueil et vous (re)connecter si vous voulez accéder à votre profil.</p>";
            return;
        }
    ?>
    <h1 class="profil_titre">Mon Profil</h1>
    <div class="profil">
        <?php
        $profil_query = "SELECT * FROM comptes WHERE user_id={$_SESSION["uid"]}";
        $run_query = mysqli_query($con,$profil_query);
        if(mysqli_num_rows($run_query) > 0){
            $ligne = mysqli_fetch_array($run_query);
            $profil_pseudo = $ligne['pseudo'];
            $profil_nom = $ligne['nom'];
            $profil_prenom = $ligne['prenom'];
            $profil_email = $ligne['email'];
            $profil_mobile = $ligne['mobile'];
            $profil_rue = $ligne['address1'];
            $profil_ville = $ligne['address2'];
            $profil_departement = $ligne['departement'];
            $profil_type_de_compte = $ligne['type_de_compte'];

            // type_de_compte contient 0 ou 1, s'il est vendeur ou non. 2 c'est si il est admin. On va donc créer la string qui sera utilisée dans l'affichage 
            $type_compte = '';
            switch ($profil_type_de_compte) {
                case 0:
                    $type_compte = 'Non vendeur';
                    break;
                case 1:
                    $type_compte = 'Vendeur';
                    break;
                case 2:
                    $type_compte = 'Administrateur';
                    break;
            }
            
            
            
            echo "
                <div class='nametag'>
                    <p class='profil_pseudo'>Pseudo : <br>$profil_pseudo</p>
                    <p class='profil_nom'>Nom, Prénom : <br>$profil_nom $profil_prenom</p>
                    <p class='profil_mobile'>Mobile : <br>$profil_mobile</p>
                    <p class='profil_email'>Email : <br>$profil_email</p>
                    <p class='profil_adresse'>Adresse de Facturation <br> $profil_rue $profil_ville, $profil_departement</p>
                    <p class='profil_email'>Type de Compte : <br>$type_compte</p>
                </div>";
        }
        ?>
        <div class='historique'>
        <h3 class='hist_achat_titre'>Historique des articles achetés :</h3>
            <div class='historique_achat'>
                <?php
                $produit_query = "SELECT * FROM produits,categories,historique_achat WHERE categorie=cat_id AND id_acheteur={$_SESSION["uid"]} AND id_produit=produits.id";
                $run_query = mysqli_query($con,$produit_query);
                /*
                // Vérification s'il y a des résultats
                if(mysqli_num_rows($run_query) > 0){
                    // Boucle à travers chaque ligne de résultat
                    while($ligne = mysqli_fetch_array($run_query)){
                        // Affichage des données de chaque ligne
                        print_r($ligne);
                    }
                } else {
                    echo "Aucun résultat trouvé.";
                }
                */
                if(mysqli_num_rows($run_query) > 0){
                    while($ligne = mysqli_fetch_array($run_query)){
                        $pro_id    = $ligne['id_produit'];
                        $pro_cat   = $ligne['categorie'];
                        $pro_title = $ligne['nom'];
                        $pro_price = $ligne['prix'];
                        $pro_image = $ligne['image'];
                        $cat_name = $ligne["cat_title"];
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
                                    <input type='hidden' name='produit_id' value='$pro_id'>
                                    <button type='submit' name='ajout_au_panier' class='add-to-panier-btn'>Ajouter au panier</button>
                                </form>
                            </div>
                        </div>";                           
                        }
                    }
                ?>
            </div>
            <h3 class='hist_vente_titre'>Historique des articles vendus :</h3>
            <div class='historique_vente'>
                <?php
                if($profil_type_de_compte==1){       
                    $produit_query = "SELECT * FROM produits,categories,historique_achat WHERE categorie=cat_id AND produits.id_vendeur={$_SESSION["uid"]} AND id_produit=produits.id";
                    $run_query = mysqli_query($con,$produit_query);
                    if(mysqli_num_rows($run_query) > 0){
                        while($ligne = mysqli_fetch_array($run_query)){
                            $pro_id    = $ligne['id_produit'];
                            $pro_cat   = $ligne['categorie'];
                            $pro_title = $ligne['nom'];
                            $pro_price = $ligne['prix'];
                            $pro_image = $ligne['image'];
                            $cat_name = $ligne["cat_title"];
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
                                        <input type='hidden' name='produit_id' value='$pro_id'>
                                        <button type='submit' name='ajout_au_panier' class='add-to-panier-btn'>Ajouter au panier</button>
                                    </form>
                                </div>
                            </div>";                                
                            }
                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>
