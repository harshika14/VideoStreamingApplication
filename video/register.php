<?php
require 'connect.inc.php';
if(isset($_POST['username'])&&isset($_POST['password'])&&isset($_POST['name']))
{
	$username=$_POST['username'];
	$password=$_POST['password'];
	$name=$_POST['name'];
	$hashpass=md5($password);
	if(!empty($username)&&!empty($password)&&!empty($name))
	{
		$query="select username from user where username='$username'";
		$queryrun=mysqli_query($conn,$query);
		$row_count=mysqli_num_rows($queryrun);
		if($row_count!=0)
		{
			echo "<script> alert('user already exists') </script>";
		}
		else
		{
			$sql="insert into user value(null,'$name','$username','$hashpass')";
			if (mysqli_query($conn, $sql)) {
    			echo "New record created successfully";
			} 
			else {
    			echo "Error: " . $sql . "<br>" . mysqli_error($conn);
			}

		}
	}
	else
	{
		echo "<script> alert('Please fill all the fields') </script>";
	}
}

?>

<form action="register.php" method="POST">
	UserName: <input type='text' name='username' placeholder='username' required><br><br>
	Password: <input type='password' name='password' placeholder='password' required><br><br>
	name: <input type='name' name='name' placeholder='Name' required><br><br>
	<input type="submit" value="Submit">

</form>
<button onclick="window.open('index.php');">Login</button>