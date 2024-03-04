<?php

require '../inc/dbcon.php';
session_start();

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


function login($data) {
    global $conn;
    // Gelen veriyi kontrol et
    if(empty($data['user_name']) || empty($data['user_password'])) {
        $response = [
            "status" => 400,
            "message" => "Missing username or password"
        ];
        http_response_code(400);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($response);
    }

    $user_name = $data['user_name'];
    $user_password = $data['user_password'];
    
    $query = "SELECT * FROM users WHERE user_name = ? LIMIT 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 's', $user_name);
    $query_run = mysqli_stmt_execute($stmt);

    if(!$query_run) {
        $response = [
            "status" => 500,
            "message" => "Error executing query"
        ];
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($response);
    }

    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    
    if(!$row) {
        $response = [
            "status" => 404,
            "message" => "User not found"
        ];
        http_response_code(404);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($response);
    }

    if($user_name === $row['user_name'] && $user_password === $row['user_password']) {
        $_SESSION['username'] = $row['user_name'];
        $_SESSION['email'] = $row['user_email'];
        $_SESSION['role'] = $row['user_role'];

        $response = [
            "status" => 200,
            "message" => "Login successful",
            "data" => $row
        ];
        http_response_code(200);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($response);
    } else {
        $response = [
            "status" => 401,
            "message" => "Invalid credentials"
        ];
        http_response_code(401);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($response);
    }
}


?>