<?php

require 'dbcon.php';


class Database {
    private $conn;

    public function __construct($host, $username, $password, $dbname) {
        $this->conn = mysqli_connect($host, $username, $password, $dbname);

        if (!$this->conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
    }

    public function executeQuery($query) {
        $result = mysqli_query($this->conn, $query);

        if ($result) {
            return $result;
            
        } else {
            $this->setHttpResponse(500, "Database query failed");
        }
    }

    public function escapeString($value) {
        return mysqli_real_escape_string($this->conn, $value);
    }

    private function setHttpResponse($status, $message) {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode(["status" => $status, "message" => $message]);
        exit();
    }

    public function error422($message) {
        $data = [
            "status" => 422,
            "message" => $message
        ];
        http_response_code(422);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
        exit();
    }
}



?>
