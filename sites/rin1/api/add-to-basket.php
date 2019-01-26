<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db/functions.php';

$db = new Functions();

$productID = $_POST["id"];
$websiteID = $_SESSION["WebsiteDetails"]["WebsiteID"];
$email = $_SESSION['customer']['email'];
$quantity = 1;
$price = $_POST["price"];

$basket = $db->addToBasket($websiteID, $email, $productID, $quantity);

if(isset($_SESSION["TotalPrice"])){
    $_SESSION["TotalPrice"] = $_SESSION["TotalPrice"] + $price;
} else {
    $_SESSION["TotalPrice"] = $price;
}