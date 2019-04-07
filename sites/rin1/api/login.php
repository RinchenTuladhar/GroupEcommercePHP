<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $websiteID = $_POST['website-id'];

    $user = $db->checkPassword($email, $password, $websiteID);

    if ($user != false) {
        $_SESSION['store_loggedin'] = true;
        $_SESSION['customer']['email'] = $user["Email"];
        $_SESSION['customer']['FirstName'] = $user["FirstName"];
        $_SESSION["customer"]["LastName"] = $user["LastName"];

        header("Location: ../index.php");
    } else {
        $_SESSION['Error'] = "Your email / password is Incorrect. Please try again!";
        header("Location:../login.php");
    }
}
?>