<?php
ob_start();
session_start();
require_once '../engine_room/dbconnect.php';
if (!isset($_SESSION['user'])) {
    header("Location: ../login/index.php");
    exit;
}
$select = $db->prepare("SELECT `username`, `type`, `email` FROM users WHERE id = :id");
$userRow = $select->fetch($select->execute(array(':id' => $_SESSION['user'])));
if ($userRow['type'] == 1) {
    echo "".$userRow['username']." You're an admin, that's why you can see this page.";
} else {
    header("Location: ../index.php");
    exit;
}