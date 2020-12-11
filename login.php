<?php
require("cors.php");
require("mysql.php");
session_start();

$body = file_get_contents("php://input");

$object = json_decode($body, true);

$email = $object["email"];
$password = $object["password"];

$query = "SELECT * FROM users WHERE email=:email";
$statement = $mysql->prepare($query);
$statement->bindParam(":email", $email);
$statement->execute();
$user = $statement->fetch(PDO::FETCH_ASSOC);

if ($user && password_verify($password, $user["password"])) {
        $_SESSION["userId"] = $user["user_id"];
        echo json_encode($user);
}


