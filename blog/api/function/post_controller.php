<?php

require '../inc/dbcon.php';


function getAllPosts(){
    global $conn;
    $query = "SELECT * FROM posts";
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
            "message" => "Post list fetched successfully",
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

function getPost($post_id){
    global $conn;
    $query = "SELECT * FROM posts WHERE post_id = $post_id";
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
            "message" => "Post fetched successfully",
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


function createPost($data){

    global $conn;
    $title = $data['post_title'];
    $content = $data['post_text'];
    $author = $data['post_author'];
    $category_id = $data['post_category_id'];
    $image = $data['post_image'];
    $tags = $data['post_tags'];
    $date = date('Y-m,d'); 
    
    $query = "INSERT INTO posts (post_category_id, post_title, post_author, post_date, post_comment_number, post_image, post_text, post_tags) 
              VALUES ('$category_id', '$title', '$author', '$date', '0', '$image', '$content', '$tags')";
              
    $query_run = mysqli_query($conn, $query);



    if ($query_run) {
        $data = [
            "status" => 201,
            "message" => "Post created successfully"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(201);
        return json_encode($data);
    } else {
        $data = [
            "status" => 500,
            "message" => "Failed to create post"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        return json_encode($data);
    }
    
}

function updatePost($data){
    
}

function deletePost($post_id){
    global $conn;

    $query = "DELETE FROM posts WHERE post_id = $post_id";
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

function getPostByCategory($category_id){

    global $conn;
    $query = "SELECT * FROM posts WHERE post_category_id = $category_id";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
       if(mysqli_num_rows($query_run) > 0){
           $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
           $data = [
            "status" => 200,
            "message" => "Post list fetched successfully",
            "data" => $res
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        return json_encode($data);
       }
       else{
           $data = [
               "status" => 404,
               "message" => "No post found"
           ];
           header('Content-Type: application/json; charset=utf-8');
           http_response_code(404);
           return json_encode($data);
       }
    }
    else{
        $data = [
            "status" => 500,
            "message" => "This method is not allowed"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        return json_encode($data);
    }
    
}


?>