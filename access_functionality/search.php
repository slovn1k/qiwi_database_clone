<form action="../admin_panel/client.php" name="searching_form" method="post">

    <div class="form-group">
        <label for="searching_string">Secventa de cautare:</label>
        <input type="text" name="searching_string" id="searching_string" class="form-control">
    </div>

    <div class="form-group">
        <input type="submit" id="searching_button" style="width: 100%" class="btn btn-outline-light" value="Cauta">
    </div>

</form>

<?php

    require "../db.php";
    $nume = "";
    $query = "SELECT *FROM client";
    $result_query = $connection->query($query);

    while ($row = $result_query->fetch_assoc()) {
        $nume = $row['nume'];

        if(isset($_POST['searching_string'])) {
            $searching_string = $_POST['searching_string'];
        }
        $nume_count = mysqli_num_rows($result_query);

        if(isset($searching_string)) {
            if(preg_match('/'.$searching_string.'/', $nume)) {
                //echo "<div id='searching_result'>".$_POST['searching_string']."</div>";
                echo "<div id='searching_result'>".$nume."</div>";
            } else if(!preg_match('/'.$searching_string.'/', $nume)) {
                //echo "<div id='searching_result'>Nu a fost gasit nici un client cu asa nume!!!</div>";
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