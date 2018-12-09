<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

if(isset($_POST["theme"])){
    $themeName = $_POST["theme"];
    $websiteID = $_POST["website_id"];

    $theme = $db->setWebsiteTheme($websiteID, $themeName);

    if($theme != false){
        $_SESSION["hasDomain"]["Theme"] = true;

        copy_theme("../themes/" . $themeName, "../sites/" . $_SESSION["hasDomain"]["DomainName"]);
        header("Location:../admin/dashboard.php");
    }
}

// Copies theme folder & adds to /sites/ folder with site name
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