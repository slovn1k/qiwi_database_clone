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

    if(isset($_POST['id_client']) || isset($_POST['numar_tel'])) {
        $id_client = $_POST['id_client'];
        $numar_tel = $_POST['numar_tel'];
    }

?>

<!DOCTYPE html>
<html>
<head>
    <title>Qiwi Client Database</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
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
                <input type="submit" class="btn btn-outline-warning" id="exit_button" value="Iesire">
            </form>
        </div>

    </div>

    <div class="row justify-content-center">

        <div class="col-auto">


            <?php
            if(isset($id_client) && isset($numar_tel)) {
                $delete = "DELETE FROM client WHERE client.id_client='$id_client'";
                $delete2 = "DELETE FROM client_bpay WHERE client_bpay.numar_tel='$numar_tel'";
                $result = $connection->query($delete);
                $result2 = $connection->query($delete2);

                if($result == true || $result2 == true) {
                    echo "<p id='deleting'>Stergere realizata cu succes!!!</p>";
                } else {
                    echo "<p id='deleting'>Erroare la stergere</p>";
                }
            }
            ?>
        </div>

    </div>

</div>

</body>
</html>

