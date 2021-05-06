<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$body = file_get_contents("php://input");
$object = json_decode($body, true);
$tableName = $object['tableName'];
$entry     = $object['entry'];

if ($tableName && $entry) {
  if (in_array($tableName, $allowedTableNames)) {
    switch ($tableName) {
      case "entries":
        $query = "INSERT INTO $tableName (subject_id, question, user_id, answer, hint, created_at) values (:subject_id, :question, :user_id, :answer, :hint, :created_at)";
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
        $entry["password"] = password_hash($entry["password"], PASSWORD_DEFAULT);
        $query = "INSERT INTO $tableName (first_name, last_name, email, password, role, username, created_at) values (:first_name, :last_name, :email, :password, :role, :username, :created_at)";
        $statement = $mysql->prepare($query);
        $statement->execute($entry);
        $result = $mysql->lastInsertId();
        break;

      default:
        $result = ["msg" => "table_not_found"];
        break;
    }
  } else {
    $result = ["msg" => "table_not_allowed_list"];
  }
} else {
  $result = ["msg" => "tableName or entry undefined"];
}

echo json_encode($result, JSON_PRETTY_PRINT);
