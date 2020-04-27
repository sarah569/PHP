
<?php 
	
	if(isset($_GET['p_id']))
	{
		$post_id = $_GET['p_id'];
	}

		$sql = "SELECT * FROM posts WHERE post_id = '$post_id'";
	    $result = mysqli_query($connection,$sql);

	    while ($row = mysqli_fetch_assoc($result)) 
	    {
	        $post_id = $row['post_id'];
	        $post_category_id = $row['post_category_id'];
	        $post_user = $row['post_user'];
	        $post_title = $row['post_title'];
	        $post_status = $row['post_status'];
	        $post_image = $row['post_image'];
	        $post_tags = $row['post_tags'];
	        $post_content = $row['post_content'];
	        $post_comment_count = $row['post_comment_count'];
	        $post_date = $row['post_date'];
	    }
	

	if(isset($_POST['update_post']))
	{

        $post_title = $_POST['post_title'];
		$post_user = $_POST['post_user'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];

		move_uploaded_file($post_image_temp, "../images/$post_image");

		if(empty($post_image))
		{
			$sql = "SELECT * FROM posts WHERE post_id = $post_id";

			$result = mysqli_query($connection,$sql);

			while($row = mysqli_fetch_assoc($result))
			{
				$post_image = $row['post_image'];
			}

		}


		$sql = "UPDATE posts SET post_category_id = '$post_category_id',
								 post_title = '$post_title',
								 post_user = '$post_user',
								 post_date = now(),
								 post_image = '$post_image',
								 post_content = '$post_content',
								 post_tags = '$post_tags',
								 post_status = '$post_status'
				WHERE post_id = '$post_id'";

		$result = mysqli_query($connection,$sql);

		confirm_query($result);

		echo "<p class='bg-success'>Post Updated . " . '<br>' . " " . "<a href='../post.php?p_id=$post_id'>View Posts  <br>  <a href='posts.php'> Edit More Posts</a></a></p>";
	}


 ?>


<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input value="<?php echo $post_title;?>" name="post_title" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="post_category_id">Post Category Id</label>
		<br>
		<select name="post_category" id="">

			<?php 
			
				$sql = "SELECT * FROM categories";
                $result = mysqli_query($connection,$sql);

                confirm_query($result);

                while($row = mysqli_fetch_assoc($result))
                {
                    $cat_id = $row['cat_id'];
                    $cat_title = $row['cat_title'];

                    if($cat_id == $post_category_id)
                    {
                    	echo "<option selected value='$cat_id'>$cat_title</option>";
                    }
                    else
                    {
                    	echo "<option value='$cat_id'>$cat_title</option>";
                    }
                }
			 ?>
			
		</select>
	</div>

<!-- 	<div class="form-group">
		<label for="post_user">Post Author</label>
		<input value="<?php echo $post_user;?>" name="post_user" type="text" class="form-control"></input>
	</div> -->

	<div class="form-group">
		<label for="users">Users</label>
		<br>
		<select name="post_user" id="">

			<?php 

			echo "<option value='$post_user'>$post_user</option>";

				$sql = "SELECT * FROM users";
                $result = mysqli_query($connection,$sql);

                confirm_query($result);

                while($row = mysqli_fetch_assoc($result))
                {
                    $user_id = $row['user_id'];
                    $user_name = $row['user_name'];

                    echo "<option value='$user_name'>$user_name</option>";
                }
                
			 ?>
			
		</select>
	</div>

	<div class="form-group">
		<label for="post_status">Post Status</label>
		<br>
		<select name="post_status" id="">

			<option value='<?php echo $post_status; ?>'><?php echo $post_status; ?></option>

			<?php 
				if ($post_status == 'published')
				{
					echo "<option value='draft'>draft</option>";
				}
				else
				{
					echo "<option value='published'>publish</option>";
				}
			 ?>
			 
			</select>
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<br>
		<img width="100" src="../images/<?php echo $post_image;?>" alt="">
		<input name="image" type="file"></input>

	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input value="<?php echo $post_tags;?>" name="post_tags" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea name="post_content" id="body" cols="30" rows="10" class="form-control">
			<?php echo str_replace('\r\n', '</br>', $post_content) ;?>
			</textarea>
	</div>

	<div class="form-group">
        <input name="update_post" class="btn btn-primary" type="submit" value="Update Post"></input>
    </div>
</form>