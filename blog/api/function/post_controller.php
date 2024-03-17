<?php

require '../inc/dbcon.php';


function getAllPosts($limit, $offset) {
    global $conn;
  
    $stmt = mysqli_prepare($conn, "SELECT * FROM posts LIMIT ? OFFSET ?");
  
    mysqli_stmt_bind_param($stmt, "ii", $limit, $offset);
    mysqli_stmt_execute($stmt);
  
    $result = mysqli_stmt_get_result($stmt);
  
    if (!$result) {
      $data = [
        "status" => 500,
        "message" => "Error executing query"
      ];
      http_response_code(500);
      return json_encode($data);
    }
    $count_query = "SELECT COUNT(*) AS total_posts FROM posts";
    $count_result = mysqli_query($conn, $count_query);
    $total_posts = mysqli_fetch_assoc($count_result)['total_posts'];
  
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $data = [];
  
    if (mysqli_num_rows($result) > 0) {
      $data = [
        "status" => 200,
        "message" => "Post list fetched successfully",
        "total_posts" => $total_posts,
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
  
    mysqli_stmt_close($stmt); 
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}
  
function getAllPostsNoPagin() {
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT * FROM posts"); 

    if (!$stmt) {
        $data = [
            "status" => 500,
            "message" => "Error preparing query"
        ];
        http_response_code(500);
        return json_encode($data);
    }

    if (!mysqli_stmt_execute($stmt)) {
        $data = [
            "status" => 500,
            "message" => "Error executing query"
        ];
        http_response_code(500);
        return json_encode($data);
    }

    
    $result = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $data = [];
    if (mysqli_num_rows($result) > 0) {
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

    mysqli_stmt_close($stmt); 
    mysqli_close($conn); 
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
}

function getCommentCount(){}


function countPosts() {
    global $conn;
    $query = "SELECT COUNT(*) AS total_posts FROM posts";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    return $row['total_posts'];
}

function getPost($post_id) {
    global $conn;
  
    $stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE post_id = ?");
      mysqli_stmt_bind_param($stmt, "i", $post_id); 
  
    if (!mysqli_stmt_execute($stmt)) {
      $data = [
        "status" => 500,
        "message" => "Error executing query"
      ];
      http_response_code(500);
      return json_encode($data);
    }
  
    $result = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_assoc($result);
  
    $data = [];
    if ($res) {
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
  
    mysqli_stmt_close($stmt); 
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
  }
  

  function filterByCategory($category_name) {
    global $conn;
  
    $escaped_category_name = mysqli_real_escape_string($conn, $category_name);
    $stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE post_category = ?");
    mysqli_stmt_bind_param($stmt, "s", $escaped_category_name); 
  
    
    if (!mysqli_stmt_execute($stmt)) {
      $data = [
        "status" => 500,
        "message" => "Error executing query"
      ];
      http_response_code(500);
      return json_encode($data);
    }
  
    
    $result = mysqli_stmt_get_result($stmt);
    $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
  
    $data = [];
    if (mysqli_num_rows($result) > 0) {
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
  
    mysqli_stmt_close($stmt); 
    header('Content-Type: application/json; charset=utf-8');
    return json_encode($data);
  }
  

function createPost($data){
    global $conn;
   
    $title = mysqli_real_escape_string($conn, $data['post_title']);
    $content = mysqli_real_escape_string($conn, $data['post_text']);
    $author = mysqli_real_escape_string($conn, $data['post_author']);
    $category_name = mysqli_real_escape_string($conn, $data['post_category']);
   

    $tags = mysqli_real_escape_string($conn, $data['post_tags']);
    $date = date('Y-m-d'); 

    $comment_count = 0;

    if (isset($_FILES['post_image'])) {
        $image = $_FILES['post_image']['name'];
        $target = "../../uploads/" . basename($image);
        move_uploaded_file($_FILES['post_image']['tmp_name'], $target);
    } 

    $sql = "INSERT INTO posts (post_category, post_title, post_author, post_date, post_comment_number, post_image, post_text, post_tags) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssss", $category_name, $title, $author, $date, $comment_count, $image, $content,  $tags);

        if (mysqli_stmt_execute($stmt)) {
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

        mysqli_stmt_close($stmt);
    } else {
        $data = [
            "status" => 500,
            "message" => "Failed to prepare SQL statement"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
    }

    return json_encode($data);
}

function updatePost($data){

    global $conn;

    $post_id = $data['post_id'];
    $title = mysqli_real_escape_string($conn, $data['post_title']);
    $content = mysqli_real_escape_string($conn, $data['post_text']);
    $author = mysqli_real_escape_string($conn, $data['post_author']);
    $category_name = mysqli_real_escape_string($conn, $data['post_category']);
    $tags = mysqli_real_escape_string($conn, $data['post_tags']); 
    $post_date = date('Y-m-d');
    $post_comment_number=0;  

    if (isset($_FILES['post_image']) ) {
        $image = $_FILES['post_image']['name'];
        $target = "../../uploads/" . basename($image);
        move_uploaded_file($_FILES['post_image']['tmp_name'], $target);
    } else {
       
        $query = "SELECT post_image FROM posts WHERE post_id = $post_id";
        $query_run = mysqli_query($conn, $query);
        $res = mysqli_fetch_assoc($query_run);
        $image = $res['post_image'];
    }

    $sql = "UPDATE posts SET post_category = ?, post_title = ?, post_author = ?, post_date = ?, post_comment_number = ? , post_image = ?,post_text = ?, post_tags = ? WHERE post_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "ssssssssi", $category_name, $title, $author, $post_date , $post_comment_number , $image,$content, $tags, $post_id);

        if (mysqli_stmt_execute($stmt)) {
            $data = [
                "status" => 200,
                "message" => "Post updated successfully"
            ];
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(200);
            return json_encode($data);
        } else {
            $data = [
                "status" => 500,
                "message" => "Failed to update post"
            ];
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(500);
            return json_encode($data);
        }

        mysqli_stmt_close($stmt);
    } else {
        $data = [
            "status" => 500,
            "message" => "Failed to prepare SQL statement"
        ];
        header('Content-Type: application/json; charset=utf-8');
        http_response_code(500);
    }
    
}

function deletePost($post_id) {
    global $conn;
    
    if (!is_numeric($post_id)) {
      $data = [
        "status" => 400,
        "message" => "Invalid post ID. Please provide a numeric value."
      ];
      http_response_code(400); 
      return json_encode($data);
    }
  
    $stmt = mysqli_prepare($conn, "DELETE FROM posts WHERE post_id = ?");    
    mysqli_stmt_bind_param($stmt, "i", $post_id); 

    if (mysqli_stmt_execute($stmt)) {
      $affected_rows = mysqli_stmt_affected_rows($stmt);
      if ($affected_rows > 0) {
        $data = [
          "status" => 200,
          "message" => "Post deleted successfully"
        ];
      } else {
        $data = [
          "status" => 404,
          "message" => "Post not found"
        ];
      }
    } else {
      $error_message = mysqli_stmt_error($stmt);
      $data = [
        "status" => 500,
        "message" => "Failed to delete post: $error_message"
      ];
      
    }
  
    mysqli_stmt_close($stmt); 
  
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($data["status"]); 
    return json_encode($data);
  }
  

function getPostByCategory($category_id) {
    global $conn;

    $stmt = mysqli_prepare($conn, "SELECT * FROM posts WHERE post_category_id = ?");
    mysqli_stmt_bind_param($stmt, "i", $category_id); 

    if (mysqli_stmt_execute($stmt)) {
        $result = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($result) > 0) {
            $res = mysqli_fetch_all($result, MYSQLI_ASSOC);
            $data = [
                "status" => 200,
                "message" => "Post list fetched successfully",
                "data" => $res
            ];
        } else {
            $data = [
                "status" => 404,
                "message" => "No post found"
            ];
        }
    } else {
        $data = [
            "status" => 500,
            "message" => "Error executing query"
        ];
    }

    mysqli_stmt_close($stmt); 
    header('Content-Type: application/json; charset=utf-8');
    http_response_code($data["status"]); 
    return json_encode($data);
}



?>