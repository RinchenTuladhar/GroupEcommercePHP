<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

if(isset($_POST["domain_name"])){
    $domainName = $_POST["domain_name"];
    $websiteID = $_POST["website_id"];


    $domain = $db->createDomainName($domainName, $websiteID);

    if($domain != false){
        header("Location:../admin.php");
    }
}


?>