<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$websiteID = $_GET["websiteID"];
$category = $_GET["category"];

$subCategories = $db->getSubCategories($category, $websiteID);

$html = "";
if ($subCategories->num_rows > 0) {
    while ($row = $subCategories->fetch_assoc()) {
        $title = $row["SubCategory"];
        $html .= "<option value='$title'>$title</option>";
    }
}

echo $html;