<?php
ob_start();
session_start();
require_once '../engine_room/defines.php';
if (isset($_SESSION['user'])) {
    //header("Location: ../index.php");// if session is set direct to index
    //exit;
}
if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $upass = $_POST['pass'];
    $select = $db->prepare("SELECT `id`, `username`, `pass_word`, `created`, `verified`, `type` FROM `users` WHERE `email` = :email");
    $select->execute(array(':email' => $email));
    $result = $select->fetch();
    $row_count = $select->rowCount();
    if ($row_count == 1 && password_verify($upass, $result['pass_word'])) {
        $_SESSION['user'] = $result['id'];
        if ($result['verified'] == 1) {
            if ($result['type'] == 4) {
                $errMSG = "Your account is suspended";
            } else {
                $update = $db->prepare("UPDATE `login_count` SET `count` = `count` + 1 WHERE `uid` = :id");
                $update->execute(array(':id' => $result['id']));
                $insert = $db->prepare('INSERT IGNORE INTO `login_attempts` (`uid`, `result`, `ip`) VALUES (?, ?, ?)');
                $insert->execute([$result['id'], "1", $_SERVER['REMOTE_ADDR']]);
                header("Location: ../index.php");
            }
        } else {
            $errMSG = "You are not verified yet";
        }
    } elseif ($row_count == 1) {
        $errMSG = "Bad password";
        $insert = $db->prepare('INSERT IGNORE INTO `login_attempts` (`uid`, `result`, `ip`) VALUES (?, ?, ?)');
        $insert->execute([$result['id'], "0", $_SERVER['REMOTE_ADDR']]);
    } else $errMSG = "User not found";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Login - <?php echo $website_name; ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="../assets/css/style.css" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-lg-12">
            <h1 class="text-center">Login</h1>
            <form method="post" autocomplete="off">
                <?php
                if (isset($errMSG)) {
                    ?>
                    <div class="form-group">
                        <div class="alert alert-danger">
                            <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email"
                           placeholder="email"
                           required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="pass" placeholder="Password"
                           required>
                </div>
                <div class="form-group btn-row">
                    <button type="submit" class="btn btn-block btn-primary" name="btn-login">Login</button>
                </div>
                <div class="form-group btn-row">
                    <a href="../register/index.php" class="btn btn-block btn-warning">Register</a>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>