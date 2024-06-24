<?php
// Iniciar la sesión
session_start();

// Verifica si el usuario ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Destruye todas las variables de sesión
    $_SESSION = array();

    // Destruye la sesión
    session_destroy();
}

// Redirige al usuario a la página de inicio de sesión
header("Location: index.php");
exit;
?>
