<?php

require '../inc/dbcon.php';

function createUser($data) {
    global $conn;
    $data = json_decode(file_get_contents("php://input"), true);
    $user_name = $data['user_name'];
    $user_email = $data['user_email'];
    $user_password = $data['user_password'];
    $user_role = $data['user_role'];

    $query = "INSERT INTO users (user_name, user_email, user_password, user_role) VALUES ('$user_name', '$user_email', '$user_password', '$user_role')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $data = [
            "status" => 201,
            "message" => "User created successfully"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(201);
        return json_encode($data);
    } else {
        $data = [
            "status" => 500,
            "message" => "Failed to create user"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        return json_encode($data);
    }
    
}

function updateUser() {
    
}

function deleteUser($user_id) {
    global $conn;

    $query = "DELETE FROM users WHERE user_id = $user_id";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $data = [
            "status" => 200,
            "message" => "Post deleted successfully"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        return json_encode($data);
    } else {
        $data = [
            "status" => 500,
            "message" => "Failed to delete post"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        return json_encode($data);
    }

}

function getUser($user_id) {
    global $conn;
    $query = "SELECT * FROM users WHERE user_id = $user_id";
    $query_run = mysqli_query($conn, $query);

    if($query_run === false){
        $data = [
            "status" => 500,
            "message" => "Error executing query"
        ];
        http_response_code(500);
        return json_encode($data);
    }

    $res = mysqli_fetch_assoc($query_run);
    if($res){
        $data = [
            "status" => 200,
            "message" => "User fetched successfully",
            "data" => $res
        ];
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    } else {
        $data = [
            "status" => 404,
            "message" => "No user found"
        ];
        http_response_code(404);
    }
    
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

function getAllUsers() {
    global $conn;
    $query = "SELECT * FROM users";
    $query_run = mysqli_query($conn, $query);

    if($query_run === false){
        $data = [
            "status" => 500,
            "message" => "Error executing query"
        ];
        http_response_code(500);
        return json_encode($data);
    }

    $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
    if(mysqli_num_rows($query_run) > 0){
        $data = [
            "status" => 200,
            "message" => "User list fetched successfully",
            "data" => $res
        ];
        http_response_code(200);
    } else {
        $data = [
            "status" => 404,
            "message" => "No user found"
        ];
        http_response_code(404);
    }
    
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}


?>