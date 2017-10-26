<?php

$server = "localhost";
$user = "root";
$password = "";
$database = "qiwi_user_database";

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

$xml->startElement('response');


while ($row = $res->fetch_assoc()) {

    $xml->startElement("response");

    $xml->startElement("osmp_txn_id");
    $xml->writeRaw($row["id_client"]);
    $xml->endElement();

    $xml->startElement("prv_txn");
    $xml->writeRaw($row['nume']);
    $xml->endElement();

    $xml->startElement("sum");
    $xml->writeRaw($row['suma']);
    $xml->endElement();

    $xml->startElement("ccy");
    $xml->writeRaw($row['numar_tel']);
    $xml->endElement();

    $xml->startElement("result");
    $xml->writeRaw($row['suma']);
    $xml->endElement();

    $xml->startElement("comment");
    $xml->writeRaw($row['suma']);
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
$connection->close();

?>