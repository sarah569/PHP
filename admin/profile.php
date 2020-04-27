<?php 
    include("includes/admin_header.php");
 ?>

<?php 

    if(isset($_SESSION['username']))
    {
        $user_name = $_SESSION['username'];

        $sql = "SELECT * FROM users WHERE user_name = '$user_name'";
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
        }
    }


    if(isset($_POST['update_profile']))
    {
        $user_firstname = $_POST['user_firstname'];
        $user_lastname = $_POST['user_lastname'];
        $user_name = $_POST['user_name'];
        $user_email = $_POST['user_email'];
        $user_password = $_POST['user_password'];

        // $post_image = $_FILES['image']['name'];
        // $post_image_temp = $_FILES['image']['tmp_name'];

        // $post_date = date('d-m-y');


        // move_uploaded_file($post_image_temp, "../images/$post_image");


        $sql = "UPDATE users SET user_firstname = '$user_firstname',
                                 user_lastname = '$user_lastname',
                                 user_name = '$user_name',
                                 user_email = '$user_email',
                                 user_password = '$user_password'
                WHERE user_name = '$user_name'";

        $result = mysqli_query($connection,$sql);

        confirm_query($result);
    }



 ?>


    <div id="wrapper">

        <!-- Navigation -->
        <?php 
            include("includes/admin_navigation.php");
        ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        
                        <h1 class="page-header">
                            Blank Page
                            <small>Subheading</small>
                        </h1>

                        <form action="" method="post" enctype="multipart/form-data">
    
                            <div class="form-group">
                                <label for="user_firstname">First Name</label>
                                <input name="user_firstname" value="<?php echo $user_firstname;?>" type="text" class="form-control"></input>
                            </div>

                            <div class="form-group">
                                <label for="user_lastname">Last Name</label>
                                <input name="user_lastname" value="<?php echo $user_lastname;?>" type="text" class="form-control"></input>
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
                                <input name="update_profile" class="btn btn-primary" type="submit" value="Update Profile"></input>
                            </div>
                        </form>

                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

<?php 
    include("includes/admin_footer.php");
 ?>