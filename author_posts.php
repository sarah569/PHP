<?php
    include ("includes/header.php");
?>

    <!-- Navigation -->
    <?php
        include ("includes/navigation.php");
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
                        $post_author = $_GET['author'];
                    }

                    $sql = "SELECT * FROM posts WHERE post_user = '$post_author'";

                    $result = mysqli_query($connection,$sql);

                        while($row = mysqli_fetch_assoc($result))
                        {
                            $post_title   = $row['post_title'];
                            $post_user  = $row['post_user'];
                            $post_date    = $row['post_date'];
                            $post_image   = $row['post_image'];
                            $post_content = $row['post_content'];

                            ?>


                                <h1 class="page-header">
                                    Page Heading
                                    <small>Secondary Text</small>
                                </h1>

                                <!-- First Blog Post -->
                                <h2>
                                    <a href="#"><?php echo $post_title; ?></a>
                                </h2>
                                <p class="lead">
                                    All post by <?php echo $post_author; ?>
                                </p>
                                <p><span class="glyphicon glyphicon-time"></span> <?php echo $post_date; ?></p>
                                <hr>



                                <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt="">
                                <hr>


                                
                                <p><?php echo $post_content; ?></p>

                                <hr>

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

                                $sqll = "UPDATE posts SET post_comment_count = post_comment_count + 1 WHERE post_id = '$post_id'";

                                $resultt = mysqli_query($connection,$sqll);
                            }
                            else
                            {
                                echo "<script>alert('Fields cannot be empty')</script>";
                            }
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