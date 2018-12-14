<?php

session_start();
require_once 'db/functions.php';

$db = new Functions();

if( isset($_POST['websiteID']) ){
    $sql = $db->setNavigationMode($_POST['websiteID'], $_POST['title'], $_POST['mode']);
    return "TEST";
}