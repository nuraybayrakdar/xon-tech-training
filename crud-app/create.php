<?php

$servername = "localhost";
$user = "root";
$dbname = "web_dev_crud";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $user);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 

        $sql = "INSERT INTO users (username, email, password) VALUES (:username, :email, :password)";
        $query = $connection->prepare($sql);

        $query->bindParam(':username', $username);
        $query->bindParam(':email', $email);
        $query->bindParam(':password', $password_hash);

        $query->execute();

        echo "User created successfully! ";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null;

?>
