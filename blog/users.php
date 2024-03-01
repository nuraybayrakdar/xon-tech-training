<?php include "include/admin_header.php";?>
   
<?php include "include/admin_sidebar.php";?>
        

<div id="layoutSidenav_content">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 
                    <main>
                    <div id="content-wrapper">
                        <div class="container-fluid">
                            <h1>Welcome to Admin Page</h1>
                            <hr>
                            <table class="table table-bordered" id="userTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th> User Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Password</th>
                                        <th>Action</th> 
                                        <th><button id="add_modal_btn" type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#add_modal">Add New User</button></th>
                                        
                                    </tr>
                                </thead>

                                <tbody id="userTable">

                                    <tr>
                                        <td>1</td>
                                        <td>User Name</td>
                                        <td>Email</td>
                                        <td>Role</td>
                                        <td>Password</td>
                                        <td>
                                            <button type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#edit_modal">Edit</button>
                                            <button ml-5 type="button" class="btn btn-danger deleteBtn">Delete</button>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script>

                        $(document).ready(function(){
                            $.ajax({
                        url: 'api/users/read.php',
                        method: 'GET',
                        success: function(response){
                            console.log(response); 
                            var users = JSON.parse(response);
                
                            if (users.status === 200) {
                                var tableContent = '';
                                $.each(users.data, function(index, user){
                                    console.log(user.user_id); 
                                    console.log(user.user_name); 
                                    console.log(user.user_email); 
                                    console.log(user.user_role); 
                                    console.log(user.user_password); 
                                
                
                                    tableContent += '<tr>';
                                    tableContent += '<td>' + user.user_id + '</td>';
                                    tableContent += '<td>' + user.user_name+ '</td>';
                                    tableContent += '<td>' + user.user_email + '</td>';
                                    tableContent += '<td>' + user.user_password + '</td>';
                                    tableContent += '<td>' + user.user_role + '</td>';
                                    tableContent += '<td>';
                                    tableContent += '<button type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#edit_modal">Edit</button>';
                                    tableContent += '<button ml-5 type="button" class="btn btn-danger deleteBtn">Delete</button>';
                                    tableContent += '</td>';
                
                                    tableContent += '</tr>';
                                });
                                $('#userTable tbody').html(tableContent); 
                            } else {
                                console.error("Error fetching data:", users.message);
                            }
                        },
                        error: function(xhr, status, error){
                            console.error(error); 
                        }
                    });

                            $(document).on('click', '.deleteBtn', function() {
                            var user_id = $(this).closest('tr').find('td:first').text();
                        
                            if (confirm('Are you sure you want to delete this post?')) {
                                console.log('Deleting user with ID:', user_id);
                                $.ajax({
                                url: 'api/users/delete.php?user_id=' + user_id,
                                method: 'DELETE',
                                success: function(response) {
                                    if (response.status === 200) {
                                    alert(response.message);
                                    $('#userTable tbody').find('tr[data-user-id="' + user_id + '"]').remove(); 
                                    
                                    window.location.reload();
                                    } else {
                                    alert(response.message);
                                    }
                                },
                                error: function() {
                                    alert('Something went wrong. Please try again.');
                                }
                                });
                            }
                            });



                           
                    $('#add_modal_btn').on('click', function(){
                        $('#add_modal').modal('show');
                        $('#add_modal_form').trigger('reset');
                    });
                
                    
                    $('#add_modal_form').on('submit', function(e){
                        e.preventDefault();
                        
                       
                            var user_name = $('#add_modal_form input[name="user_name"]').val();
                            var user_email = $('#add_modal_form input[name="user_email"]').val();
                            var user_password = $('#add_modal_form input[name="user_password"]').val();
                            var user_role = $('#add_modal_form input[name="user_role"]').val();
                           
                        $.ajax({
                            url: 'api/users/create.php',
                            method: 'POST',
                            data: JSON.stringify(
                                {
                                    user_name: user_name,
                                    user_email: user_email,
                                    user_password: user_password,
                                    user_role: user_role
                                }
                            ),

                           
                            success: function(response){
                                console.log(response);
                                if (response.status === 201) {
                                    
                                   console.log(response);
                                    $('#add_modal').modal('hide');
                                    window.location.reload();
                                } else {
                                    console.error('Error creating user:', response.message);
                                }
                            },
                            error: function(xhr, status, error){
                                console.error(error);
                            }
                        });
                    });

                            
                            $('.editBtn').on('click', function(){
                                $('#edit_modal').modal('show');

                                $tr = $(this).closest('tr');
                                var data = $tr.children("td").map(function(){
                                    return $(this).text();
                                }).get();

                                console.log(data);

                                $('#user_id').val(data[0]);
                                $('#user_name').val(data[1]);
                                $('#email').val(data[2]);
                                $('#role').val(data[3]);
                                $('#password').val(data[4]);
                            });

                            $('#edit-modal-form').on('submit', function(e){
                                e.preventDefault();
                                var id = $('#user_id').val();
                                $.ajax({
                                    type: 'PUT',
                                    url: 'edit_user.php' + id,
                                    data: $('#edit-modal-form').serialize(),
                                    success: function(response){
                                        $('#edit_modal').modal('hide');
                                        alert('Data Updated');
                                    }
                                });
                            });

                            

                        });

                    </script>


                    <div id="edit_modal" class="modal fade">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit User</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="PUT" id="edit-modal-form">  
                                        <div class="form-group">
                                            <input value="" type="text" class="form-control" name="user_name">
                                        </div>
                                        <div class="form-group">
                                            <input value="" type="email" class="form-control" name="email">
                                        </div>
                                        
                                        <div class="form-group">
                                            <input value="" type="password" class="form-control" name="password">
                                        </div>

                                        <div class="form-group">
                                        <select name="user_role" class="form-group">
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                        </div>

                                        
 
                                        <div class="form-group">
                                            <input type="hidden" name="user_id" value="">
                                            <input type="submit" class="btn btn-primary" value="Edit User">  
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                     <!-- Add Modal -->
                    <div id="add_modal" class="modal fade">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="add_modal_form">
                                        <div class="form-group">Username

                                            <input type="text" class="form-control" name="user_name"> 
                                        </div>
                                        <div class="form-group"> Email
                                            <input type="text" class="form-control" name="user_email">
                                        </div>
                                        <div class="form-group">Role
                                            <input type="text" class="form-control" name="user_role"> 
                                        </div>
                                        <div class="form-group"> Password
                                            <input type="password" class="form-control" name="user_password"> 
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" name="add_user" value="Add User">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                </main>
 
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Blog Website 2023</div>
                            
                        </div>
                    </div>
                </footer>
            </div>



        </div>
        

    </body>
</html>