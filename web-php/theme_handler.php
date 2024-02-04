<?php 
if (isset($_POST['theme'])) {
    $selectedTheme = $_POST['theme'];
    setcookie('selected_theme', $selectedTheme, time() + (86400 * 30), "/");
} elseif (isset($_COOKIE['selected_theme'])) {
    $selectedTheme = $_COOKIE['selected_theme'];
} else {
    $selectedTheme = 'light';
}
?>