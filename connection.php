<?php

$servername = "localhost:3306";
$username = "root";
$password = "root";
$dbname = "my_cinema";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  /* echo "Connected successfully"; */
} catch (PDOException $e) {
  die("ERROR: Could not connect. " . $e->getMessage());
}
