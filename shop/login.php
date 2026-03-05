<?php
include "db.php";
session_start();

if(isset($_POST["email"]) && isset($_POST["password"])){
    $email = mysqli_real_escape_string($con,$_POST["email"]);
    $password = md5($_POST["password"]); // C'est chiffré dans la database, donc on chiffre avant de faire le check
    $sql = "SELECT * FROM comptes WHERE email = '$email' AND password = '$password'";
    $run_query = mysqli_query($con,$sql);
    $cpt = mysqli_num_rows($run_query);
    if($cpt > 0){
        $ligne = mysqli_fetch_array($run_query);
        $_SESSION["uid"] = $ligne["user_id"];
        $_SESSION["pseudo"] = $ligne["pseudo"];
        $ip_add = getenv("REMOTE_ADDR");

        header("Location: index.php");
        exit();
    } else {
        echo "Identifiants incorrects.";
        header("refresh:2; url=index.php");
        exit();
    }
}
?>
