<?php

require_once __DIR__ . './database.php';
$db = new Database;

$id = false;
if(isset($_COOKIE['token'])) {
    $token = $_COOKIE['token'];
    $id = $db->check_auth($token);
}
return $id;