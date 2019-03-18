<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$revenue = null;

$result = [];
if(isset($_GET["to"]) && isset($_GET["from"])){
    $to = strtotime($_GET["to"]);
    $from = strtotime($_GET["from"]);

    // Orders Created
    $orderAmount = $db->getAmountOfOrdersByDate($from, $to, $_SESSION["WebsiteID"])->fetch_assoc()["Total"];
    $orderObject = new stdClass();
    $orderObject->type = "Orders";
    $orderObject->result = $orderAmount;
    array_push($result, $orderObject);

    // Revenue
    $revenue = $db->getRevenueFromDate($from, $to, $_SESSION["WebsiteID"])->fetch_assoc()["Price"];

    $revenueObject = new stdClass();
    $revenueObject->type = "Revenue";
    $revenueObject->result = $revenue;
    array_push($result, $revenueObject);

    //Profit
    $profit = $db->getTotalProfitByDate($from, $to, $_SESSION["WebsiteID"])->fetch_assoc()["Profit"];

    $profitObject = new stdClass();
    $profitObject->type = "Profit";
    $profitObject->result = $profit;
    array_push($result, $profitObject);

    // Items Purchased
    $purchased = $db->getAmountOfItemsPurchasedByDate($from, $to, $_SESSION["WebsiteID"])->fetch_assoc()["Total"];
    $purchasedObject = new stdClass();
    $purchasedObject->type = "Purchased";
    $purchasedObject->result = $purchased;
    array_push($result, $purchasedObject);

}

echo json_encode($result);