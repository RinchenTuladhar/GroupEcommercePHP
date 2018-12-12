<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../../api/db-access.php';

$query = $_SERVER ['QUERY_STRING'];
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Website Name: Item Name</title>
</head>

<body>


</body>

</html>