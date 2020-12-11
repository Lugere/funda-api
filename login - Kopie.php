<?php
require("cors.php");
require("mysql.php");
session_start();

if (!isset($_SESSION["userId"])) echo json_encode($_SESSION["userId"]);
