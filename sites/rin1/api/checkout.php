<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db/functions.php';

$db = new Functions();

$basketItems = $db->getBasket($_SESSION['customer']['email'], $_SESSION["WebsiteDetails"]["WebsiteID"]);

$orderID = uniqid();

while($item = $basketItems->fetch_assoc()){
    $db->checkOut($orderID, $item["ProductID"], $item["Quantity"], $_SESSION['customer']['email']);
}

$db->clearBasket($_SESSION["WebsiteDetails"]["WebsiteID"], $_SESSION['customer']['email']);
unset($_SESSION["TotalPrice"]);

header('Location: ../basket.php');
?>