<?php

session_start(); // Inicia la sesión

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Redirige al usuario a la página de inicio de sesión si no está autenticado
    header("Location: index.php");
    exit;
}
require_once "../config.php";

$sql_enum_persona = "SHOW COLUMNS FROM graduadas WHERE Field = 'persona'";
$result_enum_persona  = $connection->query($sql_enum_persona);
$row = $result_enum_persona->fetch_assoc();
$options = $row['Type'];

preg_match_all("/'(.*?)'/", $options, $matches);
$enum_values_persona  = $matches[1];

$sql_enum_color  = "SHOW COLUMNS FROM graduadas WHERE Field = 'color'";
$result_enum_color = $connection->query($sql_enum_color);
$row = $result_enum_color->fetch_assoc();
$options = $row['Type'];

preg_match_all("/'(.*?)'/", $options, $matches);
$enum_values_color = $matches[1];

$sql_enum_tratamiento  = "SHOW COLUMNS FROM graduadas WHERE Field = 'tratamiento'";
$result_enum_tratamiento = $connection->query($sql_enum_tratamiento);
$row = $result_enum_tratamiento->fetch_assoc();
$options = $row['Type'];

preg_match_all("/'(.*?)'/", $options, $matches);
$enum_values_tratamiento = $matches[1];

$sql_clientes = "SELECT id FROM clientes";
$result_clientes = $connection->query($sql_clientes);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Graduadas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles/styles.css">
    <style type="text/css">
         html, body {
            height: 100%;
            margin: 0;
        }
        body {
            font: 14px sans-serif;
            text-align: center;
            background: #B0E0E6;
            display: flex;
            flex-direction: column;
        }
    </style>
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
</head>
<body>
    <nav class="mt-4">
        <a href="graduadas.php">Graduadas</a> |
        <a href="../sol/sol.php">Sol</a> |
        <a href="../clientes/clientes.php">Clientes</a> |
        <a href="../logout.php">Cerrar sesión</a>
    </nav>

    <div class="container">
        <h2 class="mt-4 mb-4">Gafas graduadas</h2>
        <!-- Formulario para agregar nuevos registros -->
        <form action="comprar_graduadas.php" method="POST">
            <div class="form-group mb-4">
                <div class="row">
                    <label for="persona" class="col-sm-2 col-form-label text-end">Persona *</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="persona" name="persona" required>
                            <?php
                            foreach ($enum_values_persona as $value_persona) {
                                echo "<option value='" . $value_persona . "'>" . $value_persona . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <label for="numeroserie" class="col-sm-2 col-form-label text-end">Número de serie *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="numeroserie" name="numero_serie" placeholder="Escribe el número de serie" required>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <label for="color" class="col-sm-2 col-form-label text-end">Color *</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="color" name="color" required>
                            <option value="" disabled selected>Elige el color</option>
                            <?php
                            foreach ($enum_values_color as $value_color) {
                                echo "<option value='" . $value_color . "'>" . $value_color . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <label for="tratamiento" class="col-sm-2 col-form-label text-end">Tratamiento *</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="tratamiento" name="tratamiento" required>
                            <option value="" disabled selected>Elige el tratamiento</option>
                            <?php
                            foreach ($enum_values_tratamiento as $value_tratamiento) {
                                echo "<option value='" . $value_tratamiento . "'>" . $value_tratamiento . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <label for="idcliente" class="col-sm-2 col-form-label text-end">Id del cliente *</label>
                    <div class="col-sm-10">
                        <select class="form-control" id="idcliente" name="cliente_id" required>
                            <?php
                            if ($result_clientes->num_rows > 0) {
                                while ($row = $result_clientes->fetch_assoc()) {
                                    echo "<option value='" . $row['id'] . "'>" . $row['id'] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group mb-4">
                <div class="row">
                    <label for="precio" class="col-sm-2 col-form-label text-end">Precio *</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="precio" name="precio" placeholder="Escribe el precio total" required>
                    </div>
                </div>
            </div>
            <p>* Campos obligatorios</p><br>
            <button type="submit" class="btn btn-primary mb-4">Registrar gafas graduadas</button>
        </form>
    </div>

    <?php
    require_once "../config.php";

    // Consulta para seleccionar todos los datos de la tabla clientes, incluyendo created_at
    $sql = "SELECT persona, numero_serie, color, tratamiento, cliente_id, precio, created_at FROM graduadas";
    $result = $connection->query($sql);
    ?>

    <div class="table-responsive mx-auto col-sm-10 mb-4">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Persona</th>
                    <th>Número de serie</th>
                    <th>Color</th>
                    <th>Tratamiento</th>
                    <th>Id cliente</th>
                    <th>Precio</th>
                    <th>Fecha de compra</th>
                    <th>Factura</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    // Salida de datos de cada fila
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['persona'] . "</td>";
                        echo "<td>" . $row['numero_serie'] . "</td>";
                        echo "<td>" . $row['color'] . "</td>";
                        echo "<td>" . $row['tratamiento'] . "</td>";
                        echo "<td>" . $row['cliente_id'] . "</td>";
                        echo "<td>" . $row['precio'] . "</td>";
                        echo "<td>" . $row['created_at'] . "</td>";
                        echo "<td><a href='factura_graduadas.php?id=" . $row['cliente_id'] . "' target='_blank' class='btn btn-secondary btn-sm'><i class='fas fa-file-pdf'></i> Descargar PDF</a></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No se encontraron resultados.</td></tr>";
                }
                $connection->close();
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
