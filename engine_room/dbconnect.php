<?php
$db = new PDO('mysql:host=localhost;dbname=viewary;charset=utf8mb4', 'root', '');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);