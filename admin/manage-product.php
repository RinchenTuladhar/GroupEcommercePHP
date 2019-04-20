<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

include '../api/db-access.php';
?>

<html>
<head>
    <?php include '../api/scripts.php'; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>BuildMyStore: Admin</title>
</head>


<body>
<?php include 'navbar-admin.php'; ?>
<div class="main admin-main">
    <div class="col-md-12">
        <h2>Product List</h2>
        <div class="edit-product-form" style="display: none;">
            <h5>Edit Product:</h5>
            <br>
            <div class="col-md-6">
                <form method="POST" action="../api/edit-product.php">
                    <label for="product-name">
                        Product Name:
                    </label>
                    <input type="text" class="form-control" name="name" id="product-name" minlength="1">

                    <label for="product-stock">
                        Stock:
                    </label>
                    <input type="number" class="form-control" name="stock" id="product-stock" min="0">

                    <label for="product-price">
                        Product Price (£):
                    </label>
                    <input type="number" class="form-control" name="price" id="product-price" min="0">
                    <input type="hidden" class="form-control" name="product-id" id="product-id">
                    <br>
                    <input type="button" id="cancelBtn" class="btn btn-danger float-right" value="Cancel">
                    <input type="submit" value="Update" class="btn btn-success">
                </form>
            </div>
        </div>
        <table class="table product-table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Stock Qty</th>
                <th scope="col">Category</th>
                <th scope="col">Edit</th>
            </tr>
            </thead>
            <tbody>
            <?php

            // Gets list of all products linked to the Website
            $productList = $db->displayAllProducts($_SESSION["WebsiteID"]);

            // Loops through each product
            while ($row = $productList->fetch_assoc()) {

                ?>
                <tr>
                    <!-- PRODUCT DETAILS -->
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["Stock"]; ?></td>
                    <td><?php echo $row["Category"]; ?></td>
                    <td><input type="button" value="Edit"
                               onclick="editProduct('<?php echo $row["Name"]; ?>','<?php echo $row["Price"]; ?>', '<?php echo $row["Stock"]; ?>', '<?php echo $row["ProductID"]; ?>')"
                               class="btn btn-success"></td>
                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>

    </div>
</div>
<script type="text/javascript">
    // WowJS Animation Set
    function animateCSS(element, animationName, callback) {
        const node = document.querySelector(element);
        node.classList.add('animated', animationName);

        function handleAnimationEnd() {
            node.removeEventListener('animationend', handleAnimationEnd);

            if (typeof callback === 'function') callback()
        }

        node.addEventListener('animationend', handleAnimationEnd);
    }

    // Removing the animation
    $('#cancelBtn').click(function () {
        const node = document.querySelector(".edit-product-form");
        node.classList.remove('animated', 'slideInUp');

        const formNode = document.querySelector(".product-table");
        formNode.classList.remove('animated', 'slideOutRight');

        animateCSS('.edit-product-form', 'slideOutUp', function () {
            $('.edit-product-form').css("display", "none");
            document.querySelector('.edit-product-form').classList.remove('slideOutUp');
        });
    });

    // Animation for editing product
    function editProduct(name, price, stock, productID) {
        animateCSS('.product-table', 'slideOutRight', function () {
            $('.edit-product-form').css("display", "block");
            animateCSS('.edit-product-form', 'slideInUp');
        });

        $('#product-name').val(name);
        $('#product-stock').val(price);
        $('#product-price').val(stock);
        $('#product-id').val(productID);
    }
</script>
</body>
</html>

