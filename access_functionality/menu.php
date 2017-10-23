<?php

    require "../db.php";

    if($_POST['user'] === 'admin') {
        echo "<ul class='menu_items'>

                <li><a href='index.php'>Pagina Principala</a></li>

                <li><a href='client.php'>Clienti</a></li>

                <li><a href='#'>Raport</a></li>

                <li><a href='#'>Utilizatori</a></li>

            </ul>";
    } else {
        echo "<ul class='menu_items'>

                <li><a href='index.php'>Pagina Principala</a></li>

                <li><a href='client.php'>Clienti</a></li>

            </ul>";
    }

?>