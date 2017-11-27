<form action="../admin_panel/client.php" name="searching_form" method="post">

    <div class="form-group">
        <label for="searching_string">Cautare de stergere:</label><br>
        <input type="text" name="searching_string" id="searching_string" class="form-control">
    </div>

    <div class="form-group">
        <input type="submit" id="searching_button" style="width: 100%" class="btn btn-danger" name="delete" value="Cauta">
    </div>

    <p>Pentru a afisa lista completa apasati "Cauta" fara a introduce text in spatiu liber.</p>

</form>

<?php

    require "../db.php";
    $nume = "";
    $query = "SELECT client.id_client, client.nume, client.prenume, client.numar_tel, client.suma, client.commentariu, client.data, directia.denumire as directia FROM client INNER JOIN directia ON client.id_directia=directia.id_directia";
    $result_query = $connection->query($query);

    while ($row = $result_query->fetch_assoc()) {
        $id_client = $row['id_client'];
        $nume = $row['nume'];
        $prenume = $row['prenume'];
        $directia = $row['directia'];
        $numar_tel = $row['numar_tel'];
        $suma = $row['suma'];
        $commentariu = $row['commentariu'];
        $data = $row['data'];

        if(isset($_POST['searching_string'])) {
            $searching_string = $_POST['searching_string'];
        }
        $nume_count = mysqli_num_rows($result_query);

        if(isset($searching_string)) {
            if(preg_match('/'.$searching_string.'/', $nume)) {

                    echo "<div class='col-auto'>";
                        echo "<form action='../admin_panel/delete_client.php' method='post' name='delete_client' class='delete_client' style='margin-top: 10px;'>";

                            echo "<input type='checkbox' name='id_client' id='id_client_check' value='".$id_client."'>";

                            echo "<div id='searching_result'>".$nume."</div>";
                            echo "<div id='searching_result'>".$prenume."</div>";
                            echo "<div id='searching_result'>".$directia."</div>";
                            echo "<input type='text' name='numar_tel' value='".$numar_tel."' id='searching_result'/><br>";
                            echo "<div id='searching_result'>".$suma."</div>";
                            echo "<div id='searching_result'>".$commentariu."</div>";
                            echo "<div id='searching_result'>".$data."</div>";

                        echo "<input type='submit' class='btn btn-outline-danger' id='deleting_button' value='Sterge client'><br>";

                        echo "</form>";
                    echo "</div>";

            } else if(!preg_match('/'.$searching_string.'/', $nume)) {
                echo " ";
            }

        } else {

            if(isset($_POST['searching_string'])) {
                $searching_string = $_POST['searching_string'];
                if($searching_string === " ") {
                    echo "<div id='searching_result'>Inroduceti secventa de cautare!!!</div>";
                    break;
                }
            }

        }

    }

?>
