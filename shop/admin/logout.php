<?php
session_start();
session_destroy();
foreach ($_SESSION as $key => $value) {
    unset($_SESSION[$key]);
}

echo "<h1 style='text-align:center;'>Vous vous êtes déconnecté avec succès.</h1>"; // flemme de styliser via fichier, voir si edit later
header('Refresh: 2; URL=login.php');
exit;
?>
