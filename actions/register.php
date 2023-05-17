<?php

require_once __DIR__ . './../includes/database.php';
$db = new Database;

$login = htmlentities($_POST['login']);
$password = htmlentities($_POST['password']);

if (isset($login) && isset($password)) {
    $is_success = $db->register_user($login, $password);
    
    $data = array("success" =>  $is_success);
    header("Content-Type: application/json");
    
    echo json_encode($data);
}