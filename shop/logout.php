<?php
session_start();

session_unset();
session_destroy();

// Début : Aide par ChatGPT
// Rediriger vers la page précédente ou l'accueil si la page précédente n'est pas disponible
if(isset($_SERVER['HTTP_REFERER'])) {
    header('Location: ' . $_SERVER['HTTP_REFERER']); // Fin: aide par chatgpt
} else {
    header('Location: index.php');
}
exit();
?>
