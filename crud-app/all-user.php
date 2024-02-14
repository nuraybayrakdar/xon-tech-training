<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

</head>
<body>

    <div class="container">
        <h1>User List</h1>

        <div id="userList"></div>
        <div id="pagination"></div>
        <br>
        <a href='index.php'>Create New User</a>
        <script>
            $(document).ready(function () {
                function loadUsers(page) {
                    $.ajax({
                        url: 'read.php',
                        method: 'GET',
                        data: { page: page },
                        success: function (data) {
                            $('#userList').html(data);

                            $('.edit-user').on('click', function (event) {
                                event.preventDefault();
                                var userId = $(this).data('user-id');
                                window.location.href = 'edit-user.php?id=' + userId;
                            });

                            $('.delete-user').on('click', function (event) {
                                event.preventDefault();
                                var userId = $(this).data('user-id');
                                var confirmation = confirm('Are you sure you want to delete this user?');
                                if (confirmation) {
                                    $.ajax({
                                        url: 'delete.php',
                                        method: 'GET',
                                        data: { id: userId },
                                        success: function (response) {
                                            alert(response);
                                            loadUsers(1);
                                        }
                                    });
                                }
                            });
                        }
                    });
                }

                loadUsers(1);

                $(document).on('click', '.pagination a', function (event) {
                    event.preventDefault();
                    var page = $(this).data('page');
                    loadUsers(page);
                });
            });
        </script>
    </div>

</body>
</html>
