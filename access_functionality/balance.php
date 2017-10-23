<?php

    require "../db.php";

    if($_POST['user'] === "admin") {
        $suma = "SELECT sum(suma) FROM client";
        $suma_result = $connection->query($suma);
        $suma_row = $suma_result->fetch_assoc();

        foreach ($suma_row as $value){

        }

        print_r("<p id='sold'>Soldul contului: ".$value."</p>");
    }

?>