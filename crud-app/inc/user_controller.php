<?php

require 'database.php';

class UserController {
    private $db;

    public function __construct($host, $username, $password, $dbname) {
        $this->db = new Database($host, $username, $password, $dbname);
    }

    public function getUser($userId) {
        $userId = $this->db->escapeString($userId);

        $query = "SELECT id, username, email FROM users WHERE id = '$userId' LIMIT 1";
        $result = $this->db->executeQuery($query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            return [
                "status" => 200,
                "message" => "User fetched successfully",
                "data" => $user
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($user, JSON_PRETTY_PRINT);
            $this->db->setHttpResponse(200, "User fetched successfully");

        } else {
            $this->db->setHttpResponse(404, "No user found");
        }
    }

    public function getUserList() {
        $query = "SELECT id, username, email FROM users";
        $result = $this->db->executeQuery($query);

        if (mysqli_num_rows($result) > 0) {
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
            return [
                "status" => 200,
                "message" => "User list fetched successfully",
                "data" => $users
            ];
            $this->db->setHttpResponse(200, "User list fetched successfully");
        } else {
            $this->db->setHttpResponse(404, "No user found");
        }
    }

   

    public function register($userData) {
        $username = $this->db->escapeString($userData['username']);
        $email = $this->db->escapeString($userData['email']);
        $password = $this->db->escapeString($userData['password']);
        $password = password_hash($password, PASSWORD_DEFAULT);

        $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
        $result = $this->db->executeQuery($query);

        if ($result) {
            return [
                "status" => 200,
                "message" => "Success: User created successfully"
            ];
                 
            $this->db->setHttpResponse(201, "User created successfully");
        } else {
            return [
                "status" => 500,
                "message" => "Error: User could not be created"
            ];
            $this->db->setHttpResponse(500, "Error: User could not be created");
        }
    }

    public function login($email, $password) {
        $email = $this->db->escapeString($email);
        $password = $this->db->escapeString($password);

        $query = "SELECT id, username, email, password FROM users WHERE email = '$email' LIMIT 1";
        $result = $this->db->executeQuery($query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            if (password_verify($password, $user['password'])) {
                $_SESSION = [
                    "userid" => $user['id'],
                    "username" => $user['username'],
                    "email" => $user['email']
                ];
                http_response_code(200);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(
                    [
                        "status" => 200,
                        "message" => "Success: User logged in",
                    
                    ]
                );
                exit();
            } else {
                http_response_code(401);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode(["status" => 401, "message" => "Invalid password"]);
                exit();
            }
        } else {
            http_response_code(404);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(["status" => 404, "message" => "No user found"]);
            exit();
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        header("Location: ../register-page.html");
        exit();
    }
    
    public function getProfile($id){
        $query = "SELECT id, username, email FROM users WHERE id = '$userId' LIMIT 1";
        $result = $this->db->executeQuery($query);

        if (mysqli_num_rows($result) == 1) {
            $user = mysqli_fetch_assoc($result);
            return [
                "status" => 200,
                "message" => "User fetched successfully",
                "data" => $user
            ];
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($user, JSON_PRETTY_PRINT);
            $this->db->setHttpResponse(200, "User fetched successfully");

        } else {
            $this->db->setHttpResponse(404, "No user found");
        }
 

    }

    
}

?>