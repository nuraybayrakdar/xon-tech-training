<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include('../function/post_controller.php');

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "GET") {
    if(isset($_GET['post_id'])){
        $res = getPost($_GET['post_id']);
    } else {
        $res = getAllPosts();
    }
    echo json_encode($res);
}else {
    $data = [
        "status" => 405,
        "message" => "This method is not allowed"
    ];
    http_response_code(405);
    echo json_code($data, JSON_PRETTY_PRINT);
}


?>