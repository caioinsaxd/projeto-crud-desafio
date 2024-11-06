<?php
$servername = "localhost:3306";
$username = "root";
$password = "robot123";
$dbname = "projeto";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);

}

?>