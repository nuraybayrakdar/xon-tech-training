<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include('../function/category_controller.php');

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST") {
    $input = json_decode(file_get_contents('php://input'), true);
    if (empty($input)) {
        $createCategory = createCategory($_POST['category_name']); 
    } else {
        $createCategory = createCategory($input['category_name']); 
    }
    echo $createCategory;
} else {
    $data = [
        "status" => 405,
        "message" => "This method is not allowed"
    ];
    http_response_code(405);
    echo json_encode($data, JSON_PRETTY_PRINT);
}

?>
