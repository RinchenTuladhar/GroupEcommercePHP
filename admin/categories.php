<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../api/db-access.php';

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}


$categoryList = $db->getCategories($_SESSION["WebsiteID"]);

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
    <div class="row col-md-12">
        <div class="col-md-6">
            <h2>Add new categories</h2>
            <form action="../api/create-category.php" method="POST">
                <p>Seperate each category by commas.</p>
                <input type="text" class="form-control" name="category" placeholder="E.g Shirt, Trousers, Hoodies">
                <br>
                <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">
                <input type="submit" class="btn btn-success float-right" value="Submit">
            </form>
        </div>
        <div class="col-md-6">
            <h2>Add Sub Categories</h2>
            <form action="../api/create-sub-category.php" method="POST">
                <p>Seperate each category by commas.</p>
                <select class="form-control" name="category">
                    <?php
                    if ($categoryList->num_rows > 0) {
                        while ($row = $categoryList->fetch_assoc()) {
                            ?>
                            <option><?php echo $row["Title"]; ?></option>
                            <?php
                        }
                    }


                    mysqli_data_seek($categoryList, 0);
                    ?>
                </select>
                <br>
                <input type="text" class="form-control" name="sub-category"
                       placeholder="E.g for Accessories - Bags, Ties, Wallets">
                <br>
                <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">
                <input type="submit" class="btn btn-success float-right" value="Submit">
            </form>
        </div>
    </div>

    <div class="col-md-12">
        <h2>List of Categories</h2>
        <ul class="list-group">
            <?php
            if ($categoryList->num_rows > 0) {
                while ($row = $categoryList->fetch_assoc()) {
                    $subCategories = $db->getSubCategories($row["Title"], $row["WebsiteID"]);
                    ?>
                    <li class="list-group-item">
                        <?php echo $row["Title"]; ?>
                        <span class="float-right">
                            <i class="fa fa-times"
                                           onclick="deleteCategory('<?php echo $row["Title"]; ?>', null);"></i>
                        </span>
                    </li>
                    <?php

                    if ($subCategories->num_rows > 0) {
                        ?>
                        <ul>
                            <?php
                            while ($subRow = $subCategories->fetch_assoc()) {
                                ?>
                                <li class="list-group-item">

                                    <?php echo $subRow["SubCategory"]; ?>
                                    <span class="float-right">
                                        <i class="fa fa-times"
                                           onclick="deleteCategory('<?php echo $subRow["Category"]; ?>', '<?php echo $subRow["SubCategory"]; ?>');"></i>
                                    </span>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                        <?php
                    }
                }

            }
            ?>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function deleteCategory(cat, subcat) {
        var request = $.ajax({
            url: '../api/delete-category.php',
            type: "POST",
            data: {cat: cat, subcat: subcat},
            success: function (data) {
                console.log(data);
            }
        });
        return request;
    }
</script>
</body>
</html>

