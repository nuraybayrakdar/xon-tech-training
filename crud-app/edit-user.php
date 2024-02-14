<?php

$servername = "localhost";
$user = "root";
$dbname = "web_dev_crud";

include 'update.php';


try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $user);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $userId = $_GET['id'];
        $query = $connection->prepare("SELECT * FROM users WHERE id = :id");
        $query->bindParam(':id', $userId);
        $query->execute();
        $user = $query->fetch(PDO::FETCH_ASSOC);

        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Edit User</title>
            <link rel="stylesheet" href="style.css">
        </head>
        <body>
            <div class="container">
            <h2>Edit User</h2>
            <form action="update.php" method="post">
                <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
                <label for="username">Username:</label>
                <input type="text" name="username" value="<?= $user['username'] ?>"><br>
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?= $user['email'] ?>"><br>
                <input type="submit" value="Save">
            </form>
 
            </div>
            
        </body>
        </html>
        <?php
    }
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null;
?>
