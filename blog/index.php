<?php include "include/admin_header.php"; 

?>
   
<?php include "include/admin_sidebar.php";?>

<div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card bg-primary text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Posts</h5>
                        <p class="card-text" id="totalPosts">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-success text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Comments</h5>
                        <p class="card-text" id="totalComments">Loading...</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-info text-white mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text" id="totalUsers">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
</div>

<script>
        $(document).ready(function(){
            
            $.ajax({
                url: 'api/function/get_dashboard_data.php',
                type: 'GET',
                success: function(response){
                    $('#totalPosts').text(response.totalPosts);
                    $('#totalComments').text(response.totalComments);
                    $('#totalUsers').text(response.totalUsers);
                },
                error: function(){
                    $('#totalPosts').text('Error fetching data');
                    $('#totalComments').text('Error fetching data');
                    $('#totalUsers').text('Error fetching data');
                }
            });
        });
    </script>

        
           

    </body>
</html>

                 
