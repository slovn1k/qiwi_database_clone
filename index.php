<?php

    session_start();
    require 'db.php';

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Qiwi Client Database</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
    </head>
    <body class="body">

        <div class="col-lg-3" style="width: 300px; position: absolute; top: 50%; left: 50%; z-index: 15; margin: -150px 0 0 -150px;">
            <form name="login_form" action="admin_panel/index.php" method="post">

                <h3>Forma de logare</h3>

                <div class="form-group">
                    <label for="user">Introduceti user</label>
                    <input type="text" class="form-control" name="user" placeholder="user">
                </div>

                <div class="form-group">
                    <label for="password">Introduceti parola</label>
                    <input type="password" maxlength="8" class="form-control" name="password" placeholder="parola">
                </div>

                <div>
                    <input type="submit" class="btn btn-primary" id="login_button" value="Intra">
                </div>
            </form>
        </div>

    </body>
</html>
