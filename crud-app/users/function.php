<?php

require '../inc/dbcon.php';

function error422($message){
    $data = [
        "status" => 422,
        "message" => $message
    ];
    header("HTTP/1.0 422 Unprocessable Entity");
    echo json_encode($data);
    exit();
}

function getUserList(){
    global $conn;
    $query = "SELECT * FROM users";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
       if(mysqli_num_rows($query_run) > 0){
           $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
           $data = [
            "status" => 200,
            "message" => "User list fetched successfully",
            "data" => $res
        ];
        header("HTTP/1.0 200 Success");
        return json_encode($data);
       }
       else{
           $data = [
               "status" => 404,
               "message" => "No user found"
           ];
           header("HTTP/1.0 404 Not Found");
           return json_encode($data);
       }
    }
    else{
        $data = [
            "status" => 500,
            "message" => "This method is not allowed"
        ];
        header("HTTP/1.0 500 Internal Server");
        echo json_encode($data);
    }

}

function getUser($userParams){
    global $conn;
   
   if($userParams['id'] == null){
      return error422("User id is required");
   }

    $userId = mysqli_real_escape_string($conn, $userParams['id']);
    $query = "SELECT * FROM users WHERE id = '$userId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if($result){
      if (mysqli_num_rows($result) == 1) {
        $res = mysqli_fetch_assoc($result);
        $data = [
            "status" => 200,
            "message" => "User fetched successfully",
            "data" => $res
        ];
        return json_encode($data);
      } else{
        $data = [
            "status" => 404,
            "message" => "No user found"
        ];
        header("HTTP/1.0 404 Not Found");
        return json_encode($data);
      }
    } else{
        $data = [
            "status" => 500,
            "message" => "This method is not allowed"
        ];
        header("HTTP/1.0 500 Internal Server");
        return json_encode($data);
    }

}

function storeUser() {
    global $conn;
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $password = password_hash($password, PASSWORD_DEFAULT);

    if (empty(trim($username))) {
        return error422("Username is required");
    } elseif (empty(trim($email))) {
        return error422("Email is required");
    } elseif (empty(trim($password))) {
        return error422("Password is required");
    } else {
        $query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $data = [
                    "status" => 201,
                    "message" => "User created successfully."
                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);
            } else {
                $data = [
                    "status" => 500,
                    "message" => "This method is not allowed."
                ];
                header("HTTP/1.0 500 Internal Server");
                echo json_encode($data);
            }
            mysqli_stmt_close($stmt);
        } else {
            $data = [
                "status" => 500,
                "message" => "This method is not allowed."
            ];
            header("HTTP/1.0 500 Internal Server");
            echo json_encode($data);
        }
    }
}

?>