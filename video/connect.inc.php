 <?php
$servername = "localhost";
$username = "root";
$password = "";
$db='php_learning';


if($conn=mysqli_connect($servername,$username,$password)) 
{
	mysqli_select_db($conn,$db);
}
else
{
	die('Error in connecting to the DB');
}



?>
