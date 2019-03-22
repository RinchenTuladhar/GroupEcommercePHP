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
        <div class="basket-container">
            <div class="container">
                <div class="row">
                    <div class="col-md-8">
                        <h1>Basket</h1>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th></th>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $basketItems = $db->getBasket($_SESSION['customer']['email'], $_SESSION["WebsiteDetails"]["WebsiteID"]);
                            while($row = $basketItems->fetch_assoc()){
                            $item = $db->getItemInformation($_SESSION["WebsiteDetails"]["WebsiteID"], $row["ProductID"]);
                            $totalPrice = $totalPrice + $item["Price"] * $row["Quantity"];
                            ?>
                                <tr>
                                    <td>
                                        <img src="img/items/5c24dcb5accef.jpg">
                                    </td>
                                    <td><?php echo($item["Name"]); ?></td>
                                    <td><?php echo $item["Price"]; ?></td>
                                    <td>
                                        <input type="number" class="form-control" value="<?php echo $row["Quantity"]; ?>">
                                    </td>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <h2>Checkout</h2>
                        <hr/>
                        <p>Total: £00.00</p>
                        <input type="button" class="btn btn-default" value="Checkout">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>