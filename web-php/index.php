<?php 

require_once('form_validator.php'); 
require_once('theme_handler.php');

if(isset($_POST['submit']) && empty($nameErr) && empty($emailErr) && empty($ageErr)) {
    $_SESSION['fullname'] = $fullname;
    $_SESSION['email'] = $email;
    $_SESSION['age'] = $age;
    
    header("Location: user_info_view.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Validation</title>
    <link rel="stylesheet" href="css/<?php echo $selectedTheme; ?>_theme.css">
</head>
<body>

<div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="theme">Select Theme:</label>
        <select name="theme" id="theme">
            <option value="light" <?php if ($selectedTheme == 'light') echo 'selected'; ?>>Light</option>
            <option value="dark" <?php if ($selectedTheme == 'dark') echo 'selected'; ?>>Dark</option>
        </select>
        <br><br>
        <input type="submit" name="submit_theme" class="save-btn" value="Save Theme">
    </form>
</div>

<div class="container">
    <h2>Form Handling and Validation</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="name">Full Name:</label>
        <input type="text" id="name" name="name" required>
        <br><br>
        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" required>
        <br><br>
        <label for="age">Age:</label>
        <input type="number" id="age" name="age" required>
        <br><br>
        <label>Gender:</label>
        <input type="radio" id="female" name="gender" value="female" required>
        <label for="female">Female</label>
        <input type="radio" id="male" name="gender" value="male" required>
        <label for="male">Male</label>
        <br><br>
        <input type="submit" name="submit" value="Submit">
        <br><br>
    </form>

    <h3><?php echo $message; ?></h3>
</div>

<?php
if(isset($_SESSION['username'])) {
    echo "<div class='container'>";
    echo "<h2>Welcome, " . $_SESSION['username'] . "!</h2>";
    echo "</div>";
}
?>

</body>
</html>
