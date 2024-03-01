<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include('../function/user_controller.php');

$request_method = $_SERVER["REQUEST_METHOD"];

if($request_method == "DELETE"){
    if(!empty($_GET['user_id'])){
        $user_id = $_GET['user_id'];
        $deleteUser = deleteUser($user_id);
        echo $deleteUser;

    } else {
        $data = [
            "status" => 400,
            "message" => "Post ID is not provided"
        ];
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data);
    }
} 
else {
    $data = [
        "status" => 405,
        "message" => "This method is not allowed"
    ];
    http_response_code(405);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);

}

?>