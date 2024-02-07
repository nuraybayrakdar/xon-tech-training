<?php

$servername = "localhost";
$username = "root";
$dbname = "todo_list";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username,);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Bağlantı hatası: " . $e->getMessage();
}
?>
