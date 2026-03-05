<?php
session_start();
include '../db.php';

// Vérifier si le user est co
if (!isset($_SESSION['uid'])) {
    header('Location: login.php');
    exit();
}

// Vérifier si c'est un admin
$user_id = $_SESSION['uid'];
$query = "SELECT * FROM comptes WHERE user_id = '$user_id' AND type_de_compte = 2"; // Remplacer '==' par '='
$result = mysqli_query($con, $query);

if ($result) {
    if (mysqli_num_rows($result) == 0) {
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit();
    }
} 
else {
    echo "Erreur SQL : " . mysqli_error($con);
}
?>
