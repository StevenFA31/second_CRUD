<?php
/*
Connexion à la base de données
*/
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$mysqli = new mysqli("database", "root", $_ENV['MYSQL_ROOT_PASSWORD'], "second_CRUD");

if (mysqli_connect_errno()) {
  printf("Échec de la connexion : %s\n", mysqli_connect_error());
  exit();
}
?>