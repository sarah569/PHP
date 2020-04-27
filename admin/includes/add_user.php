<?php 

	if(isset($_POST['create_user']))
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


		$user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

		$sql = "INSERT INTO users(user_firstname, user_lastname, user_role ,user_name, user_email, user_password) VALUES ('$user_firstname','$user_lastname','$user_role','$user_name','$user_email','$user_password')";

		$result = mysqli_query($connection,$sql);

		confirm_query($result);

		echo "<p class='bg-success'>User Created . " . '<br>' . " " . "<a href='users.php'>View Users</a>";
	}

 ?>

<form action="" method="post" enctype="multipart/form-data">
	
	<div class="form-group">
		<label for="user_firstname">First Name</label>
		<input name="user_firstname" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_lastname">Last Name</label>
		<input name="user_lastname" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_role">User Role</label>
		<br>
		<select name="user_role" id="">

			<option value="subscriber">Select Options</option>
			<option value="admin">Admin</option>
			<option value="subscriber">Subscriber</option>

			<?php 

				// $sql = "SELECT * FROM users";
    //             $result = mysqli_query($connection,$sql);

    //             confirm_query($result);

    //             while($row = mysqli_fetch_assoc($result))
    //             {
    //                 $user_id = $row['user_id'];
    //                 $user_role = $row['user_role'];

    //                 echo "<option value='$user_id'>$user_role</option>";
    //             }
                
			 ?>
			
		</select>
	</div>


	<!-- <div class="form-group">
		<label for="user_image">User Image</label>
		<input name="image" type="file"></input>
	</div> -->

	<div class="form-group">
		<label for="user_name">UserName</label>
		<input name="user_name" type="text" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_email">Email</label>
		<input name="user_email" type="email" class="form-control"></input>
	</div>

	<div class="form-group">
		<label for="user_password">Password</label>
		<input name="user_password" type="password" class="form-control"></input>
	</div>

	<div class="form-group">
        <input name="create_user" class="btn btn-primary" type="submit" value="Add User"></input>
    </div>
</form>