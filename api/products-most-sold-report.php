<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$revenue = null;

$result = [];
if(isset($_GET["to"]) && isset($_GET["from"])) {
    $to = strtotime($_GET["to"]);
    $from = strtotime($_GET["from"]);

    $mostSold = $db->getMostSoldByDate($from, $to, $_SESSION["WebsiteID"]);


    foreach($mostSold as $row){
        $result[] = array(
            'name'   => $row["Name"],
            'quantity'  => $row["Quantity"]
        );
    }
    echo json_encode($result);
}
