<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER ['QUERY_STRING'];
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Website Name: Item Name</title>
</head>

<body>
<div class="home-page">
    <?php include 'navbar.php';

    $itemArray = $db->getItemInformation($_SESSION["WebsiteDetails"]["WebsiteID"], $query);
    $item = $itemArray->fetch_assoc();
    ?>
    <div class="main">
        <div class="item-container container">
            <h1 class="item-title"><?php
                echo $item["Name"];
                ?></h1>
            <div class="row">
                <div class="col-md-3">
                    <h2>Description</h2>
                    <p><?php echo $item["Description"]; ?></p>
                </div>
                <div class="item-image col-md-6">
                    <img class="item-image" src="img/items/<?php echo $item["ProductID"]; ?>.jpg">
                </div>
                <div class="col-md-3">
                    <h2>Details</h2>
                    <p>Price: £<?php echo $item["Price"]; ?></p>
                    <input type="button" class="btn btn-default" value="Add To Basket">
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>
