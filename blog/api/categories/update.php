<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include('../function/category_controller.php');

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "PUT") {
    $inputData = json_decode(file_get_contents('php://input'), true);

    if (!empty($inputData['category_name']) && !empty($inputData['category_id'])) {
        $updateCategory = updateCategory($inputData);
        echo $updateCategory;
    } else {
        $data = [
            "status" => 400,
            "message" => "Güncellenecek kategori adı veya kimliği sağlanmadı"
        ];
        http_response_code(400);
        echo json_encode($data);
    }
} else {
    $data = [
        "status" => 405,
        "message" => "Bu yöntem izin verilmiyor"
    ];
    http_response_code(405);
    echo json_encode($data);
}

?>
