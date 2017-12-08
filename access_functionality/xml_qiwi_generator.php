<?php

    require '../db.php';

    if($_POST['user'] === 'admin') {
        echo "<a href='../xml_generator/index.php' id='xml_generator'>Genereaza QIWI XML</a>";
    }

