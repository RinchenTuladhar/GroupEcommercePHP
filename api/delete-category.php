<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();


// If deleting sub category
if(isset($_POST["cat"]) && $_POST["subcat"] != null){
    $db->deleteSubCategory($_POST["cat"], $_POST["subcat"], $_SESSION["WebsiteID"]);
}
// If deleting category
else if (isset($_POST["cat"])){
    $db->deleteCategory($_POST["cat"], $_SESSION["WebsiteID"]);
}