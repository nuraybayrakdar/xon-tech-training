<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Post Details</title>
        
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <link href="../css/styles.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
    </head>
    <body>
        
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="../index.php">Blog Site</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="../index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="../../login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Blog</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-8">
                    
                    <article>
                        
                        <header class="mb-4">
                            
                            <h1 class="fw-bolder mb-1" id="post-title"></h1>
                            
                            <div class="text-muted fst-italic mb-2" id="post-date" ></div>
                            
                            <a class="badge bg-secondary text-decoration-none link-light" id="post-category" href="#!"></a>
                        </header>
                        
                        <figure class="mb-4" id="post-image" ></figure>
                        
                        <section class="mb-5" id="post-details">
                        </section>
                    </article>
                    
                    <section class="mb-5">
                        <div class="card bg-light">


                            <div class="card-body" id="comment-add">
                                
                            <form id="comment-form" class="mb-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" id="comment_author" name="comment_author"
                                            placeholder="Your Name" required>
                                            <input type="text" class="form-control" id="comment_email" name="comment_email"
                                            placeholder="Your email" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <textarea class="form-control" id="comment_text" name="comment_text" rows="3"
                                            placeholder="Leave your comment..." required></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Comment</button>
                            </form>
                            <div class="card-body" id="comment-body">
                                
                                <form class="mb-4"><textarea class="form-control" rows="3" placeholder="Join the discussion and leave a comment!"></textarea></form>
                                
                                <div class="d-flex">
                                    
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold" id="comment_author"></div>
                                        
                                    </div>
                                </div>
                                
                                <div class="d-flex">
                                    <div class="flex-shrink-0"><img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." /></div>
                                    <div class="ms-3">
                                        <div class="fw-bold"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
               
                <div class="col-lg-4">
                    
                    
                    <div class="card mb-4">
                        <div class="card-header">Categories</div>
                        <div class="card-body" id="category-list">
                            <div class="row">
                               
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>

        <script>
           $(document).ready(function(){
                const urlParams = new URLSearchParams(window.location.search);
                const post_id = urlParams.get('post_id');

                // Yorum yapma formunu işle
                $('#comment-form').submit(function(event) {
                    event.preventDefault();

                    var commenterName = $('#comment_author').val();
                    var comenterEmail = $('#comment_email').val();
                    var commentContent = $('#comment_text').val();

                    $.ajax({
                        url: '../../api/comments/create.php',
                        method: 'POST',

                        data: {
                            comment_post_id: post_id,
                            comment_author: commenterName,
                            comment_text: commentContent
                        },
                        success: function(response) {
                            console.log(response);
                            location.reload();


                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                });

                $.ajax({
                    url: "../../api/posts/read.php?post_id=" + post_id,
                    type: 'GET',
                    dataType: 'json', 
                    success: function(data) {
                        console.log(data);
                        data = JSON.parse(data); 
                        document.getElementById('post-title').innerHTML = data.data.post_title; 
                        document.getElementById('post-date').innerHTML = `Posted on ${data.data.post_date} by ${data.data.post_author}`;
                        document.getElementById('post-category').innerHTML = data.data.post_category;
                        document.getElementById('post-image').innerHTML = `<img class="img-fluid rounded" src="../../assets/${data.data.post_image}" alt="..." />`;
                        document.getElementById('post-details').innerHTML = data.data.post_text;
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr.responseText);
                        
                    }
                });

                $.ajax({
                    url: '../../api/categories/read.php',
                    method: 'GET',
                    success: function(response) {
                        console.log(response);

                        var categories = JSON.parse(response);

                        if (categories.status === 200) {
                            var categoryList = $('#category-list');
                            categoryList.empty(); 

                            $.each(categories.data, function(index, category) {
                                var categoryItem = $('<li><a href="#">' + category.category_name + '</a></li>');
                                categoryList.append(categoryItem);
                            });
                        } else {
                            console.error("Error fetching categories:", categories.message);
                            
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                       
                    }
                });

                $.ajax({
                        url: "../../api/comments/read.php?post_id=" + post_id,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            var comments = JSON.parse(response);

                            if (comments.status === 200) {
                                var commentList = $('#comment-body'); 

                                commentList.empty(); 

                                $.each(comments.data, function(index, comment) {
                                    var commentItem = $('<div class="d-flex mb-4">' +
                                                            '<div class="flex-shrink-0">' +
                                                                '<img class="rounded-circle" src="https://dummyimage.com/50x50/ced4da/6c757d.jpg" alt="..." />' +
                                                            '</div>' +
                                                            '<div class="ms-3">' +
                                                                '<div class="fw-bold">' + comment.comment_author + '</div>' +
                                                                comment.comment_text +
                                                            '</div>' +
                                                        '</div>');

                                    commentList.append(commentItem);
                                });
                            } else {
                                console.error("Error fetching comments:", comments.message);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });

                
            
            
            
            
            
            
            
                });

            
        </script>

        
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">/p></div>
        </footer>
        
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        
        <script src="../js/scripts.js"></script>
    </body>
</html>
