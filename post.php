<?php
    include ("includes/header.php");
?>

    <!-- Navigation -->
    <?php
        include ("includes/navigation.php");
    ?>

    <?php 
        if(isset($_POST['liked']))
        {
            $post_id = $_POST['post_id'];
            $sql = "SELECT * FROM posts WHERE post_id = $post_id";
            $result = mysqli_query($connection,$sql);
            $row = mysqli_fetch_assoc($result);
            $likes = $row['likes'];

            if(mysqli_num_rows($result) >= 1)
            {
                echo "works";
            }

        }
     ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php

                if(isset($_GET['p_id']))
                {
                    $post_id = $_GET['p_id'];

                    $sql2 = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id";

                    $result2 = mysqli_query($connection,$sql2);
                    
                    if(!$result2)
                    {
                        die("query failed" . mysqli_error($connection));
                    }

                    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin')
                    {
                        $sql = "SELECT * FROM posts WHERE post_id = $post_id";
                    }
                    else
                    {
                        $sql = "SELECT * FROM posts WHERE post_id = $post_id AND post_status = 'published'";
                    }

                    $result = mysqli_query($connection,$sql);

                    if(!$result)
                    {
                        die("query failed" . mysqli_error($connection));
                    }

                    if(mysqli_num_rows($result) < 1)
                    {
                        echo "<h1 class='text-center'>No Posts Avaliable</h1>";
                    }
                    else
                    {
                        while($row = mysqli_fetch_assoc($result))
                        {
                            $post_title   = $row['post_title'];
                            $post_author  = $row['post_author'];
                            $post_date    = $row['post_date'];
                            $post_image   = $row['post_image'];
                            $post_content = $row['post_content'];

                            ?>

                                <h1 class="page-header">
                                    Posts
                                </h1>

                                <!-- First Blog Post -->
                                <h2>
                                    <a href="#"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    by <a href="index.php"><?php echo $post_author; ?></a>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>

                                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                                <hr>
                                
                                <p><?php echo $post_content; ?></p>

                                <hr>

                                <div class="row">
                                    <p class="pull-right"><a href="#" class="like"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a></p>
                                </div>

                                <div class="row">
                                    <p class="pull-right">Likes:10</p>
                                </div>

                                <div class="clearfix">
                                    
                                </div>

                    <?php

                        }

                    ?>

                    <?php 

                        if(isset($_POST['create_comment']))
                        {

                            $post_id = $_GET['p_id'];

                            $comment_author = $_POST['comment_author'];
                            $comment_email = $_POST['comment_email'];
                            $comment_content = $_POST['comment_content'];

                            if(!empty($comment_author) && !empty($comment_email) && !empty($comment_content))
                            {

                                $sql = "INSERT INTO comments(comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) VALUES ('$post_id', '$comment_author', '$comment_email', '$comment_content', 'unapproved',now())";

                                $result = mysqli_query($connection,$sql);

                                if(!$result)
                                {
                                    die("query failed" . mysqli_error($connection));
                                }

                            }
                            else
                            {
                                echo "<script>alert('Fields cannot be empty')</script>";
                            }

                        }

                     ?>

                <!-- Comments Form -->

                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="" method="post" role="form">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="comment_author" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="comment_email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="comment">Your Comment</label>
                            <textarea name="comment_content" class="form-control" rows="3"></textarea>
                        </div>
                        <button name="create_comment" type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php 

                    $sql = "SELECT * FROM comments WHERE comment_post_id = '$post_id' AND comment_status = 'approved' ORDER BY comment_id DESC";

                    $result = mysqli_query($connection,$sql);

                    if(!$result)
                    {
                        die("query failed" . mysqli_error($connection));
                    }

                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $comment_author = $row['comment_author'];
                        $comment_content = $row['comment_content'];
                        $comment_date = $row['comment_date'];

                 ?>

                        <!-- Comment -->
                        <div class="media">

                            <a class="pull-left" href="#">
                                <img class="media-object" src="http://placehold.it/64x64" alt="">
                            </a>
                            <div class="media-body">
                                <h4 class="media-heading"><?php echo $comment_author; ?>
                                    <small><?php echo $comment_date; ?></small>
                                </h4>
                                <?php echo $comment_content; ?>
                            </div>
                        </div>

                 <?php 

                    }
                }
            }
                else
                {
                    header("Location: index.php");
                }

                  ?>
  
            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php
                include("includes/sidebar.php");
            ?>

        </div>
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        
        <?php
            include("includes/footer.php");
        ?>

    <script>
        $(document).ready(function()
        {
            var post_id = <?php echo $post_id; ?>;
            var user_id = 53;

            $('.like').click(function()
            {
                $.ajax({
                    url:"/cms/post.php?p_id=<?php echo $post_id; ?>",
                    type:'post',
                    data: {
                        'liked':1,
                        'post_id':post_id,
                        'user_id':user_id
                    }
                });
            });
        });

    </script>