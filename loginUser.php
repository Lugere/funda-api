<?php
require("cors.php");
require("mysql.php");
include "deleteAllExpiredTokens.php";

header('Content-Type: application/json');
$body = file_get_contents("php://input");
$object = json_decode($body, true);

$email      = $object["email"];
$password   = $object["password"];
$expires_in  = $object["expiresIn"];

deleteAllExpiredTokens();

// 
$query = "SELECT * FROM users WHERE email=?";
$statement = $mysql->prepare($query);
$statement->execute([$email]);
$rowCount = $statement->rowCount();
if ($rowCount === 1) {
        $user = $statement->fetchAll(PDO::FETCH_ASSOC)[0];
        $isPassword = password_verify($password, $user["password"]);
        if ($user && $isPassword) {
                // Generate token and get current time
                $random_security_token = bin2hex(openssl_random_pseudo_bytes(16));
                $timestamp = strtotime("now");
                // Generate token-expiration => default = 24h, rememberMe = 14d
                $expiration_time = $expires_in === "14d" ? strtotime("+14 days") : strtotime("+24 hours");
                // Add token to database
                try {
                        $query = "INSERT INTO security_tokens (user_id, token, expires_in, expiration_time, created_at) VALUES (?, ?, ?, ?, ?)";
                        $statement = $mysql->prepare($query);
                        $statement->execute([
                                $user["user_id"],
                                $random_security_token,
                                $expires_in,
                                $expiration_time,
                                $timestamp
                        ]);
                        $result = ["msg" => "login_success", "user" => $user, "token" => $random_security_token];
                } catch (Exception $e) {
                        $result = ["msg" => "error_creating_security_token"];
                }
        } else if (!$user) {
                $result = ["msg" => "user_not_found", "user" => []];
        } else if (!$isPassword) {
                $result = ["msg" => "password_incorrect", "user" => []];
        }
} else if ($statement->rowCount() === 0) {
        $result = ["msg" => "user_not_found", "user" => []];
} else {
        $result = ["msg" => "invalid_rowcount", "user" => []];
}

echo json_encode($result, JSON_PRETTY_PRINT);
