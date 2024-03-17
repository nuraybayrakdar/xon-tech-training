<?php  
    session_start();
    if (isset($_SESSION['username'])) {
        if ($_SESSION['role'] !== 'admin') {
            header("Location: ui/index.php");
           
        }
        
    }

    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Login</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        
    </head>
    <body class="bg-info">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
                                    <div class="card-body">
                                        <form method="POST" id="loginForm" >
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="user_name" name="user_name" type="text" placeholder="admin" />
                                                <label for="user_name"> User Name</label>
                                            </div>
                                            <div class="form-floating mb-3">
                                                <input class="form-control" id="user_password" name="user_password" type="password" placeholder="Password" />
                                                <label for="user_password">Password</label>
                                            </div>
                                            
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary btn-block bg-info" name="login" type="submit" > Login</button>
                                            </div>
                                        </form>
                                    </div>
                    
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script>
        
        $(document).ready(function() {
            $('#loginForm').submit(function() {
                event.preventDefault();
                var user_name = $('#user_name').val();
                var user_password = $('#user_password').val();

                $.ajax({
                    url: 'api/users/login_user.php',
                    type: 'POST',
                    data: {
                        user_name: user_name,
                        user_password: user_password
                    },
                    success: function(response) {
                        response = JSON.parse(response);
                        console.log(response);
                        if (response.status == 200) {
                            console.log(response.message);

                            window.location.href = 'index.php';
                        } else {
                            console.log(response.message);
                            alert(response.message);
                        }
                    }
                });
            });
        });

        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
