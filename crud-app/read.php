<?php
$servername = "localhost";
$user = "root";
$dbname = "web_dev_crud";


try {
    $connection = new PDO("mysql:host=$servername;dbname=$dbname", $user);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


    echo '<link rel="stylesheet" type="text/css" href="style.css">';
    
    $limit = 10; 
    $page = isset($_GET['page']) ? $_GET['page'] : 1;
    $offset = ($page - 1) * $limit;

    $query = $connection->prepare("SELECT * FROM users LIMIT :limit OFFSET :offset");
    $query->bindParam(':limit', $limit, PDO::PARAM_INT);
    $query->bindParam(':offset', $offset, PDO::PARAM_INT);
    $query->execute();
    $users = $query->fetchAll(PDO::FETCH_ASSOC);

    echo "<table border='1'>";
    
    echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Edit</th><th>Delete</th></tr>";
    foreach ($users as $user) {
        echo "<tr><td>{$user['id']}</td><td>{$user['username']}</td><td>{$user['email']}</td>
        <td><a href='#' class='edit-user' data-user-id='{$user['id']}'>Edit</a></td>
        <td><a href='#' class='delete-user' data-user-id='{$user['id']}'>Delete</a></td></tr>";
        

    }
    echo "</table>";

    $query = $connection->prepare("SELECT COUNT(*) as total FROM users");
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    $total_pages = ceil($result['total'] / $limit);

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='#' class='page-link' data-page='$i'>$i</a> ";
    }
    echo "</div>";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$connection = null;
?>
