<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>

<html>
<head>
    <?php include 'api/scripts.php'; ?>
    <title>BuildMyStore: Features</title>
</head>

<body>
<?php include 'navbar.php'; ?>
<div class="main">
    <div class="container">
        <div class="signup-form">

            <h1>Sign up now to transform your business.</h1>
            <form action="/action_page.php">
                <div class="form-group">
                    <label for="first_name">First Name:</label>
                    <input type="email" class="form-control" id="first_name">
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name:</label>
                    <input type="password" class="form-control" id="last_name">
                </div>
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" class="form-control" id="email">
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <button type="submit" class="btn btn-default">Submit</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>