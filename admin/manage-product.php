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
            <br>
            <div class="col-md-6">
                <label for="product-name">
                    Product Name:
                </label>
                <input type="text" class="form-control" name="name" id="product-name">

                <label for="product-stock">
                    Stock:
                </label>
                <input type="number" class="form-control" name="stock" id="product-stock">

                <label for="product-price">
                    Product Name:
                </label>
                <input type="text" class="form-control" name="price" id="product-price">
                <br>
                <input type="button" id="cancelBtn" class="btn btn-danger float-right" value="Cancel">
                <input type="submit" value="Update" class="btn btn-success">
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
            $productList = $db->displayAllProducts($_SESSION["WebsiteID"]);

            while ($row = $productList->fetch_assoc()) {

                ?>
                <tr>
                    <td><?php echo $row["Name"]; ?></td>
                    <td><?php echo $row["Price"]; ?></td>
                    <td><?php echo $row["Stock"]; ?></td>
                    <td><?php echo $row["Category"]; ?></td>
                    <td><input type="button" value="Edit"
                               onclick="editProduct('<?php echo $row["Name"]; ?>','<?php echo $row["Price"]; ?>', '<?php echo $row["Stock"]; ?>', '<?php echo $row["Stock"]; ?>')"
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
    function animateCSS(element, animationName, callback) {
        const node = document.querySelector(element);
        node.classList.add('animated', animationName);

        function handleAnimationEnd() {
            node.removeEventListener('animationend', handleAnimationEnd);

            if (typeof callback === 'function') callback()
        }

        node.addEventListener('animationend', handleAnimationEnd);
    }

    $('#cancelBtn').click(function () {
        const node = document.querySelector(".edit-product-form");
        node.classList.remove('animated', 'slideInUp');

        const formNode = document.querySelector(".product-table");
        formNode.classList.remove('animated', 'slideOutRight');

        animateCSS('.edit-product-form', 'slideOutUp', function(){
            $('.edit-product-form').css("display", "none");
            document.querySelector('.edit-product-form').classList.remove('slideOutUp');
        });
    });

    function editProduct(name, price, stock, category) {
        animateCSS('.product-table', 'slideOutRight', function () {
            $('.edit-product-form').css("display", "block");
            animateCSS('.edit-product-form', 'slideInUp');
        });

        $('#product-name').val(name);
        $('#product-stock').val(price);
        $('#product-price').val(stock);
    }
</script>
</body>
</html>

