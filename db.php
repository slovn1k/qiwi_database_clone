<?php

    $server = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'qiwi_user_database';

    $connection = new mysqli($server, $user, $password, $database);

    if($connection->error) {
        die('Erroare la conectare cu baza de date'.$connection->connect_error);
    }


