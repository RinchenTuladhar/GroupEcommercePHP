<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'db/functions.php';

$db = new Functions();

$firstName = $_POST["first_name"];
$lastName = $_POST["last_name"];
$email = $_POST["email"];

