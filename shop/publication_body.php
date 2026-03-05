<?php
$message = "";

if(!isset($_SESSION['uid'])) {
    echo "<p class='connexion-msg'>Connectez-vous pour pouvoir poster une annonce</p>";
    exit();
}

// Vérifier si le formulaire de publication d'annonce a été post (il est envoyé à self)
if($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST["nom_arme"]) && isset($_POST["categorie"]) && isset($_POST["prix"]) && isset($_POST["niveau"]) && isset($_POST["portee"]) && isset($_POST["vitesse_encrage"]) && isset($_POST["legeretee"]) && isset($_FILES["image"])) {
        include_once("db.php");

        $nom_arme = $_POST["nom_arme"];
        $categorie = $_POST["categorie"];
        $prix = $_POST["prix"];
        $niveau = $_POST["niveau"];
        $portee = $_POST["portee"];
        $vitesse_encrage = $_POST["vitesse_encrage"];
        $legeretee = $_POST["legeretee"];
        $image_name = $_FILES["image"]["name"];
        $image_tmp = $_FILES["image"]["tmp_name"];

        $id_vendeur = $_SESSION['uid'];

        $dir = "img_produit/";

        // Vérifier si une image avec le même nom existe déjà, si c'est le cas on va avoir un problème pour stocker: on renomme l'image du coup. ça pourrait aussi être une faille
        // de sécurité si on peut edit les photos des autres.
        $i = 1;
        while(file_exists($dir . $image_name)) {
            $info = pathinfo($image_name);
            $image_name = $info['filename'] . '_' . $i . '.' . $info['extension'];
            $i++;
        }

        // Déplacer l'image dans le dossier img_produit
        move_uploaded_file($image_tmp, $dir . $image_name);

        $sql = "INSERT INTO produits (categorie, nom, prix, niveau, portee, vitesse_encrage, legeretee, image, id_vendeur) VALUES ('$categorie', '$nom_arme', '$prix', '$niveau', '$portee', '$vitesse_encrage', '$legeretee', '$image_name', '$id_vendeur')";
        if ($con->query($sql) === TRUE) {
            $message = "Annonce publiée avec succès!";
        } else {
            $message = "Erreur: " . $sql . "<br>" . $con->error;
        }

        $con->close();
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
    <div class="publication">
        <?php if (!empty($message)) { ?>
            <p><?php echo $message; ?></p>
            <a class="button" href="index.php">Retourner à l'accueil</a>
        <?php } else { ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                <label for="nom_arme">Nom de l'arme:</label><br>
                <input type="text" id="nom_arme" name="nom_arme"><br>

                <label for="categorie">Catégorie:</label><br>
                <select id="categorie" name="categorie">
                    <?php
                    include_once("db.php");

                    $sql = "SELECT cat_id, cat_title FROM categories";
                    $resultat = $con->query($sql);

                    if ($resultat->num_rows > 0) {
                        while($row = $resultat->fetch_assoc()) {
                            echo "<option value='" . $row["cat_id"] . "'>" . $row["cat_title"] . "</option>";
                        }
                    } else {
                        echo "0 results";
                    }
                    ?>
                </select><br>

                <label for="prix">Prix:</label><br>
                <input type="text" id="prix" name="prix"><br>

                <label for="niveau">Niveau:</label><br>
                <input type="text" id="niveau" name="niveau"><br>

                <label for="portee">Portée:</label><br>
                <input type="text" id="portee" name="portee"><br>

                <label for="vitesse_encrage">Vitesse d'encrage:</label><br>
                <input type="text" id="vitesse_encrage" name="vitesse_encrage"><br>

                <label for="legeretee">Légereté:</label><br>
                <input type="text" id="legeretee" name="legeretee"><br>

                <label for="image">Image:</label><br>
                <input type="file" id="image" name="image"><br><br>

                <input type="submit" value="Publier">
            </form>
        <?php } ?>
    </div>
</body>
</html>
