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
    <script src="../plugins/ckeditor/ckeditor.js"></script>
    <title>BuildMyStore: Admin</title>
</head>


<body>
<?php include 'navbar-admin.php'; ?>
<div class="main admin-main">
    <h2>Edit Home Page</h2>
    <hr/>
    <div class="row col-md-12">
        <form method="post" action="../api/update-page.php" enctype="multipart/form-data">
            <textarea name="text_editor" id="text_editor" rows="10" cols="80">
                <?php
                $content = $db->getContent($_SESSION["WebsiteDetails"]["WebsiteID"], "index");
                echo(htmlspecialchars_decode($content->fetch_assoc()["Content"]));?>
            </textarea>
            <script>
                CKEDITOR.replace( 'text_editor' );
            </script>
            <input type="hidden" name="website_id" value="<?php echo $_SESSION["WebsiteID"]; ?>">
            <input type="hidden" name="page" value="index">
            <br>
            <button type="submit" class="btn btn-success">Update</button>
        </form>
    </div>
</div>
</body>
</html>