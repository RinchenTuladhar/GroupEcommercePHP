<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db/functions.php';

$db = new Functions();

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];
$oldEmail = $_POST["old_email"];

$_SESSION['customer']['FirstName'] = $firstName;
$_SESSION["customer"]["LastName"] = $lastName;

if($oldEmail != $email){
   $doesUserExist = $db->getUserByEmail($email, $_SESSION["WebsiteDetails"]["WebsiteID"]);

   if($doesUserExist === null){
       $editInfo = $db->updateCustomer($firstName, $lastName, $oldEmail, $email, $_SESSION["WebsiteDetails"]["WebsiteID"]);
       var_dump($editInfo);
       if($editInfo){
           $_SESSION['customer']['email'] = $email;
       }
   }
}
//header('Location: ../my-account.php');