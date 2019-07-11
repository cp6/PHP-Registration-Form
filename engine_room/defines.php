<?php
/*
 * Edit and configure the following:
 */
$database_host = 'localhost';//Database connection address
$database_name = '';//Database name
$database_username = '';//Database username
$database_password = '';//Password for your database user

$verify_new_users_method = '1';//0=verified upon registration, 1=Admin must verify, 2=email verification (NOT IN USE).

$website_name = '';//General title of your website
$footer_text = '';//What gets displayed as the footer (can use <a href=""></a>)
/*
 * Do NOT touch anything below!
 */
$db = new PDO("mysql:host=$database_host;dbname=$database_name;charset=utf8mb4", "$database_username", "$database_password");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);