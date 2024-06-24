<?php
session_start(); // Inicia la sesión

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: index.php");
    exit;
}

    require_once "../config.php";


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <style type="text/css">
        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            font: 14px sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #74EBD5 0%, #ACB6E5 100%);
            display: flex;
            flex-direction: column;
        }
    </style>
</head>

<body>
    <nav class="mt-4">
        <a href="../graduadas/graduadas.php">Graduadas</a> |
        <a href="../sol/sol.php">Sol</a> |
        <a href="../clientes/clientes.php">Clientes</a> |
        <a href="../logout.php">Cerrar sesión</a>
    </nav>

    <div class="container">
        <h2 class="mt-4 mb-4">Registro de Clientes</h2>

        <!-- Formulario para agregar nuevos registros -->
        <form action="crear_cliente.php" method="POST">
            <div class="form-group mb-4">
                <div class="row">
                    <label for="id" class="col-sm-2 col-form-label text-end">ID *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="id" name="id" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="nombre" class="col-sm-2 col-form-label text-end">Nombre *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="telefono" class="col-sm-2 col-form-label text-end">Teléfono *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="derechoEsfera" class="col-sm-2 col-form-label text-end">Ojo derecho | esfera</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="derechoEsfera" name="derechoEsfera">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="derechoCilindro" class="col-sm-2 col-form-label text-end">Ojo derecho | cilindro</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="derechoCilindro" name="derechoCilindro">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="derechoEje" class="col-sm-2 col-form-label text-end">Ojo derecho | eje</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="derechoEje" name="derechoEje">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="izquierdoEsfera" class="col-sm-2 col-form-label text-end">Ojo izquierdo | esfera</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="izquierdoEsfera" name="izquierdoEsfera">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="izquierdoCilindro" class="col-sm-2 col-form-label text-end">Ojo izquierdo | cilindro</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="izquierdoCilindro" name="izquierdoCilindro">
                    </div>
                </div>
            </div>
            <div class="form-group mb-4">
                <div class="row">
                    <label for="izquierdoEje" class="col-sm-2 col-form-label text-end">Ojo izquierdo | eje</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="izquierdoEje" name="izquierdoEje">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mb-4">Registrar Cliente</button>
        </form>
    </div>

    <?php

    

    // Obtener el término de búsqueda si existe
    $buscar = isset($_GET['buscar']) ? $_GET['buscar'] : '';

    // Consulta para seleccionar todos los datos de la tabla clientes o filtrados por nombre
    if ($buscar) {
        $sql = "SELECT id, nombre, telefono, derechoEsfera, derechoCilindro, derechoEje, izquierdoEsfera, izquierdoCilindro, izquierdoEje 
                FROM clientes 
                WHERE id LIKE '%" . $connection->real_escape_string($buscar) . "%'";
    } else {
        $sql = "SELECT id, nombre, telefono, derechoEsfera, derechoCilindro, derechoEje, izquierdoEsfera, izquierdoCilindro, izquierdoEje FROM clientes";
    }

    $result = $connection->query($sql);
    ?>

    <form action="clientes.php" method="GET" class="mb-4">
        <div class="form row ">
            <div class="col-sm-6 offset-sm-1">
                <input type="text" class="form-control" id="buscar" name="buscar" placeholder="Introduce el ID del cliente">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Buscar cliente</button>
                <a href="clientes.php" class="btn btn-secondary">Ver todos los clientes</a>

            </div>
        </div>
    </form>

    <div class="table-responsive mx-auto col-sm-10 mb-4">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Ojo derecho | esfera</th>
                    <th>Ojo derecho | cilindro</th>
                    <th>Ojo derecho | eje</th>
                    <th>Ojo izquierdo | esfera</th>
                    <th>Ojo izquierdo | cilindro</th>
                    <th>Ojo izquierdo | eje</th>
                    <th>Editar</th>
                    <th>Borrar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['nombre'] . "</td>";
                        echo "<td>" . $row['telefono'] . "</td>";
                        echo "<td>" . (isset($row['derechoEsfera']) ? $row['derechoEsfera'] : '') . "</td>";
                        echo "<td>" . (isset($row['derechoCilindro']) ? $row['derechoCilindro'] : '') . "</td>";
                        echo "<td>" . (isset($row['derechoEje']) ? $row['derechoEje'] : '') . "</td>";
                        echo "<td>" . (isset($row['izquierdoEsfera']) ? $row['izquierdoEsfera'] : '') . "</td>";
                        echo "<td>" . (isset($row['izquierdoCilindro']) ? $row['izquierdoCilindro'] : '') . "</td>";
                        echo "<td>" . (isset($row['izquierdoEje']) ? $row['izquierdoEje'] : '') . "</td>";
                        echo "<td><a href='editar_cliente.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Editar</a></td>";
                        echo "<td><a href='borrar_cliente.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm'>Borrar</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='10'>No se encontraron resultados.</td></tr>";
                }
                $connection->close();
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>