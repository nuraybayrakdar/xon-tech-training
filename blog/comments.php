<?php include "include/admin_header.php";?>

   
<?php include "include/admin_sidebar.php";?>


                            <table class="table table-bordered" id="commentTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Post ID</th>
                                        <th>Author</th>
                                        <th>Date</th>
                                        <th>Comment</th> 
                                        <th><button id="add_modal_btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add New Comment</button></th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="commentTable">
                                    <tr>
                                        <td>1</td>
                                        <td>Sample Comment Name</td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <script>
                    $(document).ready(function(){
                        $.ajax({
                            url: 'api/comments/read.php',
                            method: 'GET',
                            success: function(response){
                                console.log(response); 
                                var comments = JSON.parse(response);

                                if (comments.status === 200) {
                                    var tableContent = '';
                                    $.each(comments.data, function(index, comments){
                                        console.log(comments.comment_id); 
                                        console.log(comments.comment_post_id);
                                        console.log(comments.comment_author);
                                        console.log(comments.comment_date); 

                                        tableContent += '<tr>';
                                        tableContent += '<td>' + comments.comment_id + '</td>';
                                        tableContent += '<td>' + comments.comment_post_id + '</td>';
                                        tableContent += '<td>' + comments.comment_author + '</td>';
                                        tableContent += '<td>' + comments.comment_date + '</td>';
                                        tableContent += '<td>' + comments.comment_text + '</td>';
                                        tableContent += '<td>';
                                        tableContent += '<button ml-5 type="button" class="btn btn-danger deleteBtn">Delete</button>';
                                        tableContent += '</td>';
                                        tableContent += '</tr>';
                                    });
                                    $('#commentTable tbody').html(tableContent); 
                                } else {
                                    console.error("Error fetching data:", comments.message);
                                }
                            },
                            error: function(xhr, status, error){
                                console.error(error); 
                            }
                        });
    
                    });

                    $(document).on('click', '.deleteBtn', function() {
                        var comment_id = $(this).closest('tr').find('td:first').text();

                        if (confirm('Are you sure you want to delete this comment?')) {
                            $.ajax({
                            url: 'api/comments/delete.php?comment_id=' + comment_id,
                            method: 'DELETE',
                            success: function(response) {
                                if (response.status === 200) {
                                alert(response.message);
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




                $(document).ready(function() {
                    $('#add_modal_btn').click(function() {
                        $('#add_modal input[name="comment_text"]').val('');
                    });

                    $('#add_modal_form').submit(function(e) {
                        e.preventDefault();

                        var comment_text = $('#add_modal_form input[name="comment_text"]').val();
                        var comment_author = $('#add_modal_form input[name="comment_author"]').val();
                        var comment_email = $('#add_modal_form input[name="comment_email"]').val();
                        var comment_date = $('#add_modal_form input[name="comment_date"]').val();
                        var comment_post_id = $('#add_modal_form input[name="comment_post_id"]').val();
                        console.log(comment_text);
                        $.ajax({
                            url: 'api/comments/create.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                comment_text: comment_text
                            }),
                            success: function(response) {
                                if (response.status === 201) {
                                    $('#add_modal').modal('hide');
                                    console.log(response);
                                    window.location.reload();
                                    
                                } else {
                                    console.log(response);
                                    alert(response.message);
                                }
                            },
                            error: function() {
                                alert('Something went wrong. Please try again.');
                            }
                        });
                    });
                });

                        
                </script>

                    <div id="add_modal" class="modal fade">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add New Comment</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="post" id="add_modal_form">
                                        <div class="form-group">
                                            <label for="comment_text">Comment</label>
                                            <input type="text" class="form-control" name="comment_text">
                                        </div>
                                        <div class="form-group">
                                            <label for="comment_post_id">Post ID</label>
                                            <input type="text" class="form-control" name="comment_post_id">
                                        </div>

                                        <div class="form-group">
                                            <label for="comment_author">Author</label>
                                            <input type="text" class="form-control" name="comment_author">
                                        </div>
                                        <div class="form-group">
                                            <label for="comment_email">Email</label>
                                            <input type="text" class="form-control" name="comment_email">
                                        </div>
                                        <div class="form-group">
                                            <label for="comment_date">Date</label>
                                            <input type="text" class="form-control" name="comment_date">
                                        </div>

                                       
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" name="add_comment" value="Add New Comment">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        
                </main>
 
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted"></div>
                            
                        </div>
                    </div>
                </footer>
            </div>



        </div>
        

    </body>
</html>