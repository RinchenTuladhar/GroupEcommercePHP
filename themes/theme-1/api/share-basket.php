<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

$sharedEmail = $_POST["shared-email"];

if(isset($sharedEmail)){
    $user = $db->getUserByEmail($sharedEmail, $_SESSION["WebsiteDetails"]["WebsiteID"]);

    if($user != null){
        if($user["SharedBasket"] == NULL){
           $sharedBasket = $db->addSharedBasket($_SESSION['customer']['email'], $sharedEmail,$_SESSION["WebsiteDetails"]["WebsiteID"] );
        }
    }
}