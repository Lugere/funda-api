<?php
require("cors.php");
require("mysql.php");
include("deleteAllExpiredTokens.php");

header('Content-Type: application/json');

$body = file_get_contents("php://input");
$object = json_decode($body, true);
$client_security_token = $object['securityToken'];

deleteAllExpiredTokens();

if (!is_null($client_security_token)) {
    try {
        //
        // Get the specified security_token from db
        //
        $query = "SELECT * FROM security_tokens WHERE token = ?";
        $statement = $mysql->prepare($query);
        $statement->execute([$client_security_token]);
        $rowCount = $statement->rowCount();
        // Only proceed if only ONE token is returned
        if ($rowCount === 1) {
            //
            // When user is re-authenticated extend expiration_time
            //
            $server_security_token = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
            $expires_in = $server_security_token["expires_in"];
            $expiration_time = $expires_in === "14d" ? strtotime("+14 days") : strtotime("+24 hours");
            try {
                $query = "UPDATE security_tokens SET expiration_time = ? WHERE token = ?";
                $statement = $mysql->prepare($query);
                $statement->execute([$expiration_time, $server_security_token["token"]]);
                //
                // Get user that's connected to security_token
                //
                try {
                    $query = "SELECT * FROM users WHERE user_id=?";
                    $statement = $mysql->prepare($query);
                    $statement->execute([$server_security_token["user_id"]]);
                    $rowCount = $statement->rowCount();
                    // Only proceed if only ONE user is returned
                    if ($rowCount === 1) {
                        //
                        // User is still logged in, return user-data
                        //
                        $user = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
                        $result = ["msg" => "user_logged_in", "user" => $user];
                    }
                } catch (Exception $e) {
                    $result = ["msg" => "error_getting_user -> " . $e];
                }
            } catch (Exception $e) {
                $result = ["msg" => "error_updating_expiration_time"];
            }
        } else if ($rowCount > 1) {
            // Duplicate found, check other code!
            $result = ["msg" => "invalid_rowcount"];
        } else {
            // No security_token found
            $result = ["msg" => "user_not_logged_in"];
        }
    } catch (Exception $e) {
        $result = ["msg" => "re_auth_error -> " . $e];
    }
} else {
    // No token was specified, check other code!
    $result = ["msg" => "client_securitiy_token_is_null"];
}


echo json_encode($result, JSON_PRETTY_PRINT);
