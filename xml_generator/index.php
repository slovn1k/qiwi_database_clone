<?php

header("Content-type: text/xml");
//параметры БД
$server = "localhost";
$user = "root";
$password = "";
$database = "qiwi_user_database";

if(isset($_GET) && !empty($_GET)){
    switch(strtolower($_GET['command'])){
        case 'check':{
            if(isset($_GET['account']) && !empty($_GET['account'])){
                if(!preg_match('/^[0-9]{7}$/',$_GET['account'])) {
                    $connection = new mysqli($server, $user, $password, $database);

                    if ($connection->connect_error) {
                        die("Erroarea la conexiune cu baza de date: " . $connection->connect_error);
                    }

                    $sql = "SELECT * FROM client WHERE numar_tel='{$_GET['account']}' AND `suma` > 0 LIMIT 0,1";
                    $res = $connection->query($sql);
                    $row = $res->fetch_assoc();
                    if (isset($row) && !empty($row)) {
                        if ($_GET['sum'] === '10.00') {
                            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                            $xml .= '<response>';
                            $xml .= "<osmp_txn_id>{$_GET['txn_id']}</osmp_txn_id>";
                            $xml .= "<prv_txn>{$row['id_client']}</prv_txn>";
                            $xml .= '<sum>' . sprintf("%01.2f", $_GET['sum']) . '</sum>';
                            $xml .= '<ccy>MDL</ccy>';
                            $xml .= '<result>0</result>';
                            $xml .= '<comment>Аккаунт найден</comment>';
                            $xml .= '<fields>';
                            $xml .= '<field1 name="sum">' . sprintf("%01.2f", $row['suma']) . '</field1>';
                            $xml .= '</fields>';
                            $xml .= '</response>';
                            echo $xml;
                        } else {
                            if (sprintf("%01.2f", $_GET['sum']) === sprintf("%01.2f", $row['suma'])) {
                                $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                                $xml .= '<response>';
                                $xml .= "<osmp_txn_id>{$_GET['txn_id']}</osmp_txn_id>";
                                $xml .= "<prv_txn>{$row['id_client']}</prv_txn>";
                                $xml .= '<sum>' . sprintf("%01.2f", $_GET['sum']) . '</sum>';
                                $xml .= '<ccy>MDL</ccy>';
                                $xml .= '<result>0</result>';
                                $xml .= '<comment>ОК</comment>';
                                $xml .= '<fields>';
                                $xml .= '<field1 name="sum">' . sprintf("%01.2f", $row['suma']) . '</field1>';
                                $xml .= '</fields>';
                                $xml .= '</response>';
                                echo $xml;
                            } else {
                                if((double)sprintf("%01.2f", $_GET['sum']) > (double)sprintf("%01.2f", $row['suma'])) {
                                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                                    $xml.= '<response>';
                                    $xml.= '<result>242</result>';
                                    $xml.= '<comment>Сумма слишком велика</comment>';
                                    $xml.= '</response>';
                                    echo $xml;
                                } else {
                                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                                    $xml.= '<response>';
                                    $xml.= '<result>241</result>';
                                    $xml.= '<comment>Сумма слишком мала</comment>';
                                    $xml.= '</response>';
                                    echo $xml;
                                }
                            }
                        }
                    } else {
                        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                        $xml.= '<response>';
                        $xml.= '<result>5</result>';
                        $xml.= '<comment>Идентификатор абонента не найден (Ошиблись номером)</comment>';
                        $xml.= '</response>';
                        echo $xml;
                    }
                    $connection->close();
                } else {
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                    $xml.= '<response>';
                    $xml.= '<result>4</result>';
                    $xml.= '<comment>Неверный формат идентификатора абонента</comment>';
                    $xml.= '</response>';
                    echo $xml;
                }
            } else {
                $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                $xml.= '<response>';
                $xml.= '<result>8</result>';
                $xml.= '<comment>Пустые параметры аккаунта</comment>';
                $xml.= '</response>';
                echo $xml;
            }
            break;
        }
        case 'pay':{
            if(isset($_GET['account']) && !empty($_GET['account'])){
                if(!preg_match('/^[0-9]{7}$/',$_GET['account'])) {
                    if(!preg_match('/^[0-9]{13}$/',$_GET['txn_date'])) {
                        $connection = new mysqli($server, $user, $password, $database);

                        if ($connection->connect_error) {
                            die("Erroarea la conexiune cu baza de date: " . $connection->connect_error);
                        }

                        $sql = "SELECT * FROM client WHERE numar_tel='{$_GET['account']}' AND `suma` > 0 LIMIT 0,1";
                        $res = $connection->query($sql);
                        $row = $res->fetch_assoc();
                        if (isset($row) && !empty($row)) {
                            if (sprintf("%01.2f", $_GET['sum']) === sprintf("%01.2f", $row['suma'])) {
                                $date = substr($_GET['txn_date'], 0, 4) . '-' . substr($_GET['txn_date'], 4, 2) . '-' . substr($_GET['txn_date'], 6, 2) . ' ' .
                                    substr($_GET['txn_date'], 8, 2) . ':' . substr($_GET['txn_date'], 10, 2) . ':' . substr($_GET['txn_date'], 12, 2);
                                $connection->query("UPDATE `client` SET `data` = '{$date}', `suma`=0.00, `commentariu`='Achitat' WHERE `id_client`='{$row['id_client']}'");
                                $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                                $xml .= '<response>';
                                $xml .= "<osmp_txn_id>{$_GET['txn_id']}</osmp_txn_id>";
                                $xml .= "<prv_txn>{$row['id_client']}</prv_txn>";
                                $xml .= '<sum>' . sprintf("%01.2f", $_GET['sum']) . '</sum>';
                                $xml .= '<ccy>MDL</ccy>';
                                $xml .= '<result>0</result>';
                                $xml .= '<comment>ОК</comment>';
                                $xml .= '<fields>';
                                $xml .= "<field name='prv-date'>{$_GET['txn_date']}</field>";
                                $xml .= '</fields>';
                                $xml .= '</response>';
                                echo $xml;
                            } else {
                                if ((double)sprintf("%01.2f", $_GET['sum']) > (double)sprintf("%01.2f", $row['suma'])) {
                                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                                    $xml .= '<response>';
                                    $xml .= '<result>242</result>';
                                    $xml .= '<comment>Сумма слишком велика</comment>';
                                    $xml .= '</response>';
                                    echo $xml;
                                } else {
                                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                                    $xml .= '<response>';
                                    $xml .= '<result>241</result>';
                                    $xml .= '<comment>Сумма слишком мала</comment>';
                                    $xml .= '</response>';
                                    echo $xml;
                                }
                            }
                        } else {
                            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                            $xml .= '<response>';
                            $xml .= '<result>5</result>';
                            $xml .= '<comment>Идентификатор абонента не найден (Ошиблись номером)</comment>';
                            $xml .= '</response>';
                            echo $xml;
                        }
                        $connection->close();
                    } else {
                        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                        $xml.= '<response>';
                        $xml.= '<result>7</result>';
                        $xml.= '<comment>Неверный формат даты</comment>';
                        $xml.= '</response>';
                        echo $xml;
                    }
                } else {
                    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                    $xml.= '<response>';
                    $xml.= '<result>4</result>';
                    $xml.= '<comment>Неверный формат идентификатора абонента</comment>';
                    $xml.= '</response>';
                    echo $xml;
                }
            } else {
                $xml = '<?xml version="1.0" encoding="UTF-8"?>';
                $xml.= '<response>';
                $xml.= '<result>8</result>';
                $xml.= '<comment>Пустые параметры аккаунта</comment>';
                $xml.= '</response>';
                echo $xml;
            }
            break;
        }
        default:{
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml.= '<response>';
            $xml.= '<result>8</result>';
            $xml.= '<comment>Неверная команда</comment>';
            $xml.= '</response>';
            echo $xml;
        }
    }
} else {
    $xml = '<?xml version="1.0" encoding="UTF-8"?>';
    $xml.= '<response>';
    $xml.= '<result>8</result>';
    $xml.= '<comment>Пустые параметры запроса</comment>';
    $xml.= '</response>';
    echo $xml;
}
/*exit;



$connection = new mysqli($server, $user, $password, $database);

if($connection->connect_error) {
    die("Erroarea la conexiune cu baza de date: ".$connection->connect_error);
}

$sql = "SELECT *FROM client ORDER BY nume";
$res = $connection->query($sql);

$xml = new XMLWriter();

$xml->openURI("php://output");
$xml->startDocument();
$xml->setIndent(true);

$xml->startElement('document');

while ($row = $res->fetch_assoc()) {
    print_r($row);
    exit;
    $xml->startElement("response");

    $xml->startElement("osmp_txn_id");
    $xml->writeRaw($row["numar_tel"]);
    $xml->endElement();

    $xml->startElement("prv_txn");
    $xml->writeRaw($row['id_client']);
    $xml->endElement();

    $xml->startElement("service");
    $xml->writeRaw($row['directia']);
    $xml->endElement();

    $xml->startElement("sum");
    $xml->writeRaw($row['suma']);
    $xml->endElement();

    $xml->startElement("ccy");
    $xml->writeRaw("MDL");
    $xml->endElement();

    $xml->startElement("result");
    $xml->writeRaw("0");
    $xml->endElement();

    $xml->startElement("comment");
    $xml->writeRaw($row['commentariu']);
    $xml->endElement();

    $xml->startElement("fields");

    $xml->startElement("field");
    $xml->writeAttribute("name", "prv_date");
    $xml->writeRaw($row["data"]);
    $xml->fullEndElement();

    $xml->endElement();

    $xml->endElement();

}

$xml->endElement();

header("Content-type: text/xml");
$xml->flush();
$connection->close();*/

?>