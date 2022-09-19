<?php
/* Connection */
$dbHost = "localhost";
$dbUser = "root";
$dbPassword = "";
$dbName = "aralink";

try {
  $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName;
  $conn = new PDO($dsn, $dbUser, $dbPassword);
} catch(PDOException $e) {
  echo "DB Connection Failed: " . $e->getMessage();
}
?>