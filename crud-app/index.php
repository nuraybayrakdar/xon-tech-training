<?php
  require "create.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Create New User</title>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
    <div class="container">
        <h2>Create New User</h2>
        <form id="createUserForm" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username">

            <label for="email">Email:</label>
            <input type="email" id="email" name="email">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password">

            <input type="submit" value="Create User">
        </form>
         <a href="all-user.php">Display All User</a>
        <div id="resultMessage"></div>

        <script>
           $(document).ready(function() {
               $('#createUserForm').submit(function(event) {
                  event.preventDefault();
                  var formData = $(this).serialize();
                  $.ajax({
                    type: 'POST',
                    url: 'create.php',
                    data: formData,
                    success: function(response) {
                        $('#resultMessage').html(response);
                    }
                  })
               });
           });
        </script>

    </div>
 
</body>
</html>
