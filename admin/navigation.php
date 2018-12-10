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
    <h2>Navigation List:</h2>
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
                                <?php if ($row["Navigation"] == 1) { ?>
                                    <i id="navClick" value="<?php echo row["Title"]?>" class="fa fa-check-square"></i>
                                    <?php
                                } else {
                                    ?>
                                    <i class="fa fa-square"></i>
                                    <?php
                                } ?>
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
<script type="text/javascript">
    /*
    $(document).ready(function() {
        $('#navClick').click(function(){
            $.ajax({
                type: "POST",
                url: "../api/update-navigation.php",
                data: { name: "John" }
            }).done(function( msg ) {
                alert( "Data Saved: " + msg );
            });
        });
    }*/
</script>
</html>

