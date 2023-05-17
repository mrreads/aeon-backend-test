<?php
header("Content-Type: application/json");

require_once __DIR__ . './database.php';
$db = new Database;

$id = require_once __DIR__ . './is_login.php';
if ($id) {
    $login = $db->get_user($id);

    if ($login) {
        $json = array("success" =>  true, "data" => $login);
        echo json_encode($json);
        return true;
    }
}
echo json_encode(array("success" =>  false));
return false;