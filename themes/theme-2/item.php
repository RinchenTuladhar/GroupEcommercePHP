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
<div class="home-page item-main">
    <?php
    include 'navbar.php';
    $item = $db->getItemInformation($_SESSION["WebsiteDetails"]["WebsiteID"], $query);
    ?>
    <div class="main">
        <div class="item-container container">
            <h1><?php
                echo $item["Name"];
                ?></h1>
            <div class="row">
                <div class="col-md-5">
                    <img class="item-image" src="img/items/<?php echo $item["ProductID"]; ?>.jpg">
                </div>
                <div class="col-md-4">
                    <h2>Description</h2>
                    <p><?php echo $item["Description"]; ?></p>
                    <h2>Price</h2>
                    <p>£<span class="item-price"><?php echo $item["Price"]; ?></span></p>
                </div>
                <div class="col-md-3">
                    <h2>Quantity</h2>
                    <input type="number" class="form-control item-amount" value="1" id="item-amount"> <br>
                    <input type="button" id="basketBtn" class="btn btn-default" value="Add To Basket">
                    <input type="hidden" class="item-id" value="<?php echo $item['ProductID']?>">
                </div>
            </div>

        </div>
    </div>
</div>

</body>

<script type="text/javascript">
    $('#basketBtn').click(function() {
        var itemID = $('.item-id').val();
        var price = parseFloat($('.item-price').text());
        var quantity = $('#item-amount').val();

        $.ajax({
            type: "POST",
            url: "api/add-to-basket.php",
            data: { id: itemID, price: price, quantity: quantity}
        }).done(function( value ) {
            $('#basket-price').text(value);
        });


    });
</script>
</html>