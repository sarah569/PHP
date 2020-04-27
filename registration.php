<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>

<?php 
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);

        $error = [
                'name' => '',
                'email' => '',
                'password' => ''
                 ];

        if(strlen($name) < 4)
        {
            $error['name'] = 'Username used to be longer';
        }

        if($name == '')
        {
            $error['name'] = 'Username can not be empty';
        }

        if(username_exists($name))
        {
            $error['name'] = 'Username already exists, pick another one';
        }

        if($email == '')
        {
            $error['email'] = 'Email can not be empty';
        }

        if(email_exists($email))
        {
            $error['email'] = 'Email already exists, <a href="index.php"> Please Login</a>';
        }

        if($password == '')
        {
            $error['password'] = 'Password can not be empty';
        }

        foreach ($error as $key => $value) 
        {
            if(empty($value))
            {
                unset($error[$key]);
            }
        }

        if(empty($error))
        {
            register_user($name,$email,$password);
            login_user($username,$password);
        }
    }

 ?>

    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
    <!-- Page Content -->
    <div class="container">
    
        <section id="login">
            <div class="container">
                <div class="row">
                    <div class="col-xs-6 col-xs-offset-3">
                        <div class="form-wrap">
                        <h1>Register</h1>
                            <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">

                                <div class="form-group">
                                    <label for="username" class="sr-only">username</label>
                                    <input type="text" name ="name" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($name)?$name : ''?>">
                                    <p><?php echo isset($error['name'])?$error['name'] : ''?></p>
                                </div>

                                 <div class="form-group">
                                    <label for="email" class="sr-only">Email</label>
                                    <input type="email" name ="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($email)?$email : ''?>">
                                    <p><?php echo isset($error['email'])?$error['email'] : ''?></p>
                                </div>

                                 <div class="form-group">
                                    <label for="password" class="sr-only">Password</label>
                                    <input type="password" name ="password" id="key" class="form-control" placeholder="Password">
                                    <p><?php echo isset($error['password'])?$error['password'] : ''?></p>
                                </div>
                        
                                <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                            </form>
                         
                        </div>
                    </div> <!-- /.col-xs-12 -->
                </div> <!-- /.row -->
            </div> <!-- /.container -->
        </section>


        <hr>



<?php include "includes/footer.php";?>
