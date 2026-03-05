<?php
include("../db.php");

function getNumberOfUsers($con) {
    $query = "SELECT COUNT(*) as total FROM comptes";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getNumberOfAnnonces($con) {
    $query = "SELECT COUNT(*) as total FROM produits";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}

function getNumberOfCommandes($con) {
    $query = "SELECT COUNT(*) as total FROM historique_achat";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total'];
}
?>

<div class="container dashboard-container">
    <div class="card">
        <div class="card-header-primary">
            Utilisateurs
        </div>
        <div class="card-body">
            <?php
                $nombreDeUsers = getNumberOfUsers($con);
                echo "<p>$nombreDeUsers</p>"; 
            ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header-primary">
            Annonces

        </div>
        <div class="card-body">
            <?php
                $nombreDAnnonces = getNumberOfAnnonces($con);
                echo "<p>$nombreDAnnonces</p>"; 
            ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header-primary">
            Commandes
        </div>
        <div class="card-body">
            <?php
            $nombreDeCommandes = getNumberOfCommandes($con);
            echo "<p>$nombreDeCommandes</p>"; 
            ?>
        </div>
    </div>
</div>