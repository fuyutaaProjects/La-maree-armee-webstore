<?php
include("db.php");

if (empty($_POST["texte_commentaire"])) {
    echo "Le champ commentaire est requis.";
    exit();
}

$texte_commentaire = $_POST["texte_commentaire"];
$pseudo = $_POST["pseudo"]; // (champ masqué)
$id_produit = $_POST["prod_id"];

$media_commentaire = "";

if (isset($_FILES["media_commentaire"]) && !empty($_FILES["media_commentaire"]["name"])) {
    // Chemin de stockage pour le média des commentaires
    $upload_dir = "img_commentaires/";
    $media_commentaire = $upload_dir . basename($_FILES["media_commentaire"]["name"]);
    
    // Vérifier si le fichier est une image
    $check = getimagesize($_FILES["media_commentaire"]["tmp_name"]);
    if ($check === false) {
        echo "Le fichier n'est pas une image.";
        echo "<br><a href='produit.php?p=$id_produit'>Retourner à la page du produit</a>";
        exit();
    }

    // Déplacer le fichier vers le répertoire de destination
    if (!move_uploaded_file($_FILES["media_commentaire"]["tmp_name"], $media_commentaire)) {
        echo "Une erreur est survenue lors de l'upload du fichier.";
        echo "<br><a href='produit.php?p=$id_produit'>Retourner à la page du produit</a>";
        exit();
    }
}

$sql = "INSERT INTO commentaires (id_produit, pseudo, texte, media) VALUES ('$id_produit', '$pseudo', '$texte_commentaire', '$media_commentaire')";
if ($con->query($sql) === TRUE) {
    echo "Votre commentaire a été ajouté avec succès.";
    echo "<br><a href='produit.php?p=$id_produit'>Retourner à la page du produit</a>";
} else {
    echo "Erreur: " . $sql . "<br>" . $con->error;
}

$con->close();
?>
