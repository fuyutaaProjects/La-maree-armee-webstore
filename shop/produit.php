<?php
include "header.php";

if (isset($_GET['p'])) {
    $prod_id = $_GET['p'];
    include 'produit_description.php';
} else {
    echo "Pas de catégorie sélectionnée.";
}

include "footer.php";

?>