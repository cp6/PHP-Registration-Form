<?php
ob_start();
session_start();
require_once 'engine_room/defines.php';
require_once 'engine_room/functions.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Home - <?php echo $website_name; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
</head>
<body>
<div class="container-fluid">
    <?php
    if (!isset($_SESSION['user'])) {//Not logged in
        ?>
        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-center">
            <a class="navbar-brand" href="#"><?php echo $website_name; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="login/index.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register/index.php">Register</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="card">
            <h1 class="text-center"><?php echo $website_name ?></h1>
            <p class="text-center">Login or register using the buttons below.</p>
            <br>
            <div class="row text-center">
                <div class='col-lg-3 col-md-3 col-sm-3'>
                </div>
                <div class='col-lg-6 col-md-6 col-sm-6'>
                    <div class="row text-center">
                        <div class='col-lg-6 col-md-6 col-sm-12'>
                            <a href="login/index.php" class="btn btn-primary">Login</a>
                        </div>
                        <div class='col-lg-6 col-md-6 col-sm-12'>
                            <a href="register/index.php" class="btn btn-info">Register</a>
                        </div>
                    </div>
                </div>
                <div class='col-lg-3 col-md-3 col-sm-3'>
                </div>
            </div>
        </div>
        <?php
    } else {//Is logged in
        $select = $db->prepare("SELECT `username`, `type`, `email` FROM users WHERE id = :id");
        $userRow = $select->fetch($select->execute(array(':id' => $_SESSION['user'])));
        ?>
        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-center">
            <a class="navbar-brand" href="#"><?php echo $website_name; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="logout/index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="card">
            <h1 class="text-center"><?php echo $website_name ?></h1>
            <h3 class="text-center">Welcome <?php echo $userRow['username']; ?></h3>
            <br>
            <div class="row text-center">
                <div class='col-lg-3 col-md-3 col-sm-3'>
                </div>
                <div class='col-lg-6 col-md-6 col-sm-6'>
                    <div class="row text-center">
                        <div class='col-lg-4 col-md-4 col-sm-4'>
                            <a href="login/index.php" class="btn btn-info">Logout</a>
                        </div>
                        <div class='col-lg-4 col-md-4 col-sm-4'>
                            <a href="user/index.php" class="btn btn-primary">Profile page</a>
                        </div>
                        <?php
                        if ($userRow['type'] == 1) {//admin account
                            echo "<div class='col-lg-4 col-md-4 col-sm-4'>
                    <a href='panel/index.php' class='btn btn-warning'>Admin Panel</a>
                </div>
            </div>";
                        }
                        ?>
                    </div>
                </div>
                <div class='col-lg-3 col-md-3 col-sm-3'>
                </div>
            </div>
        </div>
    <?php } ?>
    <div class="row text-center">
        <div class='col-lg-12 col-md-12 col-sm-12'>
            <p class="footer-text"><?php echo $footer_text; ?></p>
        </div>
    </div>
</div>
<script src="assets/js/jquery.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
</body>
</html>