<?php
    $host = "localhost";
    $dbname = "funda_db";
    $user = "root";
    $pass = "";

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
        $mysql = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    } catch (PDOException $e) {
        die("Database connection failed: " . $$mysql->connect_error);
    }
?>
