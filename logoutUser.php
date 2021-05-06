<?php
require("cors.php");
require("mysql.php");
include "deleteAllExpiredTokens.php";

header('Content-Type: application/json');

$body = file_get_contents("php://input");
$object = json_decode($body, true);
$client_security_token = $object['securityToken'];

deleteAllExpiredTokens();

if (!is_null($client_security_token)) {
    try {
        $query = "DELETE FROM security_tokens WHERE token = ?";
        $statement = $mysql->prepare($query);
        $statement->execute([$client_security_token]);
        $rowCount = $statement->rowCount();
        $result = ["msg" => "logout_success"];
    } catch (Exception $e) {
        $result = ["msg" => "error_deleting_token"];
    }
} else {
    // No token was specified, check other code!
    $result = ["msg" => "client_securitiy_token_is_null"];
}

echo json_encode($result, JSON_PRETTY_PRINT);
