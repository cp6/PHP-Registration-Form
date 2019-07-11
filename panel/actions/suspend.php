<?php
ob_start();
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: ../../login/index.php");
    exit;
}
require_once '../../engine_room/defines.php';
require_once '../../engine_room/functions.php';
$user_type = user_type($_SESSION['user']);
if ($user_type == 1) {
    $id = $_GET['id'];
    $update = $db->prepare("UPDATE `users` SET `type` = 4 WHERE `id` = :id");
    $update->execute(array(':id' => $id));
    header("Location: ../index.php");
    exit;
} else {
    header("Location: ../../login/index.php");
    exit;
}