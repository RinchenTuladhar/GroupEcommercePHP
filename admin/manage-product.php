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
        <table class="table">
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
                    <td><i class="fa fa-edit"></i></td>
                </tr>
                <?php
            }
            ?>

            </tbody>
        </table>
    </div>
</div>
</body>
</html>

