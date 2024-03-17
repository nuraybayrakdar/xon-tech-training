<?php include "include/admin_header.php";?>

<?php include "include/admin_sidebar.php";?>

                <table class="table table-bordered" id="postTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Post Title</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Date</th>
                            <th>Image</th>
                            <th>Comments</th>
                            <th>Text</th>
                            <th>Tags</th>
                            <th>Edit</th>
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
                        <form action="" method="PUT" id="edit_modal_form">
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
                                    <label for="post_comment">Post Comments</label>
                                    <input type="text" class="form-control" name="post_comment" required>
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
                            <form id="add_modal_form" action="" method="post" enctype="multipart/form-data">
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
$(document).ready(function(){
    $.ajax({
        url: 'api/posts/read_not_pagination.php',
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
                    tableContent += '<td>' + post.post_category + '</td>';
                    tableContent += '<td>' + post.post_author + '</td>';
                    tableContent += '<td>' + post.post_date + '</td>';
                    tableContent += '<td><img src="uploads/' + post.post_image + '" width="80px" height="80px"></td>';
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
        var formData = new FormData(this); 

        console.log(JSON.stringify(formData));
        $.ajax({
            url: 'api/posts/create.php',
            method: 'POST',
            contentType: false,
            processData: false,
            data: formData,
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



    $(document).on('click', '.editBtn', function() {
            var post_id = $(this).closest('tr').find('td:first').text();
            var post_title = $(this).closest('tr').find('td:nth-child(2)').text();
            var post_category = $(this).closest('tr').find('td:nth-child(3)').text();
            var post_author = $(this).closest('tr').find('td:nth-child(4)').text();
            var post_date = $(this).closest('tr').find('td:nth-child(5)').text();
            var post_image = $(this).closest('tr').find('td:nth-child(6)').text();
            var post_comments = $(this).closest('tr').find('td:nth-child(7)').text();
            var post_text = $(this).closest('tr').find('td:nth-child(8)').text();
            var post_tags = $(this).closest('tr').find('td:nth-child(9)').text();

            console.log('Editing post with ID:', post_id);

            $('#edit_modal').modal('show');
            $('#edit_modal').find('input[name="post_id"]').val(post_id);
            $('#edit_modal').find('input[name="post_title"]').val(post_title);
            $('#edit_modal').find('input[name="post_category"]').val(post_category);
            $('#edit_modal').find('input[name="post_author"]').val(post_author);
            $('#edit_modal').find('input[name="post_date"]').val(post_date);
            $('#edit_modal').find('input[name="post_image"]').val(post_image);
            $('#edit_modal').find('input[name="post_comment"]').val(post_comments);
            $('#edit_modal').find('textarea[name="post_text"]').val(post_text);
            $('#edit_modal').find('input[name="post_tags"]').val(post_tags);
        

        $('#edit_modal_form').on('submit', function(e) {
            e.preventDefault();

            var user_id = $('#edit_modal').find('input[name="post_id"]').val();
            var post_title = $('#edit_modal').find('input[name="post_title"]').val();
            var post_category = $('#edit_modal').find('input[name="post_category"]').val();
            var post_author = $('#edit_modal').find('input[name="post_author"]').val();
            var post_date = $('#edit_modal').find('input[name="post_date"]').val();
            var post_image = $('#edit_modal').find('input[name="post_image"]').val();
            var post_comments = $('#edit_modal').find('input[name="post_comment"]').val();
            var post_text = $('#edit_modal').find('textarea[name="post_text"]').val();
            var post_tags = $('#edit_modal').find('input[name="post_tags"]').val();



            $.ajax({
                url: 'api/posts/update.php',
                method: 'PUT',
                contentType: 'application/json',
                data: JSON.stringify(
                    {
                        post_id: post_id,
                        post_title: post_title,
                        post_category: post_category,
                        post_author: post_author,
                        post_date: post_date,
                        post_image: post_image,
                        post_comments: post_comments,
                        post_text: post_text,
                        post_tags: post_tags
                    }
                ),
                
                success: function(response) {
                    console.log(response);
                   
                    if (response.status === 200) {
                        console.log(response);
                        $('#edit_modal').modal('hide');
                        window.location.reload();
                    } else {
                        alert(post.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
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