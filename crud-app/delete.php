<?php

$servername = "localhost";
$user = "root";
$dbname = "web_dev_crud";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $user);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $userId = isset($_GET['id']) ? $_GET['id'] : null;

        if ($userId !== null) {
            $query = $connection->prepare("DELETE FROM users WHERE id = :id");
            $query->bindParam(':id', $userId);
            $query->execute();

            echo "User deleted successfully!";
        } else {
            echo "Invalid user ID!";
        }
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null;
?>
