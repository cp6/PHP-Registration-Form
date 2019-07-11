<?php
ob_start();
session_start();
require_once '../engine_room/defines.php';
require_once '../engine_room/functions.php';
if (!isset($_SESSION['user'])) {
    header("Location: ../login/index.php");
    exit;
}
$select = $db->prepare("SELECT `username`, `type`, `email` FROM users WHERE id = :id");
$userRow = $select->fetch($select->execute(array(':id' => $_SESSION['user'])));
if ($userRow['type'] == 1) {//Show admin panel.....
    ?>
    <!DOCTYPE html>
    <html>
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
        <div class="card">
            <div class='row'>
                <div class='col-lg-12'>
                    <h1 class="text-center">Welcome <?php echo $userRow['username']; ?></h1>
                </div>
            </div>
            <div class='row'>
                <div class='col-lg-4'>
                    <h5 class="text-center">Total Users: <?php echo total_users_count(); ?></h5>
                </div>
                <div class='col-lg-4'>
                    <h5 class="text-center">Verified: <?php echo total_verified_users(); ?></h5>
                </div>
                <div class='col-lg-4'>
                    <h5 class="text-center">Unverified: <?php echo total_unverified_users(); ?></h5>
                </div>
            </div>
        </div>
        <?php
        echo "<div class='card table-card'>";
        echo "<div class='row'><div class='col-lg-12'>";
        echo "<h2 class='text-center'>Unverified users</h2>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-sm'>
    <thead class='thead-light'>
        <tr>
            <th>UID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Joined</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>";
        $select = $db->prepare("SELECT `id`, `username`, `email`, `created`, `type` FROM `users` WHERE `verified` = 0 ORDER BY `id` ASC;");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $username = $row['username'];
            $email = $row['email'];
            $joined = $row['created'];
            $date_f = new DateTime($joined);
            $formatted_date = $date_f->format('jS M Y');
            echo "<tr>
              <td>$id</td>
              <td><a href='$username'>$username</a></td>
              <td>$email</td>
              <td>$formatted_date</td>
              <td><a class='btn btn-success btn-sm' href='actions/approve.php?id=$id' role='button'>Verify</a></td>
              <td><a class='btn btn-danger btn-sm' href='actions/delete.php?id=$id' role='button'>Delete</a></td>
              </tr>";
        }
        echo "</tbody></table>";
        echo "</div></div></div></div>";
        //Verified users table
        echo "<div class='card table-card'>";
        echo "<div class='row'><div class='col-lg-12'>";
        echo "<h2 class='text-center'>Verified users</h2>";
        echo "<div class='table-responsive'>";
        echo "<table class='table table-striped table-sm'>
    <thead class='thead-light'>
        <tr>
            <th>UID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Joined</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>";
        $select = $db->prepare("SELECT `id`, `username`, `email`, `created`, `type` FROM `users` WHERE `verified` = 1 ORDER BY `id` ASC;");
        $select->execute();
        while ($row = $select->fetch(PDO::FETCH_ASSOC)) {
            $id = $row['id'];
            $username = $row['username'];
            $email = $row['email'];
            $joined = $row['created'];
            $type = $row['type'];
            $date_f = new DateTime($joined);
            $formatted_date = $date_f->format('jS M Y');
            echo "<tr>
              <td>$id</td>
              <td><a href='$username'>$username</a></td>
              <td>$email</td>
              <td>$formatted_date</td>
              <td>" . user_type_to_string($type) . "</td>
              </tr>";
        }
        echo "</tbody></table>";
        echo "</div></div></div></div>";
        ?>
        <div class="row text-center">
            <div class='col-lg-12 col-md-12 col-sm-12'>
                <p class="footer-text"><?php echo $footer_text;?></p>
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