<?php

$servername = "localhost";
$port = 3307;
$username = "root";
$password = "";
$database = "livreor";

try {
  $conn = new PDO("mysql:host=$servername;port=$port;dbname=$database", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  // echo "PDO: Connected successfully";
} catch(PDOException $e) {
  //echo "PDO: Connection failed: " . $e->getMessage();
}

?>