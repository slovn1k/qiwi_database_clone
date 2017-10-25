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

        <?php

            $user_query = 'SELECT *FROM users';
            $result = $connection->query($user_query);

            while ($row = $result->fetch_assoc()) {
                if($_POST['user'] === $row['user'] && $_POST['password'] === $row['password']) {
                    break;
                } else {
                    $sql = 'SELECT *FROM users';
                    $result2 = $connection->query($sql);
                    $row_count = mysqli_num_rows($result2);
                    $row++;

                    if($row['id_user'] > $row_count || $row['id_user'] == $row_count) {
                        echo "<h1 id='login_error'>Ati introdus datele incorect</h1>";
                        echo "<h1 id='login_error'>In timp de 3 secunde o sa fiti returnat pe pagina de logare</h1>";
                        session_unset();
                        session_destroy();
                        header("refresh:3; url=../index.php");
                        exit();
                    }
                }
            }

        ?>

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

                <h3 id="add_title">Forma de adaugare</h3>

                <div id="spoiler" style="display:none">
                    <form name="adding_client" action="add_client.php" method="post">

                        <div class="form-group">
                            <label for="nume">Nume<span id="required"> *</span></label>
                            <input type="text" name="nume" id="nume" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="prenume">Preume</label>
                            <input type="text" name="prenume" id="prenume" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="directia">Directia<span id="required"> *</span></label>
                            <select class="form-control" name="directia">
                                <option selected name="Fotopanou" value="Fotopanou">Fotopanou</option>
                                <option name="Ella" value="Ella">Ella</option>
                                <option name="Avix" value="Avix">Avix</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tel">Telefon<span id="required"> *</span></label>

                            <div class="input-group">
                                <span class="input-group-addon">(+373)/0</span>
                                <input type="text" name="tel" id="tel" maxlength="11" class="form-control">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="suma">Suma<span id="required"> *</span></label>
                            <input type="number" name="suma" id="suma" class="form-control">
                        </div>

                        <br>
                        <p><input type="submit" style="width: 100%;" class="btn btn-primary" value="Introduce"></p>
                        <br>
                        <p><input type="reset" style="width: 100%;" class="btn btn-danger" value="Reseteaza"></p>

                    </form>
                </div>

                <button style="width: 100%; margin-top: 10px;" title="Apasa pentru a deschide forma de adaugare" class="btn btn-success" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}">Arata/Ascunde</button>

            </div>

        </div>

        <hr id="form_separator">

        <div class="row justify-content-center">

            <div class="col-auto">
                <h4>Lista Clienti</h4>

                <?php

                $query = "SELECT *FROM client ORDER BY nume";
                $result = $connection->query($query);

                while ($row = $result->fetch_assoc()) {

                    echo "<form name='editing_client' action='delete_client.php' method='post'>";

                    echo "<label hidden for='id'>ID_Personal:&nbsp;</label>";
                    echo "<input hidden type='text' disabled name='id' id='id' value='".$row['id_client']."'>";

                    echo "<br>";

                    echo "<label for='nume'>Client:&nbsp;</label>";
                    echo "<input type='text' disabled name='nume' id='nume' value='".$row['nume']."'>";

                    echo "<br>";

                    echo "<label for='prenume'>Prenume:&nbsp;</label>";
                    echo "<input type='text' disabled name='prenume' id='prenume' value='".$row['prenume']."'>";

                    echo "<br>";

                    echo "<label for='directia'>Directia:&nbsp;</label>";
                    echo "<input type='text' disabled' name='directia' id='directia' value='".$row['directia']."'>";

                    echo "<br>";

                    echo "<label for='tel'>Telefon:&nbsp;</label>";
                    echo "<span id='number_prefix'>(+373)/0</span><input type='text' disabled name='tel' id='tel' value='".$row['numar_tel']."'>";

                    echo "<br>";

                    echo "<label for='suma'>Suma:&nbsp;</label>";
                    echo "<input type='text' disabled name='suma' id='suma' value='".$row['suma']."'>";

                    echo "</form>";
                }

                ?>
            </div>

        </div>

    </div>

    </body>
</html>
