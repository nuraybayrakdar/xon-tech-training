<?php

error_reporting(0);

header('Access-Control-Allow-Origin: *');  
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include('function.php');


$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "PUT") {
    $inputData = json_decode(file_get_contents('php://input'), true);
    if(empty($inputData)) {
       $updateUser = updateUser($_POST, $_GET);
        
    } else {
        $updateUser = updateUser($inputData, $_GET);
    }
    echo $updateUser;

}
else {
    $data = [
        "status" => 405,
        "message" => "This method is not allowed"
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);

}

?>