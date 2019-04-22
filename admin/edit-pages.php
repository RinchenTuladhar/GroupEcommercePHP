<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include '../api/db-access.php';

if ($_SESSION['loggedin'] == null) {
    header("Location:../../login.php");
}

// Gets all categories belonging to the website
$categoryList = $db->getCategories($_SESSION["WebsiteID"]);

?>
<html lang="en">
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
		<hr />
		<div class="col-md-12">
			<form method="post" action="../api/update-page.php"
				enctype="multipart/form-data">
				<textarea name="text_editor" id="text_editor" rows="10" cols="80">
                <?php
                // Gets content of home page
                $content = $db->getContent($_SESSION["WebsiteID"], "index", "null");
                echo (htmlspecialchars_decode($content->fetch_assoc()["Content"]));
                ?>
            </textarea>
				<script>
                CKEDITOR.replace( 'text_editor' );
            </script>
				<input type="hidden" name="category" value="index"> <input
					type="hidden" name="sub_category" value="null"> <br>
				<button type="submit" class="btn btn-success">Update</button>
			</form>

			<h2>Edit Sub Category Page</h2>

			<form method="post" action="../api/update-page.php">
				<label for="category">Select Category:</label> <select
					name="category" class="form-control" id="category" required>
                <?php
                // Gets content of each sub category
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
            </select> <br> <select name="sub_category"
					class="form-control" id="sub-category-list" required>
				</select> <br>
				<textarea name="category_text_editor" id="category_text_editor"
					rows="10" cols="80">
            </textarea>
				<script>
                CKEDITOR.replace( 'category_text_editor' );
            </script>
			<br>
				<button type="submit" class="btn btn-success">Update</button>
			</form>
		</div>

	</div>
</body>

<script type="text/javascript">
    $( document ).ready(function() {
        // Loads home page category
    	 $.ajax({
             type: "GET",
             url: "../api/get-sub-categories.php",
             data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val()}
         }).done(function( value ) {
             $('#sub-category-list').html(value);

           	// Load text for categories straight after retrieving them
        	 $.ajax({
                 type: "GET",
                 url: "../api/get-page-content.php",
                 data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val(), subCategory: $('#sub-category-list').val()}
             }).done(function( value ) {
            	 CKEDITOR.instances["category_text_editor"].setData(value);
             });
         });


    });

    $("#category").on('change', function() {
        $.ajax({
            type: "GET",
            url: "../api/get-sub-categories.php",
            data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val()}
        }).done(function( value ) {
            $('#sub-category-list').html(value);

           	// Load text for categories straight after retrieving them
       	 $.ajax({
                type: "GET",
                url: "../api/get-page-content.php",
                data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val(), subCategory: $('#sub-category-list').val()}
            }).done(function( value ) {
            	console.log(value);
           	 	CKEDITOR.instances["category_text_editor"].setData(value);
            });
        });
    });

    $('#sub-category-list').on('change', function(){
       	 $.ajax({
             type: "GET",
             url: "../api/get-page-content.php",
             data: { websiteID: '<?php echo $_SESSION["WebsiteID"]?>', category: $('#category').val(), subCategory: $('#sub-category-list').val()}
         }).done(function( value ) {
         	console.log(value);
        	 	CKEDITOR.instances["category_text_editor"].setData(value);
         });
    });
</script>
</html>