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

function getAllCategories(){
    global $conn;
    $query = "SELECT * FROM categories";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
       if(mysqli_num_rows($query_run) > 0){
           $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
           
           $data = [
            "status" => 200,
            "message" => "User list fetched successfully",
            "data" => $res
             ];
        header('Content-Type: application/json; charset=utf-8');

        http_response_code(200);
        return json_encode($data );
       }
       else{
           $data = [
               "status" => 404,
               "message" => "No user found"
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
        header("HTTP/1.0 500 Internal Server");
        echo json_encode($data);
    }

}

function createCategory($category_name) {
    global $conn;
    
    $category_name = mysqli_real_escape_string($conn, $category_name);

    $query = "INSERT INTO categories (category_name) VALUES ('$category_name')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        $data = [
            "status" => 201,
            "message" => "Category created successfully"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(201);
        return json_encode($data);
    } else {
        $data = [
            "status" => 500,
            "message" => "Failed to create category"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
        return json_encode($data);
    }
}


function getCategory($category_id){
    global $conn;
    $query = "SELECT * FROM categories WHERE category_id = $category_id";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
       if(mysqli_num_rows($query_run) > 0){
           $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);
           $data = [
            "status" => 200,
            "message" => "User fetched successfully",
            "data" => $res
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        return json_encode($data);
       }
       else{
           $data = [
               "status" => 404,
               "message" => "No user found"
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
        header("HTTP/1.0 500 Internal Server");
        return json_encode($data);
    }

}

function updateCategory($data) {
    global $conn;

    $category_id = mysqli_real_escape_string($conn, $data['category_id']);

    $category_name = mysqli_real_escape_string($conn, $data['category_name']);
    if ($category_id === null && $category_name === null) {
        return error422('Category name or id is not provided');
    }

    if ($category_id && $category_name) {
        $query = "UPDATE categories SET category_name = '$category_name' WHERE category_id = '$category_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $data = [
                "status" => 200,
                "message" => "Kategori başarıyla güncellendi"
            ];
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            return json_encode($data);
        } else {
            $data = [
                "status" => 500,
                "message" => "Kategori güncellenemedi"
            ];
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            return json_encode($data);
        }
    } else {
        $data = [
            "status" => 400,
            "message" => "Güncellenecek bir kategori adı veya kimliği sağlanmadı"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(400);
        return json_encode($data);
    }
}


function deleteCategory($category_id){
    global $conn;
    
    $category_type = gettype($category_id);
    
    if ($category_type === 'string') {
        $category_id = mysqli_real_escape_string($conn, $category_id);
    } else if ($category_type === 'array' && isset($category_id['category_id'])) {
        $category_id = mysqli_real_escape_string($conn, $category_id['category_id']);
    }

    $query = "DELETE FROM categories WHERE category_id = '$category_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run){
        $data = [
            "status" => 200,
            "message" => "Category deleted successfully"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(200);
        return json_encode($data);
    }
    else{
        $data = [
            "status" => 500,
            "message" => "Failed to delete category"
        ];
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($data);
    }
}


?>
