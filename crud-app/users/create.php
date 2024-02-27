<?php

error_reporting(0);

header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

require_once('../inc/user_controller.php');

$userController = new UserController("localhost", "root", "", "web_dev_crud");

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST") {
    $inputData = json_decode(file_get_contents('php://input'), true);
    if(empty($inputData)) {
        $storeUser = $userController->register($_POST);
    } else {
        $storeUser = $userController->register($inputData);
    }
    echo json_encode($storeUser);
}
else {
    $data = [
        "status" => 405,
        "message" => "This method is not allowed"
    ];
    http_response_code (405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
}

?>
