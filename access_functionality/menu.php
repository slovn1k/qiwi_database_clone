<?php

    require "../db.php";

    if($_POST['user'] === 'admin') {
        echo "<ul class='menu_items'>

                <li><a href='index.php'>Pagina Principala</a></li>

                <li><a href='client.php'>Clienti Stergere</a></li>
                
                <li><a href='client_update.php'>Clienti Editare</a> </li>

                <li><a target='_blank' href='../admin_panel/generate_raport.php'>Raport</a></li>

                <li><a href='../admin_panel/user.php'>Utilizatori</a></li>

            </ul>";
    } else {
        echo "<ul class='menu_items'>

                <li><a href='index.php'>Pagina Principala</a></li>

                <li><a href='client.php'>Clienti Stergere</a></li>
                
                <li><a href='client_update.php'>Clienti Editare</a> </li>

            </ul>";
    }

?>