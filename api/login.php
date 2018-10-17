<?php
session_start();
require_once 'db/functions.php';

$db = new Functions();

if(isset($_POST['email']) && isset($_POST['password'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $db->checkPassword($email, $password);

    if ($user != false) {
        echo $user["email"];
        $_SESSION['loggedin'] = true;
        $_SESSION["email"] = $user["email"];
        $_SESSION["FirstName"] = $user["FirstName"];
        $_SESSION["LastName"] = $user["LastName"];
        header("Location: ../admin.php");
    } else {
        $_SESSION['Error'] = "Your email / password is Incorrect. Please try again!";
        header("Location:../login.php");
    }
}
?>