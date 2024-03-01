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
                <table class="table table-bordered" id="postTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Delete</th>
                            <th>Post Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Comments</th>
                            <th>Image</th>
                            <th>Text</th>
                            <th>Tags</th>
                            <th><button id="add_modal_btn" type="button" class="btn btn-primary addBtn" data-toggle="modal" data-target="#add_modal">Add New Post</button></th>
                        </tr>
                    </thead>
                    <tbody id="postTableBody">
                        <tr>
                            <td><button type="button" class="btn btn-danger deleteBtn">Delete</button></td>
                            <td>Sample Post Title</td>
                            <td>Sample Category</td>
                            <td>Sample Author</td>
                            <td>Sample Date</td>
                            <td>Sample Image</td>
                            <td>Sample Comments</td>
                            <td>Sample Image</td>
                            <td>Sample Text</td>
                            <td>Sample Tags</td>
                            <td><button type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#edit_modal">Edit</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Edit Modal -->
        <div id="edit_modal" class="modal fade">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Portfolio</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post">
                            <div class="form-group">
                                <label for="post_title">Post Title</label>
                                <input type="text" class="form-control" name="post_title">
                            </div>
                            <div class="form-group">
                                <label for="post_category">Post Category</label>
                                <input type="text" class="form-control" name="post_category">
                            </div>
                            <div class="form-group">
                                <label for="post_author">Post Author</label>
                                <input type="text" class="form-control" name="post_author">
                            </div>
                            <div class="form-group">
                                <label for="post_image">Post Image</label>
                                <input type="file" class="form-control" name="post_image">
                            </div>
                            <div class="form-group">
                                <label for="post_tags">Post Tags</label>
                                <input type="text" class="form-control" name="post_tags">
                            </div>
                            <div class="form-group">
                                <label for="post_text">Post Text</label>
                                <textarea class="form-control" name="post_text" id="" cols="20" rows="5"></textarea>
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="edit_post" value="Edit Post">
                        </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <!-- Add Modal -->
        <div id="add_modal" class="modal fade">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Add New Post</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body" id="add_modal_body">
                            <form id="add_modal_form" action="" method="post">
                                <div class="form-group" id="add_modal_form_group">
                                    <label for="post_title">Post Title</label>
                                    <input type="text" class="form-control" name="post_title" required>
                                </div>
                                <div class="form-group">
                                    <label for="post_category">Post Category</label>
                                    <input type="text" class="form-control" name="post_category" required>
                                </div>
                                <div class="form-group">
                                    <label for="post_author">Post Author</label>
                                    <input type="text" class="form-control" name="post_author" required>
                                </div>
                                <div class="form-group">
                                    <label for="post_image">Post Image</label>
                                    <input type="file" class="form-control" name="post_image" required>
                                </div>
                                <div class="form-group">
                                    <label for="post_tags">Post Tags</label>
                                    <input type="text" class="form-control" name="post_tags" required>
                                </div>
                                <div class="form-group">
                                    <label for="post_text">Post Text</label>
                                    <textarea class="form-control" name="post_text" id="" cols="20" rows="5"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-primary" name="add_post" value="Add Post">
                                </div>
                            </form>
                        </div>
                    </div>
            
        </div>
        <script>
                $  (document).ready(function(){
                       $.ajax({
                        url: 'api/posts/read.php',
                        method: 'GET',
                        success: function(response){
                            console.log(response); 
                            var posts = JSON.parse(response);
                
                            if (posts.status === 200) {
                                var tableContent = '';
                                $.each(posts.data, function(index, post){
                                    console.log(post.post_id); 
                                    console.log(post.post_title); 
                                    console.log(post.post_category); 
                                    console.log(post.post_author); 
                                    console.log(post.post_date); 
                                    console.log(post.post_image); 
                                    console.log(post.post_comments); 
                                    console.log(post.post_text); 
                                    console.log(post.post_tags); 
                
                                    tableContent += '<tr>';
                                    tableContent += '<td>' + post.post_id + '</td>';
                                    tableContent += '<td>' + post.post_title + '</td>';
                                    tableContent += '<td>' + post.post_category_id + '</td>';
                                    tableContent += '<td>' + post.post_author + '</td>';
                                    tableContent += '<td>' + post.post_date + '</td>';
                                    tableContent += '<td>' + post.post_image + '</td>';
                                    tableContent += '<td>' + post.post_comment_number + '</td>';
                                    tableContent += '<td>' + post.post_text + '</td>';
                                    tableContent += '<td>' + post.post_tags + '</td>';
                                    tableContent += '<td>';
                                    tableContent += '<button type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#edit_modal">Edit</button>';
                                    tableContent += '<button ml-5 type="button" class="btn btn-danger deleteBtn">Delete</button>';
                                    tableContent += '</td>';
                
                                    tableContent += '</tr>';
                                });
                                $('#postTable tbody').html(tableContent); 
                            } else {
                                console.error("Error fetching data:", posts.message);
                            }
                        },
                        error: function(xhr, status, error){
                            console.error(error); 
                        }
                    });
                
                
                    $(document).on('click', '.deleteBtn', function() {
                    var post_id = $(this).closest('tr').find('td:first').text();
                
                    if (confirm('Are you sure you want to delete this post?')) {
                        console.log('Deleting post with ID:', post_id);
                        $.ajax({
                        url: 'api/posts/delete.php?post_id=' + post_id,
                        method: 'DELETE',
                        success: function(response) {
                            if (response.status === 200) {
                            alert(response.message);
                            $('#postTable tbody').find('tr[data-post-id="' + post_id + '"]').remove(); 
                            
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
                        
                        const formData = {
                            post_title: $('#add_modal_form input[name="post_title"]').val(),
                            post_category_id: $('#add_modal_form input[name="post_category"]').val(),
                            post_author: $('#add_modal_form input[name="post_author"]').val(),
                            post_image: $('#add_modal_form input[name="post_image"]').val(),
                            post_tags: $('#add_modal_form input[name="post_tags"]').val(),
                            post_text: $('#add_modal_form textarea[name="post_text"]').val()

                            };

                        console.log(formData);
                        $.ajax({
                            url: 'api/posts/create.php',
                            method: 'POST',
                            data: JSON.stringify(formData),
                           
                            success: function(response){
                                console.log(response);
                                if (response.status === 201) {
                                    
                                   console.log(response);
                                    $('#add_modal').modal('hide');
                                    window.location.reload();
                                } else {
                                    alert(response.message);
                                }
                            },
                            error: function(xhr, status, error){
                                console.error(error);
                            }
                        });
                    });
                
                   });
                  
        </script>

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