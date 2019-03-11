<?php

session_start();
require_once 'db/functions.php';

$db = new Functions();

if( isset($_POST['websiteID']) && isset($_POST['title']) && isset($_POST['mode'])){
    $sql = $db->setNavigationMode($_POST['websiteID'], $_POST['title'], $_POST['mode']);
} else if(isset($_POST['websiteID']) && isset($_POST['navigationList'])){
    $sql = $db->setNavigationOrder($_POST["websiteID"], $_POST["navigationList"]);
}