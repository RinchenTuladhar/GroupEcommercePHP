<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$category = $_GET["category"];
$subCategory = $_GET["subCategory"];


$content = $db->getContent($_SESSION["WebsiteID"], $category, $subCategory);

echo htmlspecialchars_decode($content->fetch_assoc()["Content"]);
?>