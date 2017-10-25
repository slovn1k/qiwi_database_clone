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
    <title>Bune venit pe panela de administrare</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    <script type="text/javascript" src="../jquery/jquery-3.2.1.min.js"></script>
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

            <form name="user_list" action="#" method="post">

            <?php

                $user = "SELECT *FROM users";
                $user_result = $connection->query($user);

                while($row = $user_result->fetch_assoc()) {
                    echo "<div class='form-group'>";
                    echo "<label for='id_user'>".$row['user']."&nbsp;</label>";
                    echo "<input type='radio' name='id_user' id='id_user' value='".$row['id_user']."'>";
                    echo "</div>";
                }

            ?>

            <input type="submit" class="btn btn-primary" value="Editeaza">

            </form>

        </div>

    </div>

</body>
</html>
