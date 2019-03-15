<?php
session_start();
require_once 'db/functions.php';
$db = new Functions();

$filterInfo = $_GET["queryString"];
$mysqlquery = "SELECT * FROM venues WHERE ";
