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
    $itemArray = $db->getItemInformation($_SESSION["WebsiteDetails"]["WebsiteID"], $query);
    $item = $itemArray->fetch_assoc();
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
                <div class="col-md-7">
                    <h2>Price</h2>
                    <p>£<?php echo $item["Price"]; ?></p>
                    <h2>Description</h2>
                    <p><?php echo $item["Description"]; ?></p>
                    <input type="hidden" class="item-id" value="<?php echo $item['ProductID']?>">
                    <input type="button" id="basketBtn" class="btn btn-default" value="Add To Basket">
                </div>
            </div>

        </div>
    </div>
</div>

</body>

<script type="text/javascript">
    $('#basketBtn').click(function() {
        var itemID = $('.item-id').val();
        $.ajax({
            type: "POST",
            url: "api/add-to-basket.php",
            data: { id: itemID}
        }).done(function( value ) {
        });


    });
</script>
</html>