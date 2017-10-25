<?php

    session_start();
    require '../db.php';

    if(isset($_SESSION['user']) && isset($_SESSION['password'])) {
        $_POST['user'] = $_SESSION['user'];
        $_POST['password'] = $_SESSION['password'];
    } else {
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['password'] = $_POST['password'];
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Qiwi Client Database</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body class="body">

    <div class="container-fluid">

        <div class="row justify-content-end">

            <div class="col-auto">

                <?php include "../access_functionality/menu.php";?>

            </div>

            <div class="col-auto" id="admin_title">
                Bine ati venit : <?php echo "<span id='admin_color'>".$_POST['user']."</span>";?><?php include "../access_functionality/xml_qiwi_generator.php";?>
            </div>

            <div class="col-auto">
                <?php include "../access_functionality/balance.php";?>
            </div>

            <div class="col-auto">
                <form action="exit.php" name="logout_form" method="post">
                    <input type="submit" class="btn btn-warning" id="exit_button" value="Iesire">
                </form>
            </div>

        </div>

        <div class="row justify-content-center">

            <div class="col-auto">
                <form name="delete_client" action="delete_client.php" method="post">

                        <?php

                        $delete = "SELECT *FROM client ORDER BY nume";
                        $delete_result = $connection->query($delete);

                        while ($row = $delete_result->fetch_assoc()) {
                            echo "<div class='form-group'>";
                            echo "<label for='id_client'>".$row['nume']."&nbsp;</label>";
                            echo "<input type='radio' name='id_client' id='id_client' value='".$row['id_client']."'>";
                            echo "</div>";
                        }

                        ?>

                    <input type="submit" class="btn btn-danger" id="deleting_button" value="Sterge client">

                </form>
            </div>

        </div>

        <br>
        <hr id="form_separator">

        <div class="row justify-content-center">

            <div class="col-auto">

                <form name="update_client" action="update_client.php" method="post">

                    <?php

                        $update = "SELECT *FROM client ORDER BY nume";
                        $update_query = $connection->query($update);

                        while($update_row = $update_query->fetch_assoc()) {
                            echo "<div class='form-group'>";
                            echo "<label for='id_client'>".$update_row['nume']."&nbsp;</label>";
                            echo "<input type='radio' name='id_client' id='id_client' value='".$update_row['id_client']."'>";
                            echo "</div>";
                        }

                    ?>

                    <input type="submit" class="btn btn-primary" id="updating_button" value="Editeaza datele">

                </form>

            </div>

        </div>

    </div>

</body>
</html>
