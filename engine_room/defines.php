<?php
/*
 * Edit and configure the following:
 */
$database_host = 'localhost';//Database connection address
$database_name = '';//Database table name
$database_username = '';//Database username
$database_password = '';//Password for your database user

$website_name = '';//General title of your website
$footer_text = '';//What gets displayed as the footer (can use <a href=""></a>)
/*
Do NOT touch below 2 lines!
 */
$db = new PDO("mysql:host=$database_host;dbname=$database_name;charset=utf8mb4", "$database_username", "$database_password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);