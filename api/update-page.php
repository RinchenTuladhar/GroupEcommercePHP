<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$htmlContent = convertData($_POST['text_editor']);
$websiteID = $_POST["website_id"];
$page = $_POST["page"];

function convertData($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$result = $db->updatePage($websiteID, $page, $htmlContent);

header('Location: ' . $_SERVER['HTTP_REFERER']);
