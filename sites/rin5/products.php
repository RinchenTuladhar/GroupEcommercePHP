<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Home</title>
</head>

<body>
<div class="home-page">
    <?php include 'navbar.php'; ?>
    <div class="main">
        <div class="product-list container">
            <h1>Product Title</h1>
            <div class="row">
                <div class="col-md-4">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="https://asda.scene7.com/is/image/Asda/5057476079837?hei=560&qlt=85&fmt=pjpg&resmode=sharp&op_usm=1.1,0.5,0,0&defaultimage=default_details_George_rd">
                        </div>
                        <div class="product-title">
                            <p><a href="item.php">Luxury jumper</a></p>
                        </div>
                        <div class="product-price">
                            <p>£60.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="https://lostsoles.co.uk/wp-content/uploads/2018/06/ase-grey-hood-750x1125.jpg">
                        </div>
                        <div class="product-title">
                            <p>Luxury jumper</p>
                        </div>
                        <div class="product-price">
                            <p>£60.00</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="https://images.topman.com/i/TopMan/TM76G02ONAV_M_1.jpg?$Zoom$">
                        </div>
                        <span class="product-title">
                            <p>Luxury jumper</p>
                        </span>
                        <span class="product-price">
                            <p>£60.00</p>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>