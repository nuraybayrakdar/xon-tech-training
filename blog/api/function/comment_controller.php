<?php
require '../inc/dbcon.php';
 
function getCommentsByPostId($post_id) {
    global $conn;
    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id";
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
            "message" => "Comment list by post id fetched successfully",
            "data" => $res
        ];
        http_response_code(200);
    } else {
        $data = [
            "status" => 404,
            "message" => "No post found"
        ];
        http_response_code(404);
    }
    
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
    
    
}

function createComment($data) {
    global $conn;
    $comment_post_id = $data['comment_post_id'];
    $comment_author = $data['comment_author'];
    $comment_text = $data['comment_text'];
    $comment_date = date('Y-m-d H:i:s');
    $comment_email = $data['comment_email'];
    $comment_status= "publish";

    $query = "INSERT INTO comments (comment_post_id, comment_author, comment_text, comment_date, comment_email, comment_status) VALUES ('$comment_post_id', '$comment_author', '$comment_text', '$comment_date', '$comment_email', '$comment_status')";
    $query_run = mysqli_query($conn, $query);

    if($query_run === false){
        $data = [
            "status" => 500,
            "message" => "Error executing query"
        ];
        http_response_code(500);
        return json_encode($data);
    } else {
        $data = [
            "status" => 201,
            "message" => "Comment created successfully"
        ];
        http_response_code(201);
    } 

    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

function deleteComment($comment_id) {
    global $conn;
    $query = "DELETE FROM comments WHERE comment_id = $comment_id";
    $query_run = mysqli_query($conn, $query);

    if($query_run === false){
        $data = [
            "status" => 500,
            "message" => "Error executing query"
        ];
        http_response_code(500);
        return json_encode($data);
    } else {
        $data = [
            "status" => 200,
            "message" => "Comment deleted successfully"
        ];
        http_response_code(200);
    } 

    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

function gelAllComments()  {
    
    global $conn;
    $query = "SELECT * FROM comments";
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
            "message" => "Comment list fetched successfully",
            "data" => $res
        ];
        http_response_code(200);
    } else {
        $data = [
            "status" => 404,
            "message" => "No post found"
        ];
        http_response_code(404);
    }
    
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}




?>