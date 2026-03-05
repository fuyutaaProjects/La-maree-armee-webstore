<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>La marée armée</title>
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
</head>
<body>
<!-- HEADER -->
<header>
    <!-- MAIN HEADER -->
    <div id="header" class="header-container">
        <!-- container -->
        <!-- LOGO -->
        <div class="header-titre">
            <a href="index.php" class="logo">
                <h3>La marée armée</h3>
            </a>
        </div>
        <!-- /LOGO -->

        <!-- Barre de recherche -->
        <form action="recherche.php" class="formulaire" method="GET">
            <input type="text" name="search" id="search" placeholder="Rechercher un produit">
            <button type="submit" class="button">Rechercher</button>
        </form>
        <!-- /Barre de recherche -->

        <!-- Compte -->
        <?php
            //ini_set('display_errors', 1);
            //ini_set('display_startup_errors', 1);
            //error_reporting(E_ALL);
            
            include "db.php";
            if(isset($_SESSION["uid"])){
                //echo "Session UID: ".$_SESSION["uid"]."<br>";
                $sql = "SELECT prenom,type_de_compte FROM comptes WHERE user_id='$_SESSION[uid]'";
                //echo "SQL Query: ".$sql."<br>"; // Debugging
                $query = mysqli_query($con,$sql);

                //echo "Number of rows: ".mysqli_num_rows($query)."<br>"; // Debugging
                
                if (!$query) {
                    printf("Error: %s\n", mysqli_error($con)); // Debugging
                    exit();
                }
                
                
                $ligne=mysqli_fetch_array($query);

                if($ligne) {
                    if ($ligne['type_de_compte'] == 1 || $ligne['type_de_compte'] == 2) {
                        echo '
                            <div class="dropdown">
                                <a href="#">Bienvenue '.$ligne["prenom"].'</a>
                                <div class="dropdown-content">
                                    <a href="profil.php">Mon profil</a>
                                    <a href="publication.php">Publication</a>
                                    <a href="liste_de_souhaits.php">Liste de souhaits</a>
                                    <a href="logout.php">Se déconnecter</a>
                                    </div>
                                    </div>';
                                } else {
                                    echo '
                                    <div class="dropdown">
                                    <a href="#">Bienvenue '.$ligne["prenom"].'</a>
                                    <div class="dropdown-content">
                                    <a href="profil.php">Mon profil</a>
                                    <a href="liste_de_souhaits.php">Liste de souhaits</a>
                                    <a href="logout.php">Se déconnecter</a>
                                </div>
                            </div>';
                    }
                } else { 
                    echo '
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" data-target="#Modal_login">Compte</a>
                        <div class="dropdown-content">
                            <a href="#" class="login-link" data-target="#Modal_login">Connexion</a>
                            <a href="#" class="register-link" data-target="#Modal_register">Inscription</a>
                        </div>
                    </div>';
                }
            }
            else{
                echo '
                <div class="dropdown">
                    <a href="#" class="dropdown-toggle" data-target="#Modal_login">Compte</a>
                    <div class="dropdown-content">
                        <a href="#" class="login-link" data-target="#Modal_login">Connexion</a>
                        <a href="#" class="register-link" data-target="#Modal_register">Inscription</a>
                    </div>
                </div>';
            }
        ?>
        <!-- /Compte -->

        <!-- Panier -->
        <a href="panier.php" class="panier-btn">
            <img src="./img/panier.png" alt="Panier">
        </a>
        <!-- /Panier -->
    </div>
    <!-- /MAIN HEADER -->

    <!-- NAVIGATION -->
    <nav id='categories'>
        <div class="container">
            <?php
            echo '<a href="index.php">Accueil</a>';
            include 'db.php';
            $categorie_query = "SELECT * FROM categories";
            $run_query = mysqli_query($con, $categorie_query);
            if (mysqli_num_rows($run_query) > 0) {
                while ($ligne = mysqli_fetch_array($run_query)) {
                    $cat_id = $ligne['cat_id'];
                    $cat_titre = $ligne['cat_title'];
                    echo "<a href='categorie.php?cat=$cat_id'>$cat_titre</a>";
                }
            }
            ?>
        </div>
    </nav>
</header>
<!-- /HEADER -->

<!-- MODALS -->
<div class="modal fade" id="Modal_login" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body" id="loginForm">
                <?php
                    include "login_form.php";
                ?>
            </div>

        </div>

    </div>
</div>
<div class="modal fade" id="Modal_register" role="dialog">
    <div class="modal-dialog" style="">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>

            </div>
            <div class="modal-body" id="registerForm">
                <?php
                    include "register_form.php";
                ?>
            </div>

        </div>

    </div>  
</div>
<!-- /MODALS -->

</body>
</html>

<script>
// AFFICHAGE DES MODALS: Aidé par ChatGPT pour l'idée du fonctionnement (le fait d'utiliser .style.display = "none" ou "block")
var loginBtn = document.querySelector('.login-link');
var registerBtn = document.querySelector('.register-link');

var loginModal = document.querySelector('#Modal_login');
var registerModal = document.querySelector('#Modal_register');

var closeLoginBtn = document.querySelector('#Modal_login .close');
var closeRegisterBtn = document.querySelector('#Modal_register .close');

// Afficher: Connexion
loginBtn.addEventListener('click', function() {
    loginModal.style.display = "block";
});

// Afficher: Inscription
registerBtn.addEventListener('click', function() {
    registerModal.style.display = "block";
});

// Fermer: Connexion
closeLoginBtn.addEventListener('click', function() {
    loginModal.style.display = "none";
});

// Fermer: Inscription
closeRegisterBtn.addEventListener('click', function() {
    registerModal.style.display = "none";
});
</script>
