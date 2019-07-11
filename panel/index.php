<?php
ob_start();
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/index.php");
    exit;
}
require_once '../engine_room/defines.php';
$select = $db->prepare("SELECT `username`, `type`, `email` FROM users WHERE id = :id");
$userRow = $select->fetch($select->execute(array(':id' => $_SESSION['user'])));
if ($userRow['type'] == 1) {//Show admin panel.....
    require_once '../engine_room/functions.php';
    require_once '../engine_room/admin_functions.php';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>Panel - <?php echo $website_name; ?></title>
        <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"/>
        <link rel="stylesheet" href="../assets/css/style.css" type="text/css"/>
    </head>
    <body>
    <div class='container-fluid'>
        <nav class="navbar navbar-expand-sm bg-light navbar-light justify-content-center">
            <a class="navbar-brand" href="#"><?php echo $website_name; ?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../logout/index.php">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <?php
        main_admin_card($userRow['username']);
        unverified_users_table();
        verified_users_table();
        suspended_users_table();
        ?>
        <div class="row text-center">
            <div class='col-lg-12 col-md-12 col-sm-12'>
                <p class="footer-text"><?php echo $footer_text; ?></p>
            </div>
        </div>
    </div>
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
} else {
    header("Location: ../index.php");
    exit;
}