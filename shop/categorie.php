<?php
include "header.php";

if (isset($_GET['cat'])) {
    $cat_id = $_GET['cat'];
    include 'body_categorie.php';
} else {
    echo "No categorie selected.";
}

include "footer.php";

?>