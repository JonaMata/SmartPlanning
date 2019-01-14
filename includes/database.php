<?php
$db_host = 'localhost';
$db_user = 'smartplanninguser';
$db_pass = 'smartplanninguser';
$db_name = 'smartplanning';

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
  die("Connection failed: " . $conn-connect_error);
}

 ?>
