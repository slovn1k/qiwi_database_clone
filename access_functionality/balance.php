<?php

    require "../db.php";
    $final_suma = 0.00;

    if($_POST['user'] === "admin") {
        $suma2 = "SELECT sum(suma) as suma_achitat FROM client_achitat";
        $suma2_result = $connection->query($suma2);
        $suma2_row = $suma2_result->fetch_assoc();
        $final_suma += $suma2_row['suma_achitat'];

        print_r("<p id='sold'>Soldul contului: ".$final_suma."</p>");
    }

?>