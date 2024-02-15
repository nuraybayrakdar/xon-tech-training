<?php

require '../inc/dbcon.php';

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

?>