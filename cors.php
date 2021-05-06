<?php
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    // return only the headers and not the content
    // only allow CORS if we're doing a GET - i.e. no saving for now.
    //    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']) && 
    //      $_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD'] == 'GET') {
    header("Access-Control-Allow-Origin: *");
    header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, X-Requested-With');
    header("Content-Type: application/json");
    //    }
    exit;
}

header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, X-Requested-With');
header("Content-Type: application/json");

/*
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // return only the headers and not the content
    // only allow CORS if we're doing a GET - i.e. no saving for now.
      header('x-test: hallo');
      header('Content-Type: application/json');
	echo "[]";
	exit;
}
*/
