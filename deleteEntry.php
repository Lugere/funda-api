<?php
require("cors.php");
require("mysql.php");

header('Content-Type: application/json');

$body = file_get_contents("php://input");

// Decode the JSON object
$object = json_decode($body, true);

$tableName  = $object['tableName'];
$columnName = $object['columnName'];
$id         = $object['id'];

if ($tableName && in_array($tableName, $allowedTableNames) && $id && $columnName) {
  switch ($columnName) {
    case "entry_id":
      $query = "DELETE FROM $tableName where entry_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "subject_id":
      $query = "DELETE FROM $tableName where subject_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "comment_id":
      $query = "DELETE FROM $tableName where comment_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "quiz_id":
      $query = "DELETE FROM $tableName where quiz_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "quiz_entry_id":
      $query = "DELETE FROM $tableName where quiz_entry_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "grade_id":
      $query = "DELETE FROM $tableName where grade_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "rating_id":
      $query = "DELETE FROM $tableName where rating_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;

    case "user_id":
      $query = "DELETE FROM $tableName where user_id=:id";
      $statement = $mysql->prepare($query);
      $statement->bindParam(":id", $id);
      $statement->execute();
      break;
  }

  $rowCount = $statement->rowCount();

  echo $rowCount;
} else {
  echo -1;
}
