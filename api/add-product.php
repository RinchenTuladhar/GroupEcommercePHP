<?php
session_start();

require_once 'db/functions.php';
$db = new Functions();


if(isset($_POST["product_name"]) && isset($_POST["product_description"]) && isset($_POST["product_price"]) && isset($_POST["product_stock"])){
    $product_name = $_POST["product_name"];
    $product_description = $_POST["product_description"];
    $product_original_price = $_POST["product_original_price"];
    $product_price = $_POST["product_price"];
    $product_stock = $_POST["product_stock"];
    $website_id = $_POST["website_id"];
    $category = $_POST["category"];
    $sub_category = $_POST["sub_category"];
    $website_name = $_POST["website_name"];

    echo $category;

    $uniqueid = uniqid();
    $product = $db->createProduct($product_name, $product_description, $product_original_price, $product_price, $product_stock, $website_id, $category, $sub_category, $uniqueid);

    if($product != false){
        $file_tmp = $_FILES['image']['tmp_name'];
        $expensions = array(
            "jpeg",
            "jpg",
            "png"
        );

        move_uploaded_file($file_tmp, "../sites/" . $website_name. "/img/items/" . $uniqueid .".jpg");

    }
    header("Location:../admin/dashboard.php");
}

?>