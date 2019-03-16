<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();


// If deleting sub category
if(isset($_POST["cat"]) && $_POST["subcat"] != null){
    echo "Sub";
}
// If deleting category
else if (isset($_POST["cat"])){
    echo "Cat";
    $db->deleteCategory($_POST["cat"], $_SESSION["WebsiteID"]);
}