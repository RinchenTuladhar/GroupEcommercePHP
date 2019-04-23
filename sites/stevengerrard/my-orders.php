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
<div class="home-page orders-main">
    <?php
    include 'navbar.php';

    $listOfOrders = $db->getMyOrders($_SESSION['customer']['email'], $_SESSION["WebsiteDetails"]["WebsiteID"]);

    ?>
    <div class="main">
        <div class="orders-container container">
            <br>
            <h1>My Orders</h1>
            <?php while($order = $listOfOrders->fetch_assoc()){

                $listOfOrderItems = $db->getOrderDetails($order["OrderID"]);

                ?>
            <div class="order-wrapper">
                <div class="order-header">
                    <div class="row">
                        <div class="col-md-6">
                            <h5>ORDER PLACED</h5>
                            <p><?php echo date("d F Y",$order["Timestamp"]);?></p>
                        </div>
                        <div class="col-md-4">
                            <h5>QUANTITY</h5>
                        </div>
                        <div class="col-md-2">
                            <p>ORDER #<?php echo strtoupper($order["OrderID"]); ?></p>
                        </div>
                    </div>
                </div>
                <div class="order-main">
                    <?php while($orderDetails = $listOfOrderItems->fetch_assoc()){
                        $itemInfo = $db->getItemInformation($_SESSION["WebsiteDetails"]["WebsiteID"], $orderDetails["ProductID"]);
                        ?>
                    <div class="item-wrapper">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="img/items/<?php echo $orderDetails["ProductID"]; ?>.jpg">
                            </div>
                            <div class="col-md-4">
                                <p><?php echo($itemInfo["Name"]); ?></p>
                            </div>
                            <div class="col-md-4">
                                <p><?php echo $orderDetails["Quantity"]; ?></p>
                            </div>
                            <div class="col-md-2">
                                <p>£<?php echo $itemInfo["Price"]; ?></p>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
            <?php }?>
        </div>
    </div>
</div>
