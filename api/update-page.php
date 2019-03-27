<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$htmlContent = null;
$websiteID = $_SESSION["WebsiteID"];

$category = $_POST["category"];
$subCategory = $_POST["sub_category"];

if(isset($_POST["text_editor"])){
    $htmlContent = convertData($_POST['text_editor']);
} else if(isset($_POST["category_text_editor"])){
    $htmlContent = convertData($_POST['category_text_editor']);
}

function convertData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$result = $db->updatePage($websiteID, $category, $subCategory, $htmlContent);

header('Location: ' . $_SERVER['HTTP_REFERER']);
