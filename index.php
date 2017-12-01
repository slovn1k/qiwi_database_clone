<?php

    session_start();
    require 'db.php';

    if($_SERVER['SERVER_PORT'] !== 443 &&
        (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        exit;
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Qiwi Client Database</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    </head>
    <body class="body">

    <div class="container">

        <div class="row justify-content-center">

            <div class="col-lg-3" id="spoiler_2" style="width: 310px; position: absolute; top: 50%; left: 50%; z-index: 15; margin: -150px 0 0 -150px;">
                <form name="login_form" action="admin_panel/index.php" method="post">

                    <h3>Forma de logare</h3>

                    <div class="form-group">
                        <label for="user">Introduceti user</label>
                        <input type="text" class="form-control" name="user" placeholder="user">
                    </div>

                    <div class="form-group">
                        <label for="password">Introduceti parola</label>
                        <input type="password" maxlength="20" class="form-control" name="password" placeholder="parola">
                    </div>

                    <div>
                        <input type="submit" class="btn btn-primary" id="login_button" value="Intra">
                        <input type="reset" class="btn btn-light" id="login_button" value="Reseteaza">
                        <button style="width: 100%; margin-top: 5px;" title="Apasa pentru a deschide forma de inregistrare" class="btn btn-success" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}if(document.getElementById('spoiler_2') .style.display=='none') {document.getElementById('spoiler_2') .style.display=''}else{document.getElementById('spoiler_2') .style.display='none'}">Arata forma de inregistrare</button>
                    </div>
                </form>
            </div>

        </div>

        <div class="row justify-content-center">

            <div class="col-lg-6 col-sm-6" style="position: absolute; top: 30%; left: 38%; z-index: 15; margin: -150px 0 0 -150px;">

                <div id="spoiler" style="display:none">

                    <h3 id="add_title">Forma de inregistrare</h3>

                    <form name="reg_user" action="index.php" method="post">

                        <?php

                            $user_count = "SELECT COUNT(id_user) as user_length FROM users";
                            $user_count_result = $connection->query($user_count);
                            $user_count_row = $user_count_result->fetch_assoc();

                            echo "Numarul de utilizatori: ";
                            printf($user_count_row['user_length']);

                        ?>

                        <div class="form-group">
                            <label for="id_utilizator">Numarul unical al utilizatorului, mariti cu un punct cifra de sus...</label>
                            <input type="text" name="id_utilizator" id="id_utilizator" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="user">Introduceti User</label>
                            <input type="text" name="user_reg" id="user_reg" class="form-control" placeholder="user" style="width: 100%;">
                        </div>

                        <div class="form-group">
                            <label for="password">Introduceti Parola</label>
                            <input type="password" name="password_reg" maxlength="20" id="password_reg" placeholder="parola" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Privilegii</label>
                            <select id="privilege" name="privilege" class="custom-select" style="width: 100%;">
                                <?php

                                    $query = "SELECT *FROM user_power ORDER BY id_power ASC";
                                    $query_result = $connection->query($query);

                                    while ($row = $query_result->fetch_assoc()) {
                                        echo "<option name='".$row['nivel']."' value='".$row['id_power']."'>".$row['nivel']."</option>";
                                    }

                                ?>
                            </select>
                        </div>

                        <input type="submit" style="width: 100%; margin: 0px 0 5px 0;" class="btn btn-primary" value="Inregistreaza">
                        <input type="reset" style="width: 100%; margin: 0px 0 5px 0;" class="btn btn-light" value="Reseteaza">
                        <input type="reset" style="width: 100%;" class="btn btn-danger" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}if(document.getElementById('spoiler_2') .style.display=='none') {document.getElementById('spoiler_2') .style.display=''}else{document.getElementById('spoiler_2') .style.display='none'}" value="Ascunde forma de inregistrare">

                    </form>

                        <?php

                            if (isset($_POST['user_reg']) && isset($_POST['password_reg'])) {
                                $id_utilizator = $_POST['id_utilizator'];
                                $user_reg = $_POST['user_reg'];
                                $password_reg = md5($_POST['password_reg']);
                                $privilege = $_POST['privilege'];
                                $reg_user_query = "INSERT INTO users (id_user, user, password, id_power) VALUES ('".$id_utilizator."', '".$user_reg."', '".$password_reg."', '".$privilege."')";
                                $reg_user_result = $connection->query($reg_user_query);

                                if (!$reg_user_result) {
                                    $message_fail = "Erroare la inserarea datelor" . $connection->error;
                                    echo "<script type='text/javascript'>alert('".$message_fail."');</script>";
                                } else {
                                    $message_success = "Inregistrarea a fost realizata cu success!!!";
                                    echo "<script type='text/javascript'>alert('".$message_success."');</script>";
                                }
                            }

                        ?>

                </div>

            </div>

        </div>

    </div>

    </body>
</html>
