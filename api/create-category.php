<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

if(isset($_POST["category"])) {
    $categories = $_POST["category"];
    $websiteID = $_POST["website_id"];

    $category = $db->createCategory($categories, $websiteID);

    if ($category != false) {
        $_SESSION["category"] = true;
        header("Location:../admin/dashboard.php");
    }
}
?>