<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$body = file_get_contents("php://input");
$object = json_decode($body, true);
$tableName = $object['tableName'];
$entry     = $object['entry'];

print_r($entry);

if ($tableName && in_array($tableName, $allowedTableNames) && $entry) {
  switch ($tableName) {
    case "entries":
      $query = "UPDATE $tableName SET subject_id=:subject_id, question=:question, answer=:answer, hint=:hint, user_id=:user_id, created_at=:created_at WHERE entry_id=:entry_id";
      echo $query;
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "subjects":
      $query = "UPDATE $tableName SET title=:title, 'description'=':description'";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "comments":
      $query = "UPDATE $tableName SET content=:content";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "grades":
      $query = "UPDATE $tableName SET grade=:grade";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "quizzes":
      $query = "UPDATE $tableName SET title=:title,'description'=':description'";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "rates":
      $query = "UPDATE $tableName SET rating=:rating";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "users":
      $query = "UPDATE $tableName SET first_name=:first_name, last_name=:last_name, username=:username, email=:email, 'password'=:'password', 'role'=':role'";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    default:
      $result = -2;
      break;
  }
  echo $result;
} else echo -1;
