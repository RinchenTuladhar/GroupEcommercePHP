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
            <h1>Category Title</h1>
            <div class="row">
                <div class="col-md-3">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="https://www.iceland.co.uk/_assets/images/cache/autoxauto/6923.jpg">
                        </div>
                        <div class="product-description">
                            <div class="product-title">
                                <p><a href="item.php">Jam Donuts</a></p>
                            </div>
                            <div class="product-price">
                                <p>£0.89</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="http://groceries.iceland.co.uk/medias/sys_master/root/h03/he6/8845267140638.jpg">
                        </div>
                        <div class="product-description">

                            <div class="product-title">
                                <p>Megabox</p>
                            </div>
                            <div class="product-price">
                                <p>£2.00</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="http://groceries.iceland.co.uk/medias/sys_master/root/h58/h92/8971756568606.jpg">
                        </div>
                        <div class="product-description">

                        <span class="product-title">
                            <p>Peri Chicken</p>
                        </span>
                            <span class="product-price">
                            <p>£6.00</p>
                        </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="product-wrapper">
                        <div class="product-image">
                            <img src="http://groceries.iceland.co.uk/medias/sys_master/root/hb2/he5/9019854258206.jpg">
                        </div>
                        <div class="product-description">
                        <span class="product-title">
                            <p>Cheesy Pasta</p>
                        </span>
                            <span class="product-price">
                            <p>£10.00</p>
                        </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>