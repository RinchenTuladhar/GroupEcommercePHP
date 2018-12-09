<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../api/db-access.php';

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}
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
    <div class="row">
        <h2>Add new categories</h2>
        <div class="col-md-12">
            <form action="../api/create-category.php" method="POST">
                <p>Seperate each category by commas.</p>
                <div class="col-md-6">
                    <input type="text" class="form-control" name="category" placeholder="E.g Shirt, Trousers, Hoodies">
                    <br>
                    <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">
                    <input type="submit" class="btn btn-success float-right" value="Submit">
                </div>
            </form>
        </div>
    </div>

    <h2>List of Categories</h2>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group">
                <?php
                $categoryList = $db->getCategories($_SESSION["WebsiteID"]);
                if ($categoryList->num_rows > 0) {
                    while ($row = $categoryList->fetch_assoc()) {
                        ?>
                        <li class="list-group-item">
                            <?php echo $row["Title"]; ?>
                            <span class="float-right">
                            <i class="fa fa-times"></i>
                                </span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</div>
</body>
</html>

