<?php

    require "../db.php";

    if($_POST['user'] === 'admin'){
        echo "<a href='../bpay_xml_generator/index.php' id='xml_generator_bpay' target='_blank'>Genereaza Bpay XML</a>";
    }

?>