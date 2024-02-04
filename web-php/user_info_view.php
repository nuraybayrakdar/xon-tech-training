<?php
require_once 'theme_handler.php';
session_start();

$fullname = isset($_SESSION['fullname']) ? $_SESSION['fullname'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$age = isset($_SESSION['age']) ? $_SESSION['age'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Information</title>
    <link rel="stylesheet"href="css/<?php echo $selectedTheme; ?>_theme.css">
</head>
<body>

<div class="container">
    <h2>User Information</h2>
    <p><strong>Full Name:</strong> <?php echo $fullname; ?></p>
    <p><strong>Email:</strong> <?php echo $email; ?></p>
    <p><strong>Age:</strong> <?php echo $age; ?></p>
    <input type="submit" name="submit" value="Logout" onclick="location.href='logout.php';">
</div>

</body>
</html>
