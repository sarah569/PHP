<?php 

$connection = mysqli_connect('localhost','root','','cms');

if(!$connection)
{
	die("" . mysqli_error());
}

 ?>