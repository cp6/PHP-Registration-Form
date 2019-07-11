<?php

function user_type($user)
{
    global $db;
    $select = $db->prepare("SELECT `type` FROM `users` WHERE `id` = :id");
    $userRow = $select->fetch($select->execute(array(':id' => $user)));
    return $userRow['type'];
}

function user_type_to_string($type)
{
    if ($type == 0) {
        return "User";
    } elseif ($type == 1) {
        return "Admin";
    } elseif ($type == 2) {
        return "Dev";
    } elseif ($type == 3) {
        return "Mod";
    } elseif ($type == 4) {
        return "Suspended";
    } else {
        return "Unknown:$type";
    }
}