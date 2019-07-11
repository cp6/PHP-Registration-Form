<?php

function main_admin_card($username)
{
    global $db;
    echo "<div class='card'>
            <div class='row'>
                <div class='col-lg-12'>
                    <h1 class='text-center'>Welcome $username</h1>
</div>
</div>
<br>
<div class='row'>
    <div class='col-lg-3'>
        <h5 class='text-center'>Total Users: " . total_users_count() . "</h5>
    </div>
    <div class='col-lg-3'>
        <h5 class='text-center'>Verified: " . total_verified_users() . "</h5>
    </div>
    <div class='col-lg-3'>
        <h5 class='text-center'>Unverified: " . total_unverified_users() . "</h5>
    </div>
    <div class='col-lg-3'>
        <h5 class='text-center'>Suspended: " . total_suspended_users() . "</h5>
    </div>
</div>
</div>";
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

function total_suspended_users()
{
    global $db;
    $select = $db->prepare("SELECT COUNT(*) as the_count FROM `users` WHERE `type` = 4;");
    $row = $select->fetch($select->execute());
    return $row['the_count'];
}

function unverified_users_table()
{
    global $db;
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
              <td><a class='btn btn-success btn-sm' href='actions/approve.php?id=$id' role='button'>Verify</a><a class='btn btn-danger btn-sm' href='actions/delete.php?id=$id' role='button'>Delete</a><a class='btn btn-warning btn-sm' href='actions/suspend.php?id=$id' role='button'>Suspend</a></td>
              </tr>";
    }
    echo "</tbody></table>";
    echo "</div></div></div></div>";
}

function verified_users_table()
{
    global $db;
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
            <th></th>
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
              <td><a class='btn btn-warning btn-sm' href='actions/suspend.php?id=$id' role='button'>Suspend</a></td>
              </tr>";
    }
    echo "</tbody></table>";
    echo "</div></div></div></div>";
}

function suspended_users_table()
{
    global $db;
    echo "<div class='card table-card'>";
    echo "<div class='row'><div class='col-lg-12'>";
    echo "<h2 class='text-center'>Suspended users</h2>";
    echo "<div class='table-responsive'>";
    echo "<table class='table table-striped table-sm'>
    <thead class='thead-light'>
        <tr>
            <th>UID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Joined</th>
            <th></th>
        </tr>
    </thead>
    <tbody>";
    $select = $db->prepare("SELECT `id`, `username`, `email`, `created`, `type` FROM `users` WHERE `type` = 4 ORDER BY `id` ASC;");
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
              <td><a class='btn btn-info btn-sm' href='actions/unsuspend.php?id=$id' role='button'>Unsuspend</a></td>
              </tr>";
    }
    echo "</tbody></table>";
    echo "</div></div></div></div>";
}