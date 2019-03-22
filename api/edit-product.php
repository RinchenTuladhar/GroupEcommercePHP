<?php

session_start();
require_once 'db/functions.php';

$db = new Functions();

$productName = $_POST["name"];
$productStock = $_POST["stock"];
$productPrice = $_POST["price"];
$productID = $_POST["product-id"];

if(isset($productName) && isset($productStock) && isset($productPrice)){
    $updatedProduct = $db->updateProductInfo($productID, $productName, $productPrice, $productStock);
}

header('Location: ' . $_SERVER['HTTP_REFERER']);