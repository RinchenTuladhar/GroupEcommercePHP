<?php
session_start();
require_once 'db/functions.php';
$db = new Functions();

$first_name = $_POST['first_name'];
$last_name = $_POST['last_name'];
$email = $_POST['email'];
$password = $_POST['password'];

$user = $db->createAdmin($first_name, $last_name, $email,  $password);


if($user){
    header("Location:../login.php");
} else {
    header("Location: ../signup.php");
    $_SESSION['Error'] = "<h4>Error: This email has already been used to register - please sign in!</h4>";
}
?>