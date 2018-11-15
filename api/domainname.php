<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

if(isset($_POST["domain_name"])){
    $domainName = $_POST["domain_name"];
    $websiteID = $_POST["website_id"];


    $domain = $db->createDomainName($domainName, $websiteID);

    if($domain != false){
        $_SESSION["hasDomain"]["DomainName"] = $domainName;
        header("Location:../admin.php");
    }
}

function copy_theme($theme_destination,$site_destination) {
    $dir = opendir($theme_destination);
    @mkdir($site_destination);
    while(( $file = readdir($dir)) !== false) {
        if (( $file != '.' ) && ( $file != '..' )) {
            if ( is_dir($theme_destination . '/' . $file) ) {
                copy_theme($theme_destination . '/' . $file,$site_destination . '/' . $file);
            }
            else {
                copy($theme_destination . '/' . $file,$site_destination . '/' . $file);
            }
        }
    }
    closedir($dir);
}

?>