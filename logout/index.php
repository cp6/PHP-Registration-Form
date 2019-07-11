<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../index.php");
} else if (isset($_SESSION['user']) != "") {
    //TODO: SET DEFAULT HOMEPAGE HERE
    //header("Location: ../index.php");
    session_destroy();
    unset($_SESSION['user']);
    header("Location: ../index.php");
    exit;
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['user']);
    header("Location: ../index.php");
    exit;
}