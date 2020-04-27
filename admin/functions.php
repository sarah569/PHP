<?php

    function redirect($location)
    {
        return header("Location:" . $location);
        exit;
    }

    function ifItIsMethod($method = null)
    {
        if($_SERVER['REQUEST_METHOD'] == strtoupper($method))
        {
            return true;
        }

        return false;
    }

    function isLoggedIn()
    {
        if(isset($_SESSION['user_role']))
        {
            return true;
        }

        return false;
    }

    function checkIfUserIsLoggedInAndRedirect($redirectLocation = null)
    {
        if(isLoggedIn())
        {
            redirect($redirectLocation);
        }
    }

    function login_user($username,$password)
    {
        global $connection;

        $username = trim($username);
        $password = trim($password);

        $username = mysqli_real_escape_string($connection,$username);
        $password = mysqli_real_escape_string($connection,$password);

        $sql = "SELECT * FROM users WHERE user_name = '$username'";
        $result = mysqli_query($connection,$sql);

        confirm_query($result);

        while($row = mysqli_fetch_assoc($result))
        {
            $db_user_id = $row['user_id'];
            $db_user_firstname = $row['user_firstname'];
            $db_user_lastname = $row['user_lastname'];
            $db_user_role = $row['user_role'];
            $db_user_name = $row['user_name'];
            $db_user_password = $row['user_password'];

            if(password_verify($password, $db_user_password))
            {
                $_SESSION['username'] = $db_user_name;
                $_SESSION['firstname'] = $db_user_firstname;
                $_SESSION['lastname'] = $db_user_lastname;
                $_SESSION['user_role'] = $db_user_role;
                
                redirect("/cms/admin");
            }

            else
            {
                return false;
            }
        }
        return true;
    }

    function username_exists($name)
    {
        global $connection;

        $sql = "SELECT user_name FROM users WHERE user_name = '$name'";
        $result = mysqli_query($connection,$sql);
        confirm_query($result);

        $count = mysqli_num_rows($result);

        if($count > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function email_exists($email)
    {
        global $connection;

        $sql = "SELECT user_email FROM users WHERE user_email = '$email'";
        $result = mysqli_query($connection,$sql);
        confirm_query($result);

        $count = mysqli_num_rows($result);

        if($count > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function register_user($name,$email,$password)
    {
        global $connection;

        $name = mysqli_real_escape_string($connection,$name);
        $email = mysqli_real_escape_string($connection,$email);
        $password = mysqli_real_escape_string($connection,$password);

        $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
                
            $sql = "INSERT INTO users(user_name,user_email,user_password,user_role) VALUES ('$name','$email','$password','subscriber')";
            $result = mysqli_query($connection,$sql);

            confirm_query($result);
    }

    function is_admin($username)
    {
        global $connection;

        $sql = "SELECT user_role FROM users WHERE user_name = '$username'";
        $result = mysqli_query($connection,$sql);
        confirm_query($result);

        $row = mysqli_fetch_assoc($result);

        if($row['user_role'] == 'admin')
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    function checkstatus($table,$column,$status)
    {
        global $connection;

        $sql = "SELECT * FROM $table WHERE $column = '$status'";
        $result = mysqli_query($connection,$sql);
        confirm_query($result); 
        $count = mysqli_num_rows($result);
        return $count;
    }

    function record_count($table)
    {
        global $connection;

        $sql = "SELECT * FROM " . $table;
        $result = mysqli_query($connection,$sql);
        confirm_query($result);
        $count = mysqli_num_rows($result);
        return $count;
    }

    function escape($string)
    {
        global $connection;
        return mysqli_real_escape_string($connection, trim(strip_tags($string)));
    }

    function users_online()
    {
        if(isset($_GET['onlineusers']))
        {
            global $connection;
            
            if(!$connection)
            {
                session_start();
                include("../includes/db.php");
            
                $session = session_id();
                $time = time();
                $time_out_in_seconds = 05;
                $time_out = $time - $time_out_in_seconds;


                $sql = "SELECT * FROM users_online WHERE session = '$session'";
                $result = mysqli_query($connection,$sql);
                $count = mysqli_num_rows($result);

                if($count == NULL)
                {
                    $sql2 = "INSERT INTO users_online(session,time) VALUES ('$session','$time')";
                    $result2 = mysqli_query($connection,$sql2);
                }
                else
                {
                    $sql3 = "UPDATE users_online SET time = '$time' WHERE session = '$session'";
                    $result3 = mysqli_query($connection,$sql3);
                }
                    $sql4 = "SELECT * FROM users_online WHERE time > '$time_out'";
                    $result4 = mysqli_query($connection,$sql4);
                    echo $count_user = mysqli_num_rows($result4);
            }
        }
    }
    users_online();

	function insert_categories()
	{
		if(isset($_POST['submit']))
            {
            	global $connection;

                $cat_title = $_POST['cat_title'];

                if($cat_title == "" || empty($cat_title) || $cat_title == " ")
                {
                    echo "this field should not be empty";
                }

                else
                {
                    $statement = mysqli_prepare($connection,"INSERT INTO categories(cat_title) VALUES (?)");

                    mysqli_stmt_bind_param($statement,"s",$cat_title);
                    mysqli_stmt_execute($statement);

                    confirm_query($statement);
                }

                mysqli_stmt_close($statement);

            }
	}


	function find_all_categories()
	{
		global $connection;

		$sql = "SELECT * FROM categories";
        
        $result = mysqli_query($connection,$sql);

        while($row = mysqli_fetch_assoc($result))
        {
            $cat_id = $row['cat_id'];
            $cat_title = $row['cat_title'];

            echo "<tr>";
            echo "<td>{$cat_id}</td>";
            echo "<td>{$cat_title}</td>";
            echo "<td><a href='categories.php?edit={$cat_id}' class='btn btn-primary'>Edit</a></td>";
            echo "<td><a onClick=\"javascript: return confirm('Are you sure you want to delete');\" href='categories.php?delete={$cat_id}' class='btn btn-danger'>Delete</a></td>";
            
            echo "</tr>";
        }

	}


	function delete_categories()
	{
		global $connection;

		if(isset($_GET['delete']))
	    {
	        $cat_id = $_GET['delete'];

	        $sql = "DELETE FROM categories WHERE cat_id = '$cat_id'";
	        $result = mysqli_query($connection,$sql);

	        confirm_query($result);
	        //b5aly al header tro7 ll categories.php
	        header("Location: categories.php");
	    }

	}

    function confirm_query($result)
    {
        global $connection;

        if(!$result)
        {
            die("query failed" . mysqli_error($connection));
        }
    }

 ?>