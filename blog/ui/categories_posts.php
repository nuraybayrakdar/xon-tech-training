<?php session_start(); 

if(isset($_SESSION["username"]) && !empty($_SESSION["username"])) {
    $username = $_SESSION["username"];
    $welcomeMessage = "Welcome, $username! Let's read something.";
} else {
    $welcomeMessage = "Welcome! Let's read something.";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Blogia</title>
    <link href="css/styles.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand text-info fw-bold" href="index.php">Blogia</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="container" style="padding: 20px; text-align: center;">
            <div class="welcome-message bg-info text-dark" style="font-family: Arial, sans-serif; font-size: 16px; color: #fff; padding: 10px; background-color: #ffc107; border-radius: 5px; display: inline-block;">
                <?php echo $welcomeMessage; ?>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            <li class="nav-item">
            <a class="nav-link text-light fw-bold" href="index.php">Home</a>
            </li>
            <li class="nav-item">
            <a class="nav-link active text-info fw-bold" aria-current="page" href="#">Blog</a>
            </li>
            <li class="nav-item">
            <?php if(isset($_SESSION["username"]) && !empty($_SESSION["username"])): ?>
                    <form id="logoutForm" action="../logout.php" method="post">
                        <button type="submit" class="btn text-light fw-bold btn-transparent" name="logout">Logout</button>
                    </form>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="../login.php">Login</a></li>
                <?php endif; ?>
            </li>
        </ul>
</div>
    </div>
</nav>
<!-- Page header with logo and tagline-->
<header class="bg-light border-bottom mb-4">

</header>
<!-- Page content-->
<div class="container" id="post-container">
    <div class="row">

        <div class="col-lg-8" id="post-content">
            <!-- Post area -->
        </div>

    </div>
</div>

<div id="pagination" class="d-flex justify-content-center mt-4 bg-info"></div>

<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white"></p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.6.3.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
        $(document).ready(function(){
            var currentPage = 1;
            var postsPerPage = 2;
            const urlParams = new URLSearchParams(window.location.search);
                const post_category = urlParams.get('category_name');
        

        

        
            $.ajax({
               
               
                url: '../api/posts/filter.php/?category_name=' + post_category,
                method: 'GET',
                success: function(response){
                    var posts = JSON.parse(response);
                    console.log(posts);

                    if (posts.status === 200) {
                        displayPosts(posts.data);
                        displayPagination(page, Math.ceil(posts.total_posts / postsPerPage));
                    } else {
                        console.error("Error fetching data:", posts.message);
                    }
                },
                error: function(xhr, status, error){
                    console.error(error);
                }
            });
        

        function displayPosts(posts) {
            var postList = $('#post-content');
            postList.empty();

            $.each(posts, function(index, post){
                var postCard = $('<div class="card mb-4"></div>');
                var postImage = $('<a href="#!"><img class="card-img-top" src="../uploads/' + post.post_image + '" width="100px" height="200px" alt="..." /></a>');
                var postBody = $('<div class="card-body"></div>');
                var postDate = $('<div class="small text-muted">' + post.post_date + '</div>');
                var postCategory = $('<div class="small text-muted">' + post.post_category + '</div>');
                var postTitle = $('<h2>' + post.post_title + '</h2>');
                var postText = $('<p class="card-text">' + post.post_text + '</p>');
                var readMore = $('<a class="btn btn-primary bg-info text-dark" href="post-detail.php/?post_id='+ post.post_id +'">Read more →</a>');

                postBody.append(postDate, postCategory, postTitle, postText, readMore);
                postCard.append(postImage, postBody);

                postList.append(postCard);
            });
        }

        function displayPagination(currentPage, totalPages) {
            var pagination = $('#pagination');
            pagination.empty();

            if (totalPages > 1) {
                for (var i = 1; i <= totalPages; i++) {
                    var pageButton = $('<button class="btn btn-sm btn-outline-primary mx-1">' + i + '</button>');
                    pageButton.click(function(){
                        var pageNumber = parseInt($(this).text());
                        fetchPosts(pageNumber);
                    });

                    if (i === currentPage) {
                        pageButton.addClass('active');
                    }

                    pagination.append(pageButton);
                }
            } else {
                console.log("Only one page available, no pagination required.");
            }
        }

    });
</script>

</body>
</html>
