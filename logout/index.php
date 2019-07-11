<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../login/index.php");
} else if (isset($_SESSION['user']) != "") {
    //header("Location: home.php");
    //TODO: SET DEFAULT HOMEPAGE HERE
    header("Location: ../login/index.php");
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: ../login/index.php");
    exit;
}