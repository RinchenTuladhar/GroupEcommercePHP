<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$query = $_SERVER['QUERY_STRING'];

$totalPrice = 0;
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>Items</title>
</head>

<body>
<div class="home-page item-main">
    <?php
    include 'navbar.php';
    ?>
    <div class="main">
        <div class="item-container container">
            <h1>Basket</h1>
            <div class="col-md-12 row">
                <div class=" col-md-8">
                    <?php
                    $basketItems = $db->getBasket($_SESSION['customer']['email'], $_SESSION["WebsiteDetails"]["WebsiteID"]);
                    while($row = $basketItems->fetch_assoc()){
                        $item = $db->getItemInformation($_SESSION["WebsiteDetails"]["WebsiteID"], $row["ProductID"]);
                        $totalPrice = $totalPrice + $item["Price"] * $row["Quantity"];
                        ?>
                    <div class="item-row">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="img/items/<?php echo $row["ProductID"]; ?>.jpg">
                            </div>
                            <div class="col-md-5">
                                <p><?php echo($item["Name"]); ?></p>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control" value="<?php echo $row["Quantity"]; ?>">
                            </div>
                            <div class="col-md-3">
                                £<?php echo $item["Price"]; ?>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="col-md-4">
                    <h2>Total</h2>
                    <hr/>
                    <p><strong>Sub-total: </strong>£<?php echo $totalPrice?></p>
                    <a class="btn btn-success" value="Checkout" href="api/checkout.php">Checkout</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>