<?php

    session_start();
    require "../db.php";

    if(isset($_SESSION['user']) && isset($_SESSION['password'])) {
        $_POST['user'] = $_SESSION['user'];
        $_POST['password'] = $_SESSION['password'];
    } else {
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['password'] = $_POST['password'];
    }

    if(isset($_POST['id_client'])) {
        $id_client = $_POST['id_client'];
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

            <form name="udating_form" action="update.php" method="post">
                <?php

                $update = "SELECT *FROM client WHERE id_client=".$_POST['id_client'];
                $result = $connection->query($update);
                $row = $result->fetch_assoc();

                echo "<label for='id'>ID_Client&nbsp;</label>";
                echo "<input type='text' name='id' id='id' value='".$row['id_client']."'>";
                echo "<br>";

                echo "<label for='nume'>Nume&nbsp;</label>";
                echo "<input type='text' name='nume' id='nume' value='".$row['nume']."'>";
                echo "<br>";

                echo "<label for='prenume'>Prenume&nbsp;</label>";
                echo "<input type='text' name='prenume' id='prenume' value='".$row['prenume']."'>";
                echo "<br>";

                echo "<label for='directia'>Directia&nbsp;</label>";
                echo "<input type='text' name='directia' id='directia' value='".$row['directia']."'>";
                echo "<br>";

                echo "<label for='tel'>Telefon&nbsp;</label>";
                echo "<input type='text' name='tel' id='tel' value='".$row['numar_tel']."'>";
                echo "<br>";

                echo "<label for='suma'>Suma&nbsp;</label>";
                echo "<input type='text' name='suma' id='suma' value='".$row['suma']."'>";


                ?>

                <br>

                <input type="submit" class="btn btn-primary" value="Salveaza schimbarile">
            </form>

        </div>

    </div>

</div>

</body>
</html>

