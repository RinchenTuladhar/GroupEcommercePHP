<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

include '../api/db-access.php';

?>

<html lang="en">
<head>
    <?php include '../api/scripts.php'; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>BuildMyStore: Admin</title>
</head>


<body>
<?php include 'navbar-admin.php'; ?>

<div class="main admin-main">
    <h1>Catalogue Creator</h1>
    <p>Select which categories you would like to appear on your custom catalogue!</p>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group" id="sortable">

                <form method="post" action="my-custom-catalogue.php">
                    <?php
                    // List of categories
                    $categoryList = $db->getCategories($_SESSION["WebsiteID"]);
                    if ($categoryList->num_rows > 0) {
                        $counter = 0;
                        while ($row = $categoryList->fetch_assoc()) {
                            ?>
                            <!-- CATEGORY DETAILS-->
                            <li class="list-group-item navigation-list ui-state-default">
                                <!-- SELECT CATEGORY -->
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="<?php echo $row['Title']?>" value="<?php echo $row['Title']?>" class="custom-control-input" id="categoryCheck-<?php echo $counter;?>">
                                    <label class="custom-control-label" for="categoryCheck-<?php echo $counter;?>"><?php echo $row["Title"];?></label>
                                </div>
                            </li>
                            <?php

                            $counter++;
                        }
                    }
                    ?>
                    <br>
                    <span class="float-right">
                        <input type="submit" class="btn btn-success" value="Create Catalogue">
                    </span>
                </form>
            </ul>


        </div>
        <div class="col-md-6">
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#catalogue').submit(function(e){
        e.preventDefault();
        var values = $(this).serialize();

        if(values != ""){
            var request = $.ajax({
                url: 'my-custom-catalogue.php',
                type: "POST",
                data: {categories: values},
                success: function (data) {
                    location.href="my-custom-catalogue.php";
                }
            });
        }
    });
</script>
</body>
</html>

