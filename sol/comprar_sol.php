<?php

session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
if (!isset($_SESSION['user_id'])) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: index.php");
    exit;
}

require_once "../config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Elimina $id de aquí porque no lo estás recibiendo del formulario
    $persona = $_POST['persona'];
    $numero_serie = $_POST['numero_serie'];
    $color = $_POST['color'];
    $tratamiento = $_POST['tratamiento'];
    $cliente_id = $_POST['cliente_id'];
    $precio = $_POST['precio'];

    // No incluyas 'id' en la lista de columnas de INSERT
    $sql = "INSERT INTO sol (persona, numero_serie, color, tratamiento, cliente_id, precio)
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("ssssss", $persona, $numero_serie, $color, $tratamiento, $cliente_id, $precio);

    if ($stmt->execute()) {
        echo "Gafas de sol registradas correctamente";
        header("Location: ../sol/sol.php");
        exit();
    } else {
        echo "Error al registrar las gafas de sol: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
?>
