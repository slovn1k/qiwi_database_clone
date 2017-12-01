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
                            echo "<p id='deleting'>Stergerea realizata cu success!!!</p>";
                        } else {
                            echo "<p id='deleting'>Erroare la stergere!</p>".$connection->error;
                        }

                    }

                } else if(!empty($user_power)) {
                    if(isset($_POST['id_user'])) {
                        $id_user = $_POST['id_user'];
                        $modify = "SELECT *FROM users WHERE id_user='$id_user'";
                        $modify_result = $connection->query($modify);

                        while($modify_row = mysqli_fetch_assoc($modify_result)){
                            echo "<div class='row justify-content-center'>";
                                echo "<div class='col-lg-5 col-sm-5'>";
                                    echo "<form name='user_privilege' method='post' action='delete_user.php'>";
                                    echo "<div class='form-group'>";
                                        echo "<input type='text' hidden name='id_user' id='id_user' value='".$modify_row['id_user']."'>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                        echo "<label for='user'>Utilizator</label>";
                                        echo "<input type='text' class='form-control w-100' name='user' id='user' value='".$modify_row['user']."'>";
                                    echo "</div>";
                                    echo "<div class='form-group'>";
                                        echo "<label for='power'>Permis</label>";
                                        echo "<input type='text' class='form-control' name='power' id='power' value='".$modify_row['id_power']."'>";
                                    echo "</div>";
                                    echo "<br>";
                                    echo "<div class='form-group'>";
                                        echo "<button type='submit' class='btn btn-outline-primary w-100'>Permite</button>";
                                    echo "</div>";
                                    echo "</form>";
                                echo "</div>";
                            echo "</div>";
                        }

                        if(isset($_POST['id_power'])) {
                            $id_user = $_POST['id_user'];
                            $power = $_POST['id_power'];
                            echo $id_user;
                            echo $power;
                            $change_permission = "UPDATE users SET id_power='$power' WHERE id_user='$id_user'";
                            $change = $connection->query($change_permission);

                            if($change == true) {
                                echo "Schimbarile au fost realizate cu succes!!!";
                            } else {
                                echo "Erroare la schimbarile permiselor pentru utilizator".$connection->error;
                            }
                        }

                    }
                } else {
                    echo "Editeaza utilizaator";
                }

            ?>
        </div>

    </div>

</body>
</html>
