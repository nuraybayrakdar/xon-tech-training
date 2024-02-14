<?php

$servername = "localhost";
$user = "root";
$dbname = "web_dev_crud";

try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $user);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userId = $_POST['user_id'];
        $newUsername = $_POST['username'];
        $newEmail = $_POST['email'];

        $query = $connection->prepare("UPDATE users SET username = :username, email = :email WHERE id = :id");
        $query->bindParam(':id', $userId);
        $query->bindParam(':username', $newUsername);
        $query->bindParam(':email', $newEmail);
        $query->execute();

        echo "User updated successfully!";
        echo "<br>";
        echo "<a href='all-user.php'>Display All User</a>";
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null;
?>
