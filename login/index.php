<?php
ob_start();
session_start();
require_once '../engine_room/dbconnect.php';
// if session is set direct to index
if (isset($_SESSION['user'])) {
    header("Location: ../index.php");
    exit;
}
if (isset($_POST['btn-login'])) {
    $email = $_POST['email'];
    $upass = $_POST['pass'];
    $password = hash('sha256', $upass); // password hashing using SHA256
    $select = $db->prepare("SELECT id, username, pass_word FROM users WHERE email = :email");
    $select->execute(array(':email' => $email));
    $result = $select->fetch();
    $row_count = $select->rowCount();

    if ($row_count > 0) {
        echo "Row has been found";
    } else {
        echo "No row in DB";
    }
    if ($row_count == 1 && $result['pass_word'] == $password) {
        $_SESSION['user'] = $result['id'];
        header("Location: ../index.php");
    } elseif ($row_count == 1) {
        $errMSG = "Bad password";
    } else $errMSG = "User not found";
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Login</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href=".../assets/css/style.css" type="text/css"/>
</head>
<body>

<div class="container">


    <div id="login-form">
        <form method="post" autocomplete="off">

            <div class="col-md-12">

                <div class="form-group">
                    <h2 class="">Login:</h2>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <?php
                if (isset($errMSG)) {

                    ?>
                    <div class="form-group">
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-info-sign"></span> <?php echo $errMSG; ?>
                        </div>
                    </div>
                    <?php
                }
                ?>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                        <input type="text" name="email" class="form-control" placeholder="Email"/>
                    </div>
                </div>

                <div class="form-group">
                    <div class="input-group">
                        <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                        <input type="password" name="pass" class="form-control" placeholder="Password" required/>
                    </div>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-block btn-primary" name="btn-login">Login</button>
                </div>

                <div class="form-group">
                    <hr/>
                </div>

                <div class="form-group">
                    <a href="../register/index.php" type="button" class="btn btn-block btn-danger"
                       name="btn-login">Register</a>
                </div>

            </div>

        </form>
    </div>

</div>
<script src="../assets/js/jquery.js"></script>
<script type="text/javascript" src="../assets/js/bootstrap.min.js"></script>
</body>
</html>