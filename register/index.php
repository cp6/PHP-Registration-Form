<?php
ob_start();
session_start();
if (isset($_SESSION['user']) != "") {
    header("Location: ../index.php");
}
include_once '../engine_room/defines.php';
if (isset($_POST['signup'])) {
    $uname = trim($_POST['uname']); // get posted data and remove whitespace
    $email = trim($_POST['email']);
    $upass = trim($_POST['pass']);
    //$password = hash('sha256', $upass);// hash password with SHA256;
    $password = password_hash($upass, PASSWORD_DEFAULT);
    $select = $db->prepare("SELECT `email` FROM `users` WHERE `email` = :email");
    $select->execute(array(':email' => $email));
    $result = $select->fetch();
    $count = $select->rowCount();
    if ($count == 0) { // if email is not found add user
        $insert = $db->prepare('INSERT INTO `users` (`username`, `email`, `pass_word`) VALUES (?, ?, ?)');
        $insert->execute(["$uname", "$email", "$password"]);
        $user_id = $db->lastInsertId();
        if ($user_id > 0) {
            $_SESSION['user'] = $user_id; // set session and redirect to index page
            if (isset($_SESSION['user'])) {
                print_r($_SESSION);
                header("Location: ../index.php");
                exit;
            }
        } else {
            $errTyp = "danger";
            $errMSG = "Something went wrong, try again";
        }
    } else {
        $errTyp = "warning";
        $errMSG = "Email is already used";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Registration - <?php echo $website_name;?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="../assets/css/style.css" type="text/css"/>
</head>
<body>
<div class="container">
    <div class="row text-center">
        <div class="col-lg-12">
            <h1 class="text-center">Register</h1>
            <form method="post" autocomplete="off">
                <?php
                if (isset($errMSG)) {

                    ?>
                    <div class="form-group">
                        <div class="alert alert-<?php echo ($errTyp == "success") ? "success" : $errTyp; ?>">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>
                <div class="form-group">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" name="uname" aria-describedby="username"
                           placeholder="Username"
                           required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" aria-describedby="email"
                           placeholder="email"
                           required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="pass" name="pass" placeholder="Password"
                           required>
                </div>
                <div class="checkbox">
                    <label><input type="checkbox" id="TOS" value="This"><a href="#terms_link">I agree with
                            terms of service</a></label>
                </div>
                <div class="form-group btn-row">
                    <button type="submit" class="btn btn-block btn-primary" name="signup" id="reg">Register</button>
                </div>
                <div class="form-group btn-row">
                    <a href="../login/index.php" type="button" class="btn btn-block btn-success" name="btn-login">Go to login</a>
                </div>

            </div>

        </form>
    </div>
</div>
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
<script type="text/javascript" src="../assets/js/tos.js"></script>
</body>
</html>