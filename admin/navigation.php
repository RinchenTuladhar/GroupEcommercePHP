<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../api/db-access.php';

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}
?>

<html lang="en">
<head>
    <?php include '../api/scripts.php'; ?>
    <link rel="stylesheet" href="../css/style.css">
    <title>BuildMyStore: Admin</title>

    <!-- Script for drag+drop -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            $("#sortable").sortable();
            $("#sortable").disableSelection();
        });
    </script>

</head>

<body>
<?php include 'navbar-admin.php'; ?>
<div class="main admin-main">
    <h2>Navigation List:</h2>
    <div class="row">
        <div class="col-md-6">
            <ul class="list-group" id="sortable">
                <?php

                // List of categories
                $categoryList = $db->getCategories($_SESSION["WebsiteID"]);
                if ($categoryList->num_rows > 0) {
                    while ($row = $categoryList->fetch_assoc()) {
                        ?>
                        <!-- CATEGORY DETAILS-->
                        <li class="list-group-item navigation-list ui-state-default">
                            <?php echo $row["Title"]; ?>
                            <span class="float-right">
                                <?php if ($row["Navigation"] == 1) { ?>
                                    <button type="button"
                                            onclick="navClick('<?php echo $row["Title"] ?>', 1, '<?php echo $_SESSION["WebsiteID"]; ?>', this);"
                                            id="">
								<i class="fa fa-check-square"></i>
							</button>

                                    <?php
                                } else {
                                    ?>
                                    <!-- SELECT CATEGORY -->
                                    <button type="button" id=""
                                            onclick="navClick('<?php echo $row["Title"] ?>', 0, '<?php echo $_SESSION["WebsiteID"]; ?>', this);">
								<i class="fa fa-square"></i>
							</button>
                                    <?php
                                }
                                ?>
                            </span>
                        </li>
                        <?php
                    }
                }
                ?>
            </ul>
        </div>
        <div class="col-md-6">


        </div>
    </div>

</div>
</body>
<script type="text/javascript">
    function navClick(value, isChecked, websiteID, input) {

        // Request executed when navigation square clicked.
        var request = $.ajax({
            url: '../api/update-navigation.php',
            type: "POST",
            data: {websiteID: websiteID, title: value, mode: isChecked},
            success: function () {
                // Updates check / uncheck box
                if (isChecked == 1) {
                    input.outerHTML = '<button type="button"' +
                        '\t\t\t\t\t\t\t\tonclick="navClick(\'' + value + '\', 0, \'<?php echo $_SESSION["WebsiteID"];?>\', this);">\n' +
                        '\t\t\t\t\t\t\t\t<i class="fa fa-square"></i>\n' +
                        '\t\t\t\t\t\t\t</button>';
                } else {
                    input.outerHTML = '<button type="button"\n' +
                        '\t\t\t\t\t\t\t\tonclick="navClick(\'' + value + '\', 1, \'<?php echo $_SESSION["WebsiteID"];?>\', this);"\n' +
                        '\t\t\t\t\t\t\t\t>\n' +
                        '\t\t\t\t\t\t\t\t<i class="fa fa-check-square"></i>\n' +
                        '\t\t\t\t\t\t\t</button>';
                }
            }
        });
    }
</script>
<script>
    // Auto updates navigation on mouse up
    $(".navigation-list").mouseup(function () {
        var draggedCat = $.trim($(this).text());
        var navigationList = [];

        $( ".navigation-list" ).each(function( index ) {
            if(draggedCat != $.trim($(this).text())){
                if($(this).is(':empty')){
                    navigationList.push(draggedCat);
                } else {
                    navigationList.push($.trim($(this).text()));
                }
            }
        });

        // Sends request to update navigation order
        var request = $.ajax({
            url: '../api/update-navigation.php',
            type: "POST",
            data: {websiteID: '<?php echo $_SESSION["WebsiteID"];?>', navigationList: navigationList},
            success: function (data) {
                $.notify("Successfully Updated!", "success");
            }
        });

        return request;
    });
</script>
</html>

