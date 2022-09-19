<?php
/* Connection */
$dbHost = "sql308.epizy.com";
$dbUser = "epiz_29350693";
$dbPassword = "UKpYuQuaQ3Odw";
$dbName = "epiz_29350693_classvideo";

try {
  $dsn = "mysql:host=" . $dbHost . ";dbname=" . $dbName;
  $conn = new PDO($dsn, $dbUser, $dbPassword);
} catch(PDOException $e) {
  echo "DB Connection Failed: " . $e->getMessage();
}
?>
