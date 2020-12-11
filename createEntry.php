<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$body = file_get_contents("php://input");

// Decode the JSON object
$object = json_decode($body, true);

$tableName = $object['tableName'];
$entry     = $object['entry'];

if ($tableName && in_array($tableName, $allowedTableNames) && $entry) {
  switch ($tableName) {
    case "entries":
      $query = "INSERT INTO $tableName (subject_id, user_id, question, answer, hint, created_at) values (:subject_id, :question, :user_id, :answer, :hint, :created_at)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      print_r($entry);
      break;

    case "subjects":
      $query = "INSERT INTO $tableName (title, description, created_at, user_id) values (:title, :description, :created_at, :user_id)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "comments":
      $query = "INSERT INTO $tableName (content, user_id, entry_id, created_at) values (:content, :user_id, :entry_id, :created_at)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "grades":
      $query = "INSERT INTO $tableName (grade, user_id, entry_id, note) values (:grade, :user_id, :entry_id, :note)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "quizzes":
      $query = "INSERT INTO $tableName (quiz_id	title	description	user_id	created_at) values (:quiz_id, :title, :description, :user_id, :created_at)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "quizz_entries":
      $query = "INSERT INTO $tableName (entry_id, user_id) values (:entry_id, :user_id)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "rates":
      $query = "INSERT INTO $tableName (entry_id, user_id) values (:entry_id, :user_id)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    case "users":
      $query = "INSERT INTO $tableName (first_name, first_name, email, password, role, username) values (:first_name, :first_name, :email, :password, :role, :username)";
      $statement = $mysql->prepare($query);
      $statement->execute($entry);
      $result = $mysql->lastInsertId();
      break;

    default:
      $result = -2;
      break;
  }
  echo $result;
} else {
  echo -1;
}
