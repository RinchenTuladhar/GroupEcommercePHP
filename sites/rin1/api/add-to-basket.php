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

$basket = $db->addToBasket($websiteID, $email, $productID, $quantity);

var_dump($email);