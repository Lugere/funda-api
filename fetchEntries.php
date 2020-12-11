<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$tableName = $_GET['tableName'];

if ($tableName && in_array($tableName, $allowedTableNames)) {
  switch ($tableName) {
    case "entries":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "users":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "subjects":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "quizzes":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "quiz_entries":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "comments":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "grades":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;

    case "rates":
      $query = "SELECT * FROM $tableName ORDER BY created_at DESC";
      $statement = $mysql->prepare($query);
      $statement->execute();
      $result = $statement->fetchAll(PDO::FETCH_ASSOC);
      break;
		  
    default:
	  $result = [ $tableName ];
      break;
  }
} else {
  $result = [];
}

echo json_encode($result, JSON_PRETTY_PRINT);
