<?php

  session_start();

  if($_SERVER['SERVER_PORT'] !== 443 &&
      (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off')) {
      header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
      exit;
  }

  header("Content-type: text/xml");

  $server = "localhost";
  $user = "root";
  $password = "";
  $database = "qiwi_user_database";
  $suma_achitat = 0.00;
  $identifier = "bpay";

    if(isset($_GET) && !empty($_GET)) {
      switch (strtolower($_GET['command'])) {
          case 'check' : {

              if (isset($_GET['account']) && !empty($_GET['account'])) {

                  if (!preg_match('/^[0-9]{7}$/', $_GET['account'])) {

                      $connection = new mysqli($server, $user, $password, $database);

                      if (!$connection) {
                          die("Erroare la conectare cu baza de date" . $connection->error);
                      }

                      $sql = "SELECT *FROM client WHERE numar_tel='{$_GET['account']}' AND `suma` > 0 LIMIT 0,1";
                      $result = $connection->query($sql);
                      $row = $result->fetch_assoc();
                      if (isset($row) && !empty($row)) {

                          if ($_GET['sum'] === '10.00') {
                              $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                              $xml .= "<response>";
                              $xml .= "<osmp_txn_id>{$_GET['txn_id']}</osmp_txn_id>";
                              $xml .= "<prv_txn>{$row['id_client']}</prv_txn>";
                              $xml .= "<ammount>".sprintf('%01.2f', $_GET['sum'])."</ammount>";
                              $xml .= "<result>000</result>";
                              $xml .= "<comment>OK</comment>";
                              $xml .= "</response>";
                              echo $xml;

                          } else {

                              if (sprintf("%01.2f", $_GET['sum']) === sprintf("%01.2f", $row['sum'])) {

                                  $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                                  $xml .= "<response>";
                                  $xml .= "<osmp_txn_id>{$_GET['txn_id']}</osmp_txn_id>";
                                  $xml .= "<prv_txn>{$row['id_client']}</prv_txn>";
                                  $xml .= "<ammount>".sprintf('%01.2f', $_GET['sum'])."</ammount>";
                                  $xml .= "<result>000</result>";
                                  $xml .= "<comment>OK</comment>";
                                  $xml .= "</response>";
                                  echo $xml;

                              } else {
                                  if ((double)sprintf("%01.2f", $_GET['suma']) > (double)sprintf("%01.2f", $row['suma'])) {
                                      $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                                      $xml .= "<response>";
                                      $xml .= "<result>008</result>";
                                      $xml .= "<comment>Сумма слишком велика</comment>";
                                      $xml .= "</response>";
                                      echo $xml;
                                  } else {
                                      $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                                      $xml .= "<response>";
                                      $xml .= "<result>007</result>";
                                      $xml .= "<comment>Сумма слишком мала</comment>";
                                      $xml .= "</response>";
                                      echo $xml;
                                  }
                              }
                          }

                      } else {
                          $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                          $xml .= "<response>";
                          $xml .= "<result>004</result>";
                          $xml .= "<comment>Идентификатор абонента не найден (Ошиблись номером)</comment>";
                          $xml .= "</response>";
                          echo $xml;
                      }
                      $connection->close();
                  } else {
                      $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                      $xml .= "<response>";
                      $xml .= "<result>003</result>";
                      $xml .= "<comment>Неверный формат параметров в запросе</comment>";
                      $xml .= "</response>";
                      echo $xml;
                  }
              }
              break;
          }
          case 'pay': {

              if (isset($_GET['account']) && !empty($_GET['account'])) {
                  if (!preg_match("/^[0-9]{7}$/", $_GET['account'])) {
                      if (!preg_match("/^[0-9]{13}$/", $_GET['txn_date'])) {
                          $connection = new mysqli($server, $user, $password, $database);

                          if ($connection->connect_error) {
                              die("Erroare la conectarea cu baza de date: " . $connection->connect_error);
                          }

                          $sql = "SELECT *FROM client WHERE numar_tel='{$_GET['account']}' AND `suma` > 0 LIMIT 0,1";
                          $res = $connection->query($sql);
                          $row = $res->fetch_assoc();

                          if (isset($row) && !empty($row)) {
                              if (sprintf("%01.2f", $_GET['sum']) === sprintf("%01.2f", $row['suma'])) {
                                  $date = substr($_GET['txn_date'], 0, 4) . '-' . substr($_GET['txn_date'], 4, 2) . '-' . substr($_GET['txn_date'], 6, 2) . ' ' . substr($_GET['txn_date'], 8, 2) . ':' . substr($_GET['txn_date'], 10, 2) . ':' . substr($_GET['txn_date'], 12, 2);
                                  $connection->query("UPDATE `client` SET `data` = '{$date}', `suma`=0.00, `commentariu`='Achitat={$row['suma']}', `sistema` = '{$identifier}' WHERE `id_client`='{$row['id_client']}'");
                                  $suma_achitat += $row['suma'];
                                  $connection->query("INSERT INTO client_achitat_bpay (suma) VALUES ('{$suma_achitat}')");
                                  $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                                  $xml .= "<response>";
                                  $xml .= "<osmp_txn_id>{$_GET['txn_id']}</osmp_txn_id>";
                                  $xml .= "<prv_txn>{$row['id_client']}</prv_txn>";
                                  $xml .= "<ammount>" . sprintf("%01.2f", $_GET['sum']) . "</ammount>";
                                  $xml .= "<result>000</result>";
                                  $xml .= "<comment>OK</comment>";
                                  $xml .= "</response>";
                                  echo $xml;
                              } else {
                                  if((double)sprintf("%01.2f", $_GET['sum']) > (double)sprintf("%01.2f", $row['suma'])) {
                                      $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                                      $xml .= "<response>";
                                      $xml .= "<result>008</result>";
                                      $xml .= "<comment>Сумма слишком велика</comment>";
                                      $xml .= "</reponse>";
                                      echo $xml;
                                  } else {
                                      $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                                      $xml .= "<response>";
                                      $xml .= "<result>007</result>";
                                      $xml .= "<comment>Сумма слишком мала</comment>";
                                      $xml .= "</response>";
                                      echo $xml;
                                  }
                              }
                          } else {
                              $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                              $xml .= "<response>";
                              $xml .= "<result>004</result>";
                              $xml .= "<comment>Идентификатор абонента не найден (Ошиблись номером)</comment>";
                              $xml .= "</response>";
                              echo $xml;
                          }
                          $connection->close();
                      } else {
                          $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                          $xml .= "<response>";
                          $xml .= "<result>003</result>";
                          $xml .= "<comment>Неверный формат параметров в запросе</comment>";
                          $xml .= "</response>";
                          echo $xml;
                      }
                  } else {
                      $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                      $xml .= "<response>";
                      $xml .= "<result>003</result>";
                      $xml .= "<comment>Неверный формат параметров в запросе</comment>";
                      $xml .= "</response>";
                      echo $xml;
                  }
              } else {
                  $xml = "<?xml version='1.0' encoding='UTF-8'?>";
                  $xml .= "<response>";
                  $xml .= "<result>003</result>";
                  $xml .= "<comment>Неверный формат параметров в запросе</comment>";
                  $xml .= "</response>";
                  echo $xml;
              }
              break;
          }
          default: {
              $xml = "<?xml version='1.0' encoding='UTF-8'?>";
              $xml .= "<response>";
              $xml .= "<result>300</result>";
              $xml .= "<comment>Другая ошибка провайдера</comment>";
              $xml .= "</response>";
              echo $xml;
          }
      }

  } else {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<response>';
        $xml .= '<result>300</result>';
        $xml .= '<comment>Другая ошибка провайдера</comment>';
        $xml .= '</response>';
        echo $xml;
}

?>
