<?php
require("cors.php");
require("mysql.php");

function deleteAllExpiredTokens() {
    global $mysql;
    // Delete all Sessions where the expiration-unixtime
    // is smaller than the current unixtime
    $now = strtotime("now");
    $query = "DELETE FROM security_tokens WHERE expires < ?";
    $statement = $mysql->prepare($query);
    $statement->execute([$now]);
}
