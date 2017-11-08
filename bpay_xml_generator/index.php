<?php

  $server = "localhost";
  $user = "root";
  $password = "";
  $database = "qiwi_user_database";

  $connection = new mysqli($server, $user, $password, $database);
    if(!$connection) {
      die("Erroare la conectare cu baza de date".$connection->error);
  }

?>
