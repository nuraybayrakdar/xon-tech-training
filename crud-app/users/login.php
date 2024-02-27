<?php
error_reporting(E_ALL); 
ini_set('display_errors', 1);
session_start();

require_once('../inc/user_controller.php');

if (isset($_SESSION['userid'])) {
    header("Location: ../index.html");
    exit();
}

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

$request_method = $_SERVER["REQUEST_METHOD"];

if ($request_method == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    $userController = new UserController("localhost", "root", "", "web_dev_crud");
    $loginResult = $userController->login($_POST['email'], $_POST['password']);

    if ($loginResult['status'] == 200) {
        echo json_encode($loginResult);
        exit();
    } else {
        echo json_encode($loginResult);
    }


}

?>