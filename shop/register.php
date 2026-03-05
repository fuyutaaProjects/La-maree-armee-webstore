<?php
session_start();
include "db.php";

if (isset($_POST["prenom"])) {
    $f_name = $_POST["prenom"];
    $l_name = $_POST["nom"];
    $pseudo = $_POST['pseudo'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['repassword'];
    $mobile = $_POST['mobile'];
    $address1 = $_POST['address1']; // chemin
    $address2 = $_POST['address2']; // ville
    $departement = $_POST['departement']; // 5 chiffres code

    $name = "/^[a-zA-Z ]+$/";
    $emailValidation = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9]+(\.[a-z]{2,4})$/";
    $number = "/^[0-9]+$/";

    if(empty($f_name) || empty($l_name) || empty($pseudo) || empty($email) || empty($password) || empty($repassword) ||
        empty($mobile) || empty($address1) || empty($address2) || empty($departement)) {
        
        echo "
            <div class='alert alert-warning'>
                <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please Fill all fields..!</b>
            </div>
        ";
        header("refresh:2; url=index.php");
        exit();
    } else {
        if(!preg_match($name,$f_name)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>The first name $f_name is not valid..!</b>
                </div>
            ";
            header("refresh:2; url=index.php");
            exit();
        }
        if(!preg_match($name,$l_name)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>The last name $l_name is not valid..!</b>
                </div>
            ";
            header("refresh:2; url=index.php");
            exit();
        }
        if(!preg_match($emailValidation,$email)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>The email $email is not valid..!</b>
                </div>
            ";
            header("refresh:2; url=index.php");
            exit();
        }
        if($password != $repassword) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Passwords do not match</b>
                </div>
            ";
            header("refresh:2; url=index.php");
            exit();
        }
        if(!preg_match($number,$mobile)) {
            echo "
                <div class='alert alert-warning'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Mobile number $mobile is not valid</b>
                </div>
            ";
            header("refresh:2; url=index.php");
            exit();
        }

        // Empêcher d'avoir deux comptes avec la même adresse mail
        $sql = "SELECT user_id FROM comptes WHERE email = '$email' LIMIT 1" ;
        $check_query = mysqli_query($con,$sql);
        $count_email = mysqli_num_rows($check_query);
        if($count_email > 0) {
            echo "
                <div class='alert alert-danger'>
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>
                    <b>Cette adresse est déjà utilisée.</b>
                </div>
            ";
            header("refresh:2; url=index.php");
            exit();
        } 
        else {
            $password = md5($_POST['password']);
            
            // Insertion des données
            $sql = "INSERT INTO `comptes` (`user_id`, `pseudo`, `nom`, `prenom`, `email`, `password`, `mobile`, `address1`, `address2`, `departement`) VALUES (NULL, '$pseudo', '$f_name', '$l_name', '$email', '$password', '$mobile', '$address1', '$address2', '$departement')";
            $run_query = mysqli_query($con,$sql);
            $_SESSION["uid"] = mysqli_insert_id($con);
            $_SESSION["pseudo"] = $pseudo;
            $ip_add = getenv("REMOTE_ADDR");
            $sql = "UPDATE panier SET id_user = '$_SESSION[uid]' WHERE /*ip_add='$ip_add' AND*/ id_user = -1";
            if(mysqli_query($con,$sql)) {
                header("refresh:2; url=index.php");
                exit();
                exit;
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
                header("refresh:3; url=index.php");
            }           
        }
    }
}
?>
