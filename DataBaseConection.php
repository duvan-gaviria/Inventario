<?php
$servername = "sql37.main-hosting.eu";
$database = "u972534917_claro";
$username = "u972534917_duva";
$password = "Clave7852@";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>