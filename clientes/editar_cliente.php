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

    $sql = "UPDATE clientes SET 
                nombre = ?, 
                telefono = ?, 
                derechoEsfera = ?, 
                derechoCilindro = ?, 
                derechoEje = ?, 
                izquierdoEsfera = ?, 
                izquierdoCilindro = ?, 
                izquierdoEje = ? 
            WHERE id = ?";
    
    $stmt = $connection->prepare($sql);

    $stmt->bind_param(
        "ssssssssi", 
        $nombre, 
        $telefono, 
        $derechoEsfera, 
        $derechoCilindro, 
        $derechoEje, 
        $izquierdoEsfera, 
        $izquierdoCilindro, 
        $izquierdoEje, 
        $id
    );

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit();
    } else {
        echo "Error al intentar actualizar el cliente: " . $stmt->error;
    }

    $stmt->close();
    $connection->close();
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM clientes WHERE id='$id'";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cliente</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/styles.css">
    <style type="text/css">
         html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }
        body {
            font: 14px sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #74EBD5 0%, #ACB6E5 100%);
            
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="mt-4 mb-4">Editar cliente</h2>

        <form action="editar_cliente.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $row['id']; ?>"> <!-- Campo oculto para el ID del cliente -->
            <div class="form-group mb-4">
                <div class="row">
                    <label for="nombre" class="col-sm-2 col-form-label text-end">Nombre</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $row['nombre']; ?>" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="telefono" class="col-sm-2 col-form-label text-end">Teléfono *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="telefono" name="telefono" value="<?php echo $row['telefono']; ?>" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="derechoEsfera" class="col-sm-2 col-form-label text-end">Ojo derecho | esfera</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="derechoEsfera" name="derechoEsfera" value="<?php echo $row['derechoEsfera']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="derechoCilindro" class="col-sm-2 col-form-label text-end">Ojo derecho | cilindro</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="derechoCilindro" name="derechoCilindro" value="<?php echo $row['derechoCilindro']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="derechoEje" class="col-sm-2 col-form-label text-end">Ojo derecho | eje</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="derechoEje" name="derechoEje" value="<?php echo $row['derechoEje']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="izquierdoEsfera" class="col-sm-2 col-form-label text-end">Ojo izquierdo | esfera</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="izquierdoEsfera" name="izquierdoEsfera" value="<?php echo $row['izquierdoEsfera']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="izquierdoCilindro" class="col-sm-2 col-form-label text-end">Ojo izquierdo | cilindro</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="izquierdoCilindro" name="izquierdoCilindro" value="<?php echo $row['izquierdoCilindro']; ?>">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="izquierdoEje" class="col-sm-2 col-form-label text-end">Ojo izquierdo | eje</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="izquierdoEje" name="izquierdoEje" value="<?php echo $row['izquierdoEje']; ?>">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Guardar cambios</button>
            <a href="clientes.php" class="btn btn-secondary mb-4">Volver</a>
        </form>
    </div>
</body>
</html>
