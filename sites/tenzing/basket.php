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
    ?>
    <div class="main">
        <div class="item-container container">
            <h1>Basket</h1>
            <div class="col-md-12 row">
                <div class=" col-md-8">
                    <div class="item-row">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="img/items/5c200a55e93a9.jpg">
                            </div>
                            <div class="col-md-5">
                                <p>Retro Hoodie</p>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                £45.00
                            </div>
                        </div>
                    </div><div class="item-row">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="img/items/5c200a55e93a9.jpg">
                            </div>
                            <div class="col-md-5">
                                <p>Retro Hoodie</p>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                £45.00
                            </div>
                        </div>
                    </div><div class="item-row">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="img/items/5c200a55e93a9.jpg">
                            </div>
                            <div class="col-md-5">
                                <p>Retro Hoodie</p>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                £45.00
                            </div>
                        </div>
                    </div><div class="item-row">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="img/items/5c200a55e93a9.jpg">
                            </div>
                            <div class="col-md-5">
                                <p>Retro Hoodie</p>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control">
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                £45.00
                            </div>
                        </div>
                    </div></div><div class="col-md-4">
                    <h2>Total</h2>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

</html>