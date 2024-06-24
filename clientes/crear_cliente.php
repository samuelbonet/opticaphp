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
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $derechoEsfera = !empty($_POST['derechoEsfera']) ? $_POST['derechoEsfera'] : NULL;
    $derechoCilindro = !empty($_POST['derechoCilindro']) ? $_POST['derechoCilindro'] : NULL;
    $derechoEje = !empty($_POST['derechoEje']) ? $_POST['derechoEje'] : NULL;
    $izquierdoEsfera = !empty($_POST['izquierdoEsfera']) ? $_POST['izquierdoEsfera'] : NULL;
    $izquierdoCilindro = !empty($_POST['izquierdoCilindro']) ? $_POST['izquierdoCilindro'] : NULL;
    $izquierdoEje = !empty($_POST['izquierdoEje']) ? $_POST['izquierdoEje'] : NULL;

    $sql = "INSERT INTO clientes (id,nombre,telefono,derechoEsfera,derechoCilindro,derechoEje,izquierdoEsfera,izquierdoCilindro,izquierdoEje)
    VALUES (?,?,?,?,?,?,?,?,?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssssssss", $id, $nombre, $telefono, $derechoEsfera, $derechoCilindro, $derechoEje, $izquierdoEsfera, $izquierdoCilindro, $izquierdoEje);

    if ($stmt->execute()) {
        header("Location: ../clientes/clientes.php");
        exit();
    } else {
        echo "Error al crear cliente: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
}
