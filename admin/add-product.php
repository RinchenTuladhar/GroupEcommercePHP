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
    <div class="col-md-8 col-sm-12">
        <h2>Add New Product</h2>

        <form method="post" action="../api/add-product.php" enctype="multipart/form-data">
            <label for="product_name">Product Name</label>
            <input type="text" id="product_name" name="product_name" class="form-control" required>
            <br>
            <label for="product_description">Description</label>
            <textarea type="text" id="product_description" name="product_description" class="form-control"
                      required></textarea>
            <br>
            <label for="product_original_price">Original Cost of Product</label>
            <input type="number" id="product_original_price" name="product_original_price" min="0.01" step="0.01"
                   class="form-control" required>
            <br>
            <label for="product_price">Price to Sell Product</label>
            <input type="number" id="product_price" name="product_price" min="0.01" step="0.01"
                   class="form-control" required>
            <br>
            <label for="product_stock">Stock</label>
            <input type="number" id="product_stock" name="product_stock" class="form-control" required>
            <br>
            <label for="category">Category</label>
            <select name="category" class="form-control" id="category"  required>
                <?php
                $categoryList = $db->getCategories($_SESSION["WebsiteID"]);
                if ($categoryList->num_rows > 0) {
                    while ($row = $categoryList->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['Title']; ?>">
                            <?php echo $row["Title"]; ?>
                        </option>
                        <?php
                    }
                }
                ?>
            </select><br>
            <select name="sub_category" class="form-control" id="sub-category-list" required>

            </select>
            <br>
            <label for="image">Product Image</label> <br>
            <input type="file" name="image"/>
            <br>
            <input type="hidden" name="website_name" value="<?php echo $_SESSION["hasDomain"]["DomainName"]; ?>">
            <span class="float-right">
                <button type="submit" class="btn btn-success">Create</button>
            </span>
        </form>
    </div>
</div>
<script type="text/javascript">
$( document ).ready(function() {
	 $.ajax({
        type: "GET",
        url: "../api/get-sub-categories.php",
        data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val()}
    }).done(function( value ) {
        $('#sub-category-list').html(value);
    });
});

$("#category").on('change', function() {
   $.ajax({
       type: "GET",
       url: "../api/get-sub-categories.php",
       data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val()}
   }).done(function( value ) {
       $('#sub-category-list').html(value);
   });
});
</script>
</body>
</html>

