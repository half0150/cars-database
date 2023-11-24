<?php

$servername = "localhost";
$db_username = "username"; 
$db_password = "password"; 
$db_name = "dbcon";

$conn = new mysqli($servername, $db_username, $db_password, $db_name);

$conn->set_charset("utf8mb4");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
