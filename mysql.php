<?php
    $host = "localhost";
    $dbname = "funda_db";
    $dbuser = "root";
    $dbpass = "";

    $allowedTableNames = [
        "entries",
        "users",
        "subjects",
        "comments",
        "quizzes",
        "quiz_entries",
        "rates",
        "grades",
    ];

    try {
        $mysql = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    } catch (PDOException $e) {
        die("Database connection failed: " . $$mysql->connect_error);
    }
?>
