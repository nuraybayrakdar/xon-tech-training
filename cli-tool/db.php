<?php


function connect() {
    $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("Database connection error: " . mysqli_connect_error());
    }
    return $conn;
}

function query($sql) {
    $conn = connect();
    $result = mysqli_query($conn, $sql);
    mysqli_close($conn);
    return $result;
}
?>
