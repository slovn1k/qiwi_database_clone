<?php

    session_start();

    require '../db.php';

    if(isset($_SESSION['user']) && isset($_SESSION['password'])) {
        $_POST['user'] = $_SESSION['user'];
        $_POST['password'] = $_SESSION['password'];
        $password = md5($_POST['password']);
    } else {
        $_SESSION['user'] = $_POST['user'];
        $_SESSION['password'] = $_POST['password'];
        $password = md5($_POST['password']);
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Bune venit pe panela de administrare</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="../style/style.css">
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
        <script type="text/javascript" src="../jquery/jquery-3.2.1.min.js"></script>
    </head>
    <body class="body">

        <?php

            $user_query = 'SELECT *FROM users';
            $result = $connection->query($user_query);
            $count = mysqli_num_rows($result);

            while ($row = $result->fetch_assoc()) {
                if($_POST['user'] === $row['user'] && $password === $row['password']) {
                    break;
                } else {
                    $sql = 'SELECT *FROM users';
                    $result2 = $connection->query($sql);
                    $row_count = mysqli_num_rows($result2);
                    $row++;

                    if($row['id_user'] > $row_count || $row['id_user'] == $row_count) {
                        echo "<h1 id='login_error'>Ati introdus datele incorect</h1>";
                        echo "<h1 id='login_error'>In timp de 5 secunde o sa fiti returnat pe pagina de logare</h1>";
                        session_unset();
                        session_destroy();
                        header("refresh:5; url=../index.php");
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

        <div class="row justify-content-center">

            <div class="col-auto">

                <h3 id="add_title">Forma de adaugare</h3>

                <div id="spoiler" style="display:none">
                    <form name="adding_client" action="add_client.php" method="post">

                        <div class="form-group">
                            <label for="nume">Nume<span id="required"> *</span></label>
                            <input type="text" pattern="[A-Za-z]{1,50}" title="Se permite de introdus doar litere" name="nume" id="nume" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="prenume">Preume</label>
                            <input type="text" pattern="[A-Za-z]{1,50}" title="Se permite de introdus doar litere" name="prenume" id="prenume" class="form-control">
                        </div>


                        <?php

                            $directia = "SELECT *FROM directia";
                            $directia_result = $connection->query($directia);

                        ?>
                        <div class="form-group">
                            <label for="directia">Directia<span id="required"> *</span></label>
                            <select class="form-control" name="directia">
                                <?php

                                    while ($directia_row = mysqli_fetch_assoc($directia_result)) {
                                        echo "<option name='".$directia_row['denumire']."' value='".$directia_row['id_directia']."'>".$directia_row['denumire']."</option>";
                                    }

                                ?>
<!--                                <option selected name="LigaRobotilor" value="Liga Robotilor">Liga Robotilor</option>-->
<!--                                <option name="Ella" value="Ella">Ella</option>-->
<!--                                <option name="Avix" value="Avix">Avix</option>-->
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tel">Telefon<span id="required"> *</span></label>

                            <div class="input-group">
                                <span class="input-group-addon">(+373)/0</span>
                                <input type="text" pattern="[0-9]{8,11}" title="Se permite de introdus doar cifre, min 8 si max 11" name="tel" id="tel" maxlength="11" class="form-control">
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="suma">Suma<span id="required"> *</span></label>
                            <input type="number" name="suma" id="suma" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comentariu">Comentariu<span id="required"> *</span></label>
                            <textarea name="comentariu" id="comentariu" class="form-control"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="data">Data<span id="required"> *</span></label>
                            <input type="datetime-local" name="data" id="data" class="form-control">
                        </div>

                        <br>
                        <p><input type="submit" style="width: 100%; margin: 5px 0 5px 0;" class="btn btn-outline-primary" value="Introduce"></p>
                        <br>
                        <p><input type="reset" style="width: 100%;" class="btn btn-outline-danger" value="Reseteaza"></p>

                    </form>
                </div>

                <button style="width: 100%; margin-top: 10px;" title="Apasa pentru a deschide forma de adaugare" class="btn btn-success" type="button" onclick="if(document.getElementById('spoiler') .style.display=='none') {document.getElementById('spoiler') .style.display=''}else{document.getElementById('spoiler') .style.display='none'}">Arata/Ascunde</button>

            </div>

        </div>

        <hr id="form_separator">

        <?php

        $count_user = "SELECT COUNT(id_client) c FROM client";
        $count_result = $connection->query($count_user);
        $count = $count_result->fetch_assoc();

        ?>

        <?php

            $spre_achitare = "SELECT SUM(suma) as spre_achitare FROM client";
            $spre_achitare_result = $connection->query($spre_achitare);
            $spre_achitare_row = $spre_achitare_result->fetch_assoc();

        ?>
        <h4 id="lista_clienti">Lista Clienti(Spre Achitare = <?php printf($spre_achitare_row['spre_achitare']);?>)</h4>

        <div class="row justify-content-center">

                <?php

                $query = "SELECT client.id_client, client.nume, client.prenume, directia.denumire as directia, client.numar_tel, client.suma, client.commentariu, client.data FROM client INNER JOIN directia ON client.id_directia=directia.id_directia WHERE client.commentariu NOT LIKE 'Achitat%' ORDER BY nume";
                $result = $connection->query($query);

                while ($row = $result->fetch_assoc()) {

                    echo "<div class='col-auto'>";

                        echo "<form name='editing_client' action='delete_client.php' method='post'>";

                        echo "<label hidden for='id'>ID_Personal:&nbsp;</label>";
                        echo "<input hidden type='text' disabled name='id' id='id' value='".$row['id_client']."'>";

                        echo "<br>";

                        echo "<label for='nume'>Client:&nbsp;</label>";
                        echo "<input type='text' required disabled name='nume' id='nume' value='".$row['nume']."'>";

                        echo "<br>";

                        echo "<label for='prenume'>Prenume:&nbsp;</label>";
                        echo "<input type='text' disabled name='prenume' id='prenume' value='".$row['prenume']."'>";

                        echo "<br>";

                        echo "<label for='directia'>Directia:&nbsp;</label>";
                        echo "<input type='text' disabled required name='directia' id='directia' value='".$row['directia']."'>";

                        echo "<br>";

                        echo "<label for='tel'>Telefon:&nbsp;</label>";
                        echo "<span id='number_prefix'>(+373)/0</span><input type='text' required disabled name='tel' id='tel' value='".$row['numar_tel']."'>";

                        echo "<br>";

                        echo "<label for='suma'>Suma:&nbsp;</label>";
                        echo "<input type='text' required disabled name='suma' id='suma' value='".$row['suma']."'>";

                        echo "<br>";

                        echo "<label for='comentariu'>Comentariu:&nbsp;</label>";
                        echo "<textarea class='form-control' required disabled name='comentariu' id='comentariu'>".$row['commentariu']."</textarea>";

                        echo "<br>";

                        echo "<label for='data'>Data:</label>";
                        echo "<input type='text' required disabled name='data' id='data' value='".$row['data']."'>";

                        echo "</form>";

                        echo "<hr id='form_separator'>";

                    echo "</div>";
                }

                ?>

        </div>

        <?php

        $achitat = "SELECT SUM(suma) as suma_all FROM client_achitat";
        $result2 = $connection->query($achitat);
        $row2 = $result2->fetch_assoc();

        ?>

        <h4 id="lista_clienti_achitat">Lista Clienti(Achitat = <?php printf($row2['suma_all']); ?>)</h4>

        <div class="row justify-content-center">

            <?php

            $query = "SELECT client.id_client, client.nume, client.prenume, directia.denumire as directia, client.numar_tel, client.suma, client.commentariu, client.data, client.sistema FROM client INNER JOIN directia ON client.id_directia=directia.id_directia WHERE client.commentariu LIKE 'Achitat%' ORDER BY nume";
            $result = $connection->query($query);

            while ($row = $result->fetch_assoc()) {

                echo "<div class='col-auto'>";

                echo "<form name='editing_client' action='delete_client.php' method='post'>";

                echo "<label hidden for='id'>ID_Personal:&nbsp;</label>";
                echo "<input hidden type='text' disabled name='id' id='id' value='".$row['id_client']."'>";

                echo "<br>";

                echo "<label for='nume'>Client:&nbsp;</label>";
                echo "<input type='text' required disabled name='nume' id='nume' value='".$row['nume']."'>";

                echo "<br>";

                echo "<label for='prenume'>Prenume:&nbsp;</label>";
                echo "<input type='text' disabled name='prenume' id='prenume' value='".$row['prenume']."'>";

                echo "<br>";

                echo "<label for='directia'>Directia:&nbsp;</label>";
                echo "<input type='text' disabled required name='directia' id='directia' value='".$row['directia']."'>";

                echo "<br>";

                echo "<label for='tel'>Telefon:&nbsp;</label>";
                echo "<span id='number_prefix'>(+373)/0</span><input type='text' required disabled name='tel' id='tel' value='".$row['numar_tel']."'>";

                echo "<br>";

                echo "<label for='suma'>Suma:&nbsp;</label>";
                echo "<input type='text' required disabled name='suma' id='suma' value='".$row['suma']."'>";

                echo "<br>";

                echo "<label for='comentariu'>Comentariu:&nbsp;</label>";
                echo "<textarea class='form-control' required disabled name='comentariu' id='comentariu'>".$row['commentariu']."</textarea>";

                echo "<br>";

                echo "<label for='data'>Data:</label>";
                echo "<input type='text' required disabled name='data' id='data' value='".$row['data']."'>";

                echo "<br>";

                echo "<label for='sistema'>Modalitatea de achitare</label>";
                echo "<input type='text' class='form-control' required disabled name='sistema' id='sistema' value='".$row['sistema']."'>";

                echo "</form>";

                echo "<hr id='form_separator'>";

                echo "</div>";
            }

            ?>

        </div>

    </div>

    </body>
</html>
