<?phpsession_start(); 

if(!isset($_SESSION["username"]) || empty($_SESSION["username"])) {
    header("Location: login.php");
    exit; 
}

?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Blog Home</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>

    </head>
    <body>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#!">Blog Site, Welcome <?php echo $_SESSION["username"]?></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="../login.php">Login</a></li>
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Blog</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page header with logo and tagline-->
        <header class="py-5 bg-light border-bottom mb-4">
            
        </header>
        <!-- Page content-->
        <div class="container" id="post-container">
            <div class="row">
                
                <div class="col-lg-8" id="post-content">
                    <div class="row">
                        <div class="col-lg-6">
                            
                        </div>
                        <div class="col-lg-6">
                        
                        </div>
                    </div>
                    
                    
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
                $.ajax({
                    url: '../api/posts/read.php',
                    method: 'GET',
                    success: function(response){
                        console.log(response); 

                        var posts = JSON.parse(response);

                        if (posts.status === 200) {
                            console.log(posts.data);    
                            
                            $.each(posts.data, function(index, post){
                               
                                var postCard = $('<div class="card mb-4"></div>');
                                var postImage = $('<a href="#!"><img class="card-img-top" src="../assets/' + post.post_image + '" width="100px" height="200px" alt="..." /></a>');
                                var postBody = $('<div class="card-body"></div>');
                                var postDate = $('<div class="small text-muted">' + post.post_date + '</div>');
                                var postCategory = $('<div class="small text-muted">' + post.post_category + '</div>');
                                var postTitle = $('<h2>' + post.post_title + '</h2>');
                                var postText = $('<p class="card-text">' + post.post_text + '</p>');
                                var readMore = $('<a class="btn btn-primary" href="post-detail.php/?post_id='+ post.post_id +'">Read more →</a>');

                               
                                postBody.append(postDate,postCategory,  postTitle, postText, readMore);
                                postCard.append(postImage, postBody);

                               
                                $('#post-content .row').append(postCard);
                            });
                        } else {
                            console.error("Error fetching data:", posts.message);
                        }
                    },
                    error: function(xhr, status, error){
                        console.error(error);
                    }
                });


                $.ajax({
                    url: '../api/categories/read.php', 
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
            });

        </script>

        <!-- Footer-->
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white"></p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
       
    </body>
</html>
