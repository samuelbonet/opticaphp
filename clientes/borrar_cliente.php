<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: index.php");
    exit;
}
require_once "../config.php";


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];

    // Consulta para eliminar el cliente con el ID específico
    $sql = "DELETE FROM clientes WHERE id = ?";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit(); // Asegura que no se ejecute más código después de redirigir
    } else {
        echo "Error al intentar eliminar el cliente: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
} else {
    echo "No se proporcionó un ID válido para eliminar.";
}
?>
