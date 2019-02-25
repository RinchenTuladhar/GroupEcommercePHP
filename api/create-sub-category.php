<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();


$category = $_POST["category"];
$sub_category = $_POST["sub-category"];
$websiteID = $_POST["website_id"];

if (isset($_POST["sub-category"])) {
    $subcat = $db->createSubCategory($category, $websiteID, $sub_category);
    header('Location: ' . $_SERVER['HTTP_REFERER']);

}
?>