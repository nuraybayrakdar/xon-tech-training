<?php

require '../inc/dbcon.php';
session_start();

function createUser($data) {
    global $conn;
    
    $data = json_decode(file_get_contents("php://input"), true);
    $stmt = mysqli_prepare($conn, "INSERT INTO users (user_name, user_email, user_password, user_role) VALUES (?, ?, ?, ?)");
  
    $user_name = mysqli_real_escape_string($conn, $data['user_name']);
    $user_email = mysqli_real_escape_string($conn, $data['user_email']);
    $user_password = password_hash($data['user_password'], PASSWORD_DEFAULT); 
    $user_role = mysqli_real_escape_string($conn, $data['user_role']);
  
    
    mysqli_stmt_bind_param($stmt, "ssss", $user_name, $user_email, $user_password, $user_role);
  
    
    if (mysqli_stmt_execute($stmt)) {
      $data = [
        "status" => 201,
        "message" => "User created successfully"
      ];
      http_response_code(201); 
    } else {
      $error_message = mysqli_stmt_error($stmt);
      $data = [
        "status" => 500,
        "message" => "Failed to create user: $error_message"
      ];
      
    }
  
    mysqli_stmt_close($stmt); 
  
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
  }
  

  function updateUser($data) {
    global $conn;
    
    if (!isset($data['user_id'])) {
      $data = [
        "status" => 400,
        "message" => "User ID is required"
      ];
      http_response_code(400); 
      return json_encode($data);
    }
  
    $user_id = mysqli_real_escape_string($conn, $data['user_id']);     
    $stmt = mysqli_prepare($conn, "UPDATE users SET user_name = ?, user_email = ?, user_password = ?, user_role = ? WHERE user_id = ?");

    $user_name = mysqli_real_escape_string($conn, $data['user_name']);
    $user_email = mysqli_real_escape_string($conn, $data['user_email']);
    $user_password = isset($data['user_password']) ? password_hash($data['user_password'], PASSWORD_DEFAULT) : null;
    $user_role = mysqli_real_escape_string($conn, $data['user_role']);
  
    
    mysqli_stmt_bind_param($stmt, "sssss", $user_name, $user_email, $user_password, $user_role, $user_id);
  
    
    if (mysqli_stmt_execute($stmt)) {
      $data = [
        "status" => 200,
        "message" => "User updated successfully"
      ];
      http_response_code(200); 
      return $data;
    } else {
      $error_message = mysqli_stmt_error($stmt);
      $data = [
        "status" => 500,
        "message" => "Failed to update user: $error_message"
      ];
      
    }
  
    mysqli_stmt_close($stmt); 
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
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
    $user_name = $data['user_name'];
  
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE user_name = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $user_name);
  
    if (mysqli_stmt_execute($stmt)) {
      $result = mysqli_stmt_get_result($stmt);
      $row = mysqli_fetch_assoc($result);
  
      if ($row) {
        if (password_verify($data['user_password'], $row['user_password'])) {
          $_SESSION['username'] = $row['user_name'];
          $_SESSION['email'] = $row['user_email'];
          $_SESSION['role'] = $row['user_role'];
  
          $response = [
            "status" => 200,
            "message" => "Login successful"
          ];
          http_response_code(200);
          return json_encode($response);
        } else {
          $response = [
            "status" => 401,
            "message" => "Invalid credentials"
          ];
          http_response_code(401);
          return json_encode($response);
        }
      } else {
        $response = [
          "status" => 404,
          "message" => "User not found"
        ];
        http_response_code(404);
        return json_encode($response);
      }
    } else {
      $error_message = mysqli_stmt_error($stmt);
      $response = [
        "status" => 500,
        "message" => "Error executing query: $error_message"
      ];
      http_response_code(500);
      return json_encode($response);
    }
  
    mysqli_stmt_close($stmt);
  }


  function getDashboard() {
    global $conn;

    $query1 = "SELECT COUNT(*) as totalPosts FROM posts";
    $stmt1 = $conn->prepare($query1);
    $stmt1->execute();
    $totalPosts = $stmt1->get_result()->fetch_assoc()['totalPosts'];

    $query2 = "SELECT COUNT(*) as totalComments FROM comments";
    $stmt2 = $conn->prepare($query2);
    $stmt2->execute();
    $totalComments = $stmt2->get_result()->fetch_assoc()['totalComments'];

    $query3 = "SELECT COUNT(*) as totalUsers FROM users";
    $stmt3 = $conn->prepare($query3);
    $stmt3->execute();
    $totalUsers = $stmt3->get_result()->fetch_assoc()['totalUsers'];

    $data = [
        "totalPosts" => $totalPosts,
        "totalComments" => $totalComments,
        "totalUsers" => $totalUsers
    ];

    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

  

?>