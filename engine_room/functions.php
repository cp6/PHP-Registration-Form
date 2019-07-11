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
    } else {
        return "Unknown: $type";
    }
}

function total_users_count()
{
    global $db;
    $select = $db->prepare("SELECT COUNT(*) as the_count FROM `users`;");
    $row = $select->fetch($select->execute());
    return $row['the_count'];
}

function total_verified_users()
{
    global $db;
    $select = $db->prepare("SELECT COUNT(*) as the_count FROM `users` WHERE `verified` = 1;");
    $row = $select->fetch($select->execute());
    return $row['the_count'];
}

function total_unverified_users()
{
    global $db;
    $select = $db->prepare("SELECT COUNT(*) as the_count FROM `users` WHERE `verified` = 0;");
    $row = $select->fetch($select->execute());
    return $row['the_count'];
}