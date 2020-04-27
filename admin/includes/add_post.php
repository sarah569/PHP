<?php 

	if(isset($_POST['create_post']))
	{
		$post_title = $_POST['post_title'];
		//$post_author = $_POST['post_author'];
		$post_user = $_POST['post_user'];
		$post_category_id = $_POST['post_category'];
		$post_status = $_POST['post_status'];

		$post_image = $_FILES['image']['name'];
		$post_image_temp = $_FILES['image']['tmp_name'];

		$post_tags = $_POST['post_tags'];
		$post_content = $_POST['post_content'];
		$post_date = date('d-m-y');


		move_uploaded_file($post_image_temp, "../images/$post_image");


		$sql = "INSERT INTO posts(post_category_id, post_title, post_user, post_date, post_image ,post_content, post_tags, post_status) VALUES ('$post_category_id','$post_title','$post_user',now(),'$post_image','$post_content','$post_tags','$post_status')";

		$result = mysqli_query($connection,$sql);

		confirm_query($result);

		$post_id = mysqli_insert_id($connection);
		
		echo "<p class='bg-success'>Post Created . " . '<br>' . " " . "<a href='../post.php?p_id=$post_id'>View Post</a>" . '<br>' . " " . "<a href='posts.php'>Edit More Posts</a></p>";
	}

 ?>

<form action="" method="post" enctype="multipart/form-data">
	<div class="form-group">
		<label for="post_title">Post Title</label>
		<input name="post_title" type="text" class="form-control"></input>
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

                    echo "<option value='$cat_id'>$cat_title</option>";
                }
                
			 ?>
			
		</select>
	</div>

	<div class="form-group">
		<label for="users">Users</label>
		<br>
		<select name="post_user" id="">

			<?php 

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
		<label for="post_author">Post Author</label>
		<input name="post_author" type="text" class="form-control"></input>
	</div>


	<div class="form-group">
		<label for="post_status">Post Status</label>
		<br>
		<select name="post_status" id="">
			<option value="draft">Select Options</option>
			<option value="draft">Draft</option>
			<option value="published">Published</option>
		</select>
	</div>

	<div class="form-group">
		<label for="post_image">Post Image</label>
		<input name="image" type="file"></input>
	</div>

	<div class="form-group">
		<label for="post_tags">Post Tags</label>
		<input name="post_tags" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="post_content">Post Content</label>
		<textarea name="post_content" id="" cols="30" rows="10" class="form-control"></textarea>
	</div>

	<div class="form-group">
        <input name="create_post" class="btn btn-primary" type="submit" value="Publish Post"></input>
    </div>
</form>