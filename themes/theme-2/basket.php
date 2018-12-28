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
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>
                                    <img src="img/items/5c24dcb5accef.jpg">
                                </td>
                                <td>£45.00</td>
                                <td>
                                    <select class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="img/items/5c24dcb5accef.jpg">
                                </td>
                                <td>£45.00</td>
                                <td>
                                    <select class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="img/items/5c24dcb5accef.jpg">
                                </td>
                                <td>£45.00</td>
                                <td>
                                    <select class="form-control">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </td>
                            </tr>
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