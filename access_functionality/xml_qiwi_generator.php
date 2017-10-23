<?php

    require '../db.php';

    if($_POST['user'] === 'admin') {
        echo "<a target='_blank' href='../xml_generator/index.php' id='xml_generator'>Genereaza XML fisier</a>";
    }

?>