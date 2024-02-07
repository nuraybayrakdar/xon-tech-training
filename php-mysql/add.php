<?php

if(isset($_POST['title'])){
    require 'connect_db.php';

    $title = $_POST['title'];

    if(empty($title)){
        header("Location: index.php");
    }else {
        $stmt = $conn->prepare("INSERT INTO todos(title) VALUE(?)");
        $res = $stmt->execute([$title]);

        if($res){
            header("Location: index.php"); 
            echo "success";
        }else {
            header("Location: index.php");
            echo "error";
        }
        $conn = null;
        exit();
    }
}else {
    header("Location: index.php");
}