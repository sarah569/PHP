
<table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Id</th>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Admin</th>
            <th>Subscriber</th>
            <th>Edit</th>
            <th>Delete</th>
            
        </tr>
    </thead>
    <tbody>
                                
        <?php 

            $sql = "SELECT * FROM users";
            $result = mysqli_query($connection,$sql);

            while ($row = mysqli_fetch_assoc($result)) 
            {
                $user_id = $row['user_id'];
                $user_name = $row['user_name'];
                $user_password = $row['user_password'];
                $user_firstname = $row['user_firstname'];
                $user_lastname = $row['user_lastname'];
                $user_email = $row['user_email'];
                $user_image = $row['user_image'];
                $user_role = $row['user_role'];


                echo "<tr>";

                echo "<td>{$user_id}</td>";
                echo "<td>{$user_name}</td>";
                echo "<td>{$user_firstname}</td>";
                echo "<td>{$user_lastname}</td>";
                echo "<td>{$user_email}</td>";
                echo "<td>{$user_role}</td>";
                
                echo "<td><a href='users.php?change_to_admin={$user_id}' class='btn btn-success'>Admin</a></td>";
                echo "<td><a href='users.php?change_to_sub={$user_id}' class='btn btn-success'>Subscriber</a></td>";

                echo "<td><a href='users.php?source=edit_user&u_id=$user_id' class='btn btn-primary'>Edit</a></td>";

                echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete');\" href='users.php?delete={$user_id}' class='btn btn-danger'>Delete</a></td>";

                echo "</tr>";
            }
        
        ?>

    </tbody>
</table>

		<?php 

            if(isset($_GET['change_to_admin']))
            {
                $user_id = $_GET['change_to_admin'];

                $sql = "UPDATE users SET user_role = 'admin' WHERE user_id = '$user_id'";

                $result = mysqli_query($connection,$sql);

                if(!$result)
                {
                    die("query failed" . mysqli_error($connection));
                }
                    header("Location:users.php");
            }

            if(isset($_GET['change_to_sub']))
            {
                $user_id = $_GET['change_to_sub'];

                $sql = "UPDATE users SET user_role = 'subscriber' WHERE user_id = '$user_id'";

                $result = mysqli_query($connection,$sql);

                if(!$result)
		        {
		            die("query failed" . mysqli_error($connection));
		        }
		        	header("Location:users.php");
		    }


            if(isset($_GET['delete']))
            {
                if(isset($_SESSION['user_role']))
                {
                    if($_SESSION['user_role'] == 'admin')
                    {
                        $user_id = mysqli_real_escape_string($connection,$_GET['delete']);

                        $sql = "DELETE FROM users WHERE user_id = '$user_id'";

                        $result = mysqli_query($connection,$sql);

                        if(!$result)
                        {
                            die("query failed" . mysqli_error($connection));
                        }
                            header("Location:users.php");
                    }
                }
            } 
        ?>