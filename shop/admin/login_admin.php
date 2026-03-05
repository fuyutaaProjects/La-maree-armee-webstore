<?php
session_start();
include '../db.php';
extract($_POST);
$motdepasse_md5 = md5($motdepasse);

$qry = mysqli_query($con, "SELECT * FROM comptes where email = '$email' and password = '$motdepasse_md5' and type_de_compte = 2");
if(mysqli_num_rows($qry) > 0){
    $ligne = mysqli_fetch_assoc($qry);
    $_SESSION["uid"] = $ligne["user_id"];
    header('Location: index.php');
} else {
    header('Location: login.php');
}
?>
