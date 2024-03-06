<?php
$name = $_POST['name'];
$email = $_POST['email'];
$comment = $_POST['comment'];

$servername = "localhost";
$username = "root";
$password = "bayrakdar37";
$dbname = "optimization";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
     
    //    $sql = "INSERT INTO comments (name, email, comment) VALUES ('$name', '$email', '$comment')";
    //    SQL injecitondan kaçınmak için sorguyu bu şekilde kullanmadık. Parameterized query kullandık.
    
    $sql = "INSERT INTO comments (name, email, comment) VALUES (:name, :email, :comment)";
    $stmt = $conn->prepare($sql);

    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':comment', $comment);

    
    $stmt->execute();

    echo "New record created successfully";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}


$conn = null;
?>
