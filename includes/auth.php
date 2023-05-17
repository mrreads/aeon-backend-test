<?php
header("Content-Type: application/json");

require_once __DIR__ . './database.php';
$db = new Database;

$login = htmlentities($_POST['login']);
$password = htmlentities($_POST['password']);

if (isset($login) && isset($password)) {
    $is_success = $db->auth_user($login, $password);
    
    $json = array("success" =>  $is_success);
    echo json_encode($json);
    return $is_success;
}
echo json_encode(array("success" =>  false));
return false;