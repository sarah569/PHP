<?php include("delete_model.php"); ?>

<?php 
    if(isset($_POST['checkBoxArray']))
    {
        foreach ($_POST['checkBoxArray'] as $postValueId)
        {
            $bulk_options = $_POST['bulk_options'];

            switch ($bulk_options) 
            {
                case 'published':
                    $sql = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = '$postValueId'";
                    $result = mysqli_query($connection,$sql);
                    break;

                case 'draft':
                    $sql = "UPDATE posts SET post_status = '$bulk_options' WHERE post_id = '$postValueId'";
                    $result = mysqli_query($connection,$sql);
                    break;

                case 'delete':
                    $sql = "DELETE FROM posts WHERE post_id = '$postValueId'";
                    $result = mysqli_query($connection,$sql);
                    break;

                case 'clone':
                    $sql = "SELECT * FROM posts WHERE post_id = '$postValueId'";
                    $result = mysqli_query($connection,$sql);

                    while ($row = mysqli_fetch_assoc($result)) 
                    {
                        $post_category_id = $row['post_category_id'];
                        $post_author = $row['post_author'];
                        $post_user = $row['post_user'];
                        $post_title = $row['post_title'];
                        $post_status = $row['post_status'];
                        $post_image = $row['post_image'];
                        $post_tags = $row['post_tags'];
                        $post_date = $row['post_date'];
                        $post_content = $row['post_content'];
                    }
                    $sql2 = "INSERT INTO posts(post_category_id,post_author,post_user,post_title,post_status,post_image,post_tags,post_date,post_content) VALUES ('$post_category_id','$post_author','$post_user','$post_title','$post_status','$post_image','$post_tags',now(),'$post_content')";

                    $result2 = mysqli_query($connection,$sql2);

                    if(!$result2)
                    {
                        die("query failed" . mysqli_error($connection));
                    }

                    break;
            }
        }
    }

 ?>

<form action="" method="post"> 

    <table class="table table-bordered table-hover">

        <div id="bulkOptionsContainer" class="col-xs-4">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select Options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="delete">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div>

        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a href="posts.php?source=add_post" class="btn btn-primary">Add New</a>
        </div>

        <thead>
            <tr>
                <th><input type="checkbox" id="SelectAllBoxes"></th>
                <th>Id</th>
                <th>Category</th>
                <th>User</th>
                <th>Title</th>
                <th>Status</th>
                <th>Image</th>
                <th>Tags</th>
                <th>Comments</th>
                <th>Date</th>
                <th>Number of Views</th> 
                <th>View Post</th> 
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
                                    
            <?php 

                $sql = "SELECT posts.post_id,posts.post_category_id,posts.post_author,posts.post_user,posts.post_title,posts.post_image,posts.post_status,posts.post_tags,posts.post_comment_count,posts.post_date,posts.post_views_count,categories.cat_id,categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ORDER BY posts.post_id DESC";

                $result = mysqli_query($connection,$sql);

                while ($row = mysqli_fetch_assoc($result)) 
                {
                    $post_id = $row['post_id'];
                    $post_category_id = $row['post_category_id'];
                    $post_author = $row['post_author'];
                    $post_user = $row['post_user'];
                    $post_title = $row['post_title'];
                    $post_status = $row['post_status'];
                    $post_image = $row['post_image'];
                    $post_tags = $row['post_tags'];
                    $post_comment_count = $row['post_comment_count'];
                    $post_date = $row['post_date'];
                    $post_views_count = $row['post_views_count'];
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    echo "<tr>";
                    ?>

                        <td><input type="checkbox" class="checkBoxes"name="checkBoxArray[]" value="<?php echo $post_id; ?>"></td>

                    <?php
                    echo "<td>{$post_id}</td>";

                    echo "<td>{$cat_title}</td>";

                    if(!empty($post_author))
                    {
                        echo "<td>{$post_author}</td>";
                    }
                    elseif (!empty($post_user)) 
                    {
                        echo "<td>{$post_user}</td>";
                    }

                    echo "<td>{$post_title}</td>";
                    echo "<td>{$post_status}</td>";
                    echo "<td><img width='100' src='../images/$post_image'></td>";
                    echo "<td>{$post_tags}</td>";

                    $sql2 = "SELECT * FROM comments WHERE comment_post_id = '$post_id'";
                    $result2 = mysqli_query($connection,$sql2);
                    $row = mysqli_fetch_assoc($result2);
                    $comment_id = $row['comment_id'];
                    $count_comments = mysqli_num_rows($result2);

                    echo "<td><a href='post_comments.php?id=$post_id' class='btn btn-info'>{$count_comments}</a></td>";


                    echo "<td>{$post_date}</td>";
                    echo "<td><a href='posts.php?reset=$post_id' class='btn btn-danger'>{$post_views_count}</a></td>";
                    echo "<td><a href='../post.php?p_id=$post_id' class='btn btn-info'>View Post</a></td>";
                    echo "<td><a href='posts.php?source=edit_post&p_id=$post_id' class='btn btn-primary'>Edit</a></td>";

                    ?>

                    <form method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                    <?php 
                        echo "<td><input type='submit' name='delete' value='Delete' class='btn btn-danger'></td>";
                    ?>
                    </form>

                    <?php

                    //echo "<td><a rel='$post_id' href='javascript:void(0)' class='delete_link'>Delete</a></td>";

                    echo "</tr>";
                }
            
            ?>

        </tbody>
    </table>

</form>

			<?php 

                if(isset($_POST['delete']))
                {
                    $post_id = $_POST['post_id'];

                    $sql = "DELETE FROM posts WHERE post_id = '$post_id'";

                    $result = mysqli_query($connection,$sql);

                    if(!$result)
			        {
			            die("query failed" . mysqli_error($connection));
			        }
			        	header("Location:posts.php");
			    } 

                if(isset($_GET['reset']))
                {
                    $post_id = $_GET['reset'];

                    $sql = "UPDATE posts SET post_views_count = 0 WHERE post_id =" . mysqli_real_escape_string($connection,$_GET['reset']) ." ";

                    $result = mysqli_query($connection,$sql);

                    if(!$result)
                    {
                        die("query failed" . mysqli_error($connection));
                    }
                        header("Location:posts.php");
                } 

            ?>

<script>

    $(document).ready(function(){
        $(".delete_link").on('click',function()
        {
            var id = $(this).attr("rel");
            var delete_url = "posts.php?delete="+ id +" ";
            $(".model_delete_link").attr("href",delete_url);

            $("#myModel").modal('show');

        });
    });


</script>