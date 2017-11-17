<?php

    session_start();
    require "../db.php";
    $delete_user = "";
    $user_power = "";
    $edit_user = "";

    if(isset($_SESSION['user']) && isset($_SESSION['password'])) {
        $_POST['user'] = $_SESSION['user'];
        $_POST['password'] = $_SESSION['password'];
    } else {
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['password'] = $_POST['password'];
    }

    if(isset($_POST['sterge'])) {
        $delete_user = $_POST['sterge'];
    } else if(isset($_POST['privilegii'])) {
        $user_power = $_POST['privilegii'];
    } else {
        $edit_user = $_POST['editeaza'];
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Stergere utilizator</title>
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

            <div class="col-auto" id="admin_title">
                <?php include "../access_functionality/xml_bpay_generator.php";?>
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

        <div class="col-auto justify-content-center">
            <?php

                if(!empty($delete_user)) {
                    
                    if(isset($_POST['id_user'])) {
                        $id_user = $_POST['id_user'];
                        $delete_user = "DELETE FROM users WHERE id_user='$id_user'";
                        $delete_result = $connection->query($delete_user);

                        if($delete_result == true) {
                            echo "Stergerea realizata cu success!!!";
                        } else {
                            echo "Erroare la stergere!".$connection->error;
                        }

                    }

                } else if(!empty($user_power)) {
                    echo "Modifica utilizator";
                } else {
                    echo "Editeaza utilizaator";
                }

            ?>
        </div>

    </div>

</body>
</html>
