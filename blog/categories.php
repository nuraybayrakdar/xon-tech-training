<?php include "include/admin_header.php";?>

   
<?php include "include/admin_sidebar.php";?>


                            <table class="table table-bordered" id="categoryTable">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Category Name</th>
                                        <th><button id="add_modal_btn" type="button" class="btn btn-primary" data-toggle="modal" data-target="#add_modal">Add New Category</button></th>
                                        
                                    </tr>
                                </thead>
                                <tbody id="categoryTable">

                                    <tr>
                                        <td>1</td>
                                        <td>Sample Category Name</td>
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
                            url: 'api/categories/read.php',
                            method: 'GET',
                            success: function(response){
                                console.log(response); 
                                var categories = JSON.parse(response);

                                if (categories.status === 200) {
                                    var tableContent = '';
                                    $.each(categories.data, function(index, category){
                                        console.log(category.category_id); 
                                        console.log(category.category_name); 

                                        tableContent += '<tr>';
                                        tableContent += '<td>' + category.category_id + '</td>';
                                        tableContent += '<td>' + category.category_name + '</td>';
                                        tableContent += '<td>';
                                        tableContent += '<button type="button" class="btn btn-primary editBtn" data-toggle="modal" data-target="#edit_modal">Edit</button>';
                                        tableContent += '<button ml-5 type="button" class="btn btn-danger deleteBtn">Delete</button>';
                                        tableContent += '</td>';
                                        tableContent += '</tr>';
                                    });
                                    $('#categoryTable tbody').html(tableContent); 
                                } else {
                                    console.error("Error fetching data:", categories.message);
                                }
                            },
                            error: function(xhr, status, error){
                                console.error(error); 
                            }
                        });
    
                    });

                    $(document).on('click', '.deleteBtn', function() {
                        var categoryId = $(this).closest('tr').find('td:first').text(); // Get the category ID from the row

                        if (confirm('Are you sure you want to delete this category?')) {
                            $.ajax({
                            url: 'api/categories/delete.php?category_id=' + categoryId,
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

                        $(document).on('click', '.editBtn', function() {
                        var categoryId = $(this).closest('tr').find('td:first').text(); // Get the category ID from the row
                        var categoryName = $(this).closest('tr').find('td:nth-child(2)').text(); // Get the category name from the row

                        $('#edit-modal-form input[name="category_id"]').val(categoryId);
                        $('#edit-modal-form input[name="category_name"]').val(categoryName);
                   
                        
                        

                    $('#edit-modal-form').submit(function(e) {
                        e.preventDefault();

                        var categoryId = $('#edit-modal-form input[name="category_id"]').val();
                        var categoryName = $('#edit-modal-form input[name="category_name"]').val();

                        $.ajax({
                            url: 'api/categories/update.php',
                            method: 'PUT',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                category_id: categoryId,
                                category_name: categoryName
                            }),
                            success: function(response) {
                                if (response.status === 200) {
                                    $('#edit_modal').modal('hide');
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
                    });
                }); 



                $(document).ready(function() {
                    $('#add_modal_btn').click(function() {
                        $('#add_modal input[name="category_name"]').val('');
                    });

                    $('#add_modal_form').submit(function(e) {
                        e.preventDefault();

                        var categoryName = $('#add_modal_form input[name="category_name"]').val();
                        console.log(categoryName);
                        $.ajax({
                            url: 'api/categories/create.php',
                            method: 'POST',
                            contentType: 'application/json',
                            data: JSON.stringify({
                                category_name: categoryName
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


                    <div id="edit_modal" class="modal fade">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form method="PUT" id="edit-modal-form">  <div class="form-group">
                                            <input value="" type="text" class="form-control" name="category_name">
                                        </div>
                                        <div class="form-group">
                                            <input type="hidden" name="category_id" value="">
                                            <input type="submit" class="btn btn-primary" value="Edit Category">  </div>
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
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="category_name">
                                        </div>
                                        <div class="form-group">
                                            <input type="submit" class="btn btn-primary" name="add_category" value="Add Category">
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