<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db/functions.php';

$db = new Functions();

$productID = $_POST["id"];
$websiteID = $_SESSION["WebsiteDetails"]["WebsiteID"];
$email = $_SESSION['customer']['email'];
$price = $_POST["price"];
$quantity = $_POST["quantity"];

$basket = $db->addToBasket($websiteID, $email, $productID, $quantity);