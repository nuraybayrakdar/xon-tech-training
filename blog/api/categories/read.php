<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include('../function/category_controller.php');

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "GET") {
    if(isset($_GET['category_id'])){
        $category = getCategory($_GET['category_id']);
    } else {
        $category = getAllCategories();
    }
    echo json_encode($category, JSON_PRETTY_PRINT);
}else {
    $data = [
        "status" => 405,
        "message" => "This method is not allowed"
    ];
    http_response_code(405);
    echo json_code($data, JSON_PRETTY_PRINT);
}


?>