<?php
$fullname = $email = $age = $message = '';
$nameErr = $emailErr = $ageErr = '';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    if (empty($_POST["name"])) {
        $nameErr = "Name is required";
    } else {
        $fullname = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z ]*$/",$fullname)) {
            $nameErr = "Only letters allowed";
        }
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required";
    } else {
        $email = test_input($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format";
        }
    }

    if (empty($_POST["age"])) {
        $ageErr = "Age is required";
    } else {
        $age = test_input($_POST["age"]);
        if (!filter_var($age, FILTER_VALIDATE_INT) || $age <= 0) {
            $ageErr = "Age must be a positive integer";
        }
    }

    if (empty($nameErr) && empty($emailErr) && empty($ageErr)) {
        $message = "Form submitted successfully!";
    } else {
        $message .= "<br>" . $nameErr;
        $message .= "<br>" . $emailErr;
        $message .= "<br>" . $ageErr;
    }
}

function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>
