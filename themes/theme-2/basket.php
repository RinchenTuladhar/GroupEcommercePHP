<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER ['QUERY_STRING'];
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Basket</title>
</head>

<body>
<div class="home-page">
    <?php include 'navbar.php'; ?>
    <div class="main">
    </div>
</div>

</body>

</html>