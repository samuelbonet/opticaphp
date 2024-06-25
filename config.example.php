<?php
/* Credenciales de la base de datos. */
$servername = "my_servername";
$username = "my_username";
$password = "my_password";
$database = "my_database";
 
/* Intento de conectarse a la base de datos MySQL */
$connection = new mysqli($servername, $username, $password, $database);
 
// Verificar conexión
if($connection === false){
    die("Conexión fallida: " . $connection->connect_error);
}
?>
