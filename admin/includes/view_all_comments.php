
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comment</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
            <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th> 
        </tr>
    </thead>
    <tbody>
                                
        <?php 

            $sql = "SELECT * FROM comments";
            $result = mysqli_query($connection,$sql);

            while ($row = mysqli_fetch_assoc($result)) 
            {
                $comment_id = $row['comment_id'];
                $comment_post_id = $row['comment_post_id'];
                $comment_author = $row['comment_author'];
                $comment_content = $row['comment_content'];
                $comment_email = $row['comment_email'];
                $comment_status = $row['comment_status'];
                $comment_date = $row['comment_date'];

                echo "<tr>";

                echo "<td>{$comment_id}</td>";
                echo "<td>{$comment_author}</td>";
                echo "<td>{$comment_content}</td>";
                echo "<td>{$comment_email}</td>";
                echo "<td>{$comment_status}</td>";


                $sql2 = "SELECT * FROM posts WHERE post_id = '$comment_post_id'";
                $result2 = mysqli_query($connection,$sql2);

                while ($row = mysqli_fetch_assoc($result2)) 
                {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];

                    echo "<td><a href='../post.php?p_id=$post_id'>{$post_title}</a></td>";

                }
                
                echo "<td>{$comment_date}</td>";

                echo "<td><a href='comments.php?approve=$comment_id' class='btn btn-success'>Approve</a></td>";
                echo "<td><a href='comments.php?unapprove=$comment_id' class='btn btn-success'>Unapprove</a></td>";

                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete');\" href='comments.php?delete=$comment_id' class='btn btn-danger'>Delete</a></td>";

                echo "</tr>";
            }
        
        ?>

    </tbody>
</table>

		<?php 

            if(isset($_GET['approve']))
            {
                $comment_id = $_GET['approve'];

                $sql = "UPDATE comments SET comment_status = 'approved' WHERE comment_id = '$comment_id'";

                $result = mysqli_query($connection,$sql);

                if(!$result)
                {
                    die("query failed" . mysqli_error($connection));
                }
                    header("Location:comments.php");
            }

            if(isset($_GET['unapprove']))
            {
                $comment_id = $_GET['unapprove'];

                $sql = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = '$comment_id'";

                $result = mysqli_query($connection,$sql);

                if(!$result)
		        {
		            die("query failed" . mysqli_error($connection));
		        }
		        	header("Location:comments.php");
		    }


            if(isset($_GET['delete']))
            {
                $comment_id = $_GET['delete'];

                $sql = "DELETE FROM comments WHERE comment_id = '$comment_id'";

                $result = mysqli_query($connection,$sql);

                if(!$result)
                {
                    die("query failed" . mysqli_error($connection));
                }
                    header("Location:comments.php");
            } 
        ?>