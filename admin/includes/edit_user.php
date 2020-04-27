<?php 

	if(isset($_GET['u_id']))
	{
		$user_id = $_GET['u_id'];
	

		$sql = "SELECT * FROM users WHERE user_id = '$user_id'";
	    $result = mysqli_query($connection,$sql);

	    while ($row = mysqli_fetch_assoc($result)) 
	    {
	    	$user_id = $row['user_id'];
	        $user_firstname = $row['user_firstname'];
	        $user_lastname = $row['user_lastname'];
	        $user_role = $row['user_role'];
	        $user_name = $row['user_name'];
	        $user_email = $row['user_email'];
	        $user_password = $row['user_password'];
	        $user_image = $row['user_image'];
	    }

		if(isset($_POST['edit_user']))
		{
			$user_firstname = $_POST['user_firstname'];
			$user_lastname = $_POST['user_lastname'];
			$user_role = $_POST['user_role'];
			$user_name = $_POST['user_name'];
			$user_email = $_POST['user_email'];
			$user_password = $_POST['user_password'];

			// $post_image = $_FILES['image']['name'];
			// $post_image_temp = $_FILES['image']['tmp_name'];

			// $post_date = date('d-m-y');

			// move_uploaded_file($post_image_temp, "../images/$post_image");


			if(!empty($user_password))
			{
				$sql2 = "SELECT user_password FROM users WHERE user_id = '$user_id'";
				$result2 = mysqli_query($connection,$sql2);
				confirm_query($result2);

				$row = mysqli_fetch_assoc($result2);
				$db_user_password = $row['user_password'];


				if($db_user_password != $user_password)
				{
					$hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
				}

				$sql3 = "UPDATE users SET user_firstname = '$user_firstname',
										 user_lastname = '$user_lastname',
										 user_role = '$user_role',
										 user_name = '$user_name',
										 user_email = '$user_email',
										 user_password = '$hashed_password'
						WHERE user_id = '$user_id'";

				$result3 = mysqli_query($connection,$sql3);

				confirm_query($result3);

				echo "<p class='bg-success'>User Updated . " . '<br>' . " " . "<a href='users.php'>View Users  <br>  <a href='users.php'> Edit More Users</a></a></p>";
			}
		}
	}
	else
	{
		header("Location:index.php");
	}

 ?>

<form action="" method="post" enctype="multipart/form-data">
	
<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input name="user_firstname" value="<?php echo $user_firstname;?>" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input name="user_lastname" value="<?php echo $user_lastname;?>" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_role">User Role</label>
		<br>
		<select name="user_role" id="">

			<option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>

			<?php 

				if($user_role == 'admin')
				{
					echo "<option value='subscriber'>subscriber</option>";
				}
				else
				{
					echo "<option value='admin'>admin</option>";
				}

			 ?>		
			
		</select>
	</div>


	<!-- <div class="form-group">
		<label for="user_image">User Image</label>
		<input name="image" type="file"></input>
	</div> -->

	<div class="form-group">
		<label for="user_name">UserName</label>
		<input name="user_name" value="<?php echo $user_name;?>" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input name="user_email" value="<?php echo $user_email;?>" type="email" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_password">Password</label>
		<input name="user_password" autocomplete="off" type="password" class="form-control"></input>
	</div>

	<div class="form-group">
        <input name="edit_user" class="btn btn-primary" type="submit" value="Edit User"></input>
    </div>
</form>