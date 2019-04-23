<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER['QUERY_STRING'];

?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Items</title>
</head>

<body>
<div class="home-page">
    <?php
    include 'navbar.php';
    ?>
    <br>
    <div class="main">
        <div class="container">
            <div class="jumbotron">
                <h1 class="text-center">
                    <i class="fa fa-exclamation-triangle"></i>
                    <br>The page you were looking for was not found!
                </h1>
            </div>
        </div>
    </div>
</div>
</body>
</html>