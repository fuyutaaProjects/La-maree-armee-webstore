<?php
include("../db.php");

if (isset($_GET['id'])) {
    $produitId = $_GET['id'];

    $query = "DELETE FROM produits WHERE id = '$produitId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        http_response_code(204);
        exit();
    } else {
        http_response_code(500);
        exit('Erreur lors de la suppression du produit');
    }
} else {
    http_response_code(400);
    exit('ID du produit non spécifié');
}
?>
