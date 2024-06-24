<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
$servername = "my_servername";
$username = "my_username";
$password = "my_password";
$database = "my_database";
 
/* Attempt to connect to MySQL database */
$connection = new mysqli($servername, $username, $password, $database);
 
// Check connection
if($connection === false){
    die("Connection failed: " . $connection->connect_error);
}
?>