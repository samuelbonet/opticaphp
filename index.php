<?php
session_start(); // Inicia la sesión

require_once "config.php"; // Incluir el archivo de configuración

// Verifica si el usuario ya ha iniciado sesión
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) {
    // Redirige al usuario a la página de sol si está autenticado
    header("Location: graduadas/graduadas.php");
    exit;
}

// Definir variables e inicializarlas con valores vacíos
$username = $password = "";
$username_err = $password_err = "";

// Procesar los datos del formulario cuando se envía
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Verificar si el nombre de usuario está vacío
    if (empty(trim($_POST["username"]))) {
        $username_err = "Por favor ingrese su usuario.";
    } else {
        $username = trim($_POST["username"]);
    }

    // Verificar si la contraseña está vacía
    if (empty(trim($_POST["password"]))) {
        $password_err = "Por favor ingrese su contraseña.";
    } else {
        $password = trim($_POST["password"]);
    }

    // Validar las credenciales
    if (empty($username_err) && empty($password_err)) {
        // Preparar una declaración SELECT
        $sql = "SELECT id, username, password FROM usuarios WHERE username = ?";

        if ($stmt = mysqli_prepare($connection, $sql)) {
            // Vincular variables a la declaración preparada como parámetros
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Establecer parámetros
            $param_username = $username;

            // Intentar ejecutar la declaración preparada
            if (mysqli_stmt_execute($stmt)) {
                // Almacenar resultado
                mysqli_stmt_store_result($stmt);

                // Verificar si el nombre de usuario existe, de ser así, verificar la contraseña
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Vincular las variables de resultado
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // La contraseña es correcta, así que iniciar una nueva sesión
                            session_start();

                            // Almacenar datos en las variables de sesión
                            $_SESSION["loggedin"] = true;
                            $_SESSION["user_id"] = $id;
                            $_SESSION["username"] = $username;

                            // Redirigir al usuario a la página
                            header("Location: graduadas/graduadas.php");
                            exit; // Asegúrate de salir después de redirigir
                        } else {
                            // Mostrar un mensaje de error si la contraseña no es válida
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else {
                    // Mostrar un mensaje de error si el nombre de usuario no existe
                    $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                }
            } else {
                echo "Algo salió mal, por favor vuelve a intentarlo.";
            }
        }

        // Cerrar declaración
        mysqli_stmt_close($stmt);
    }

    // Cerrar conexión
    mysqli_close($connection);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="icon" href="../images/favicon.png" type="image/x-icon">
    <style type="text/css">
        body {
            font: 14px sans-serif;
            text-align: center;
            background: linear-gradient(135deg, #74EBD5 0%, #ACB6E5 100%);
            display: flex;
            justify-content: center; /* Centrar contenido horizontalmente */
            align-items: center; /* Centrar contenido verticalmente */
            height: 100vh; /* Utiliza todo el alto de la ventana */
            margin: 0; /* Eliminar márgenes predeterminados */
            padding: 0;
        }
    </style>
</head>
<body>
    
    <div class="wrapper">
        <h1>Óptica php</h1>
        <p>Por favor, complete sus credenciales para iniciar sesión.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Usuario</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Ingresar">
            </div>
        </form>
    </div>    
</body>
</html>
