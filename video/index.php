<?php  
require 'connect.inc.php';
session_start();
?>  


<?php

if(isset($_SESSION['use']))   // Checking whether the session is already there or not if 
                              // true then header redirect it to the home page directly 
 {
    header("Location:home.php"); 
 }

if(isset($_POST['login']))   // it checks whether the user clicked login button or not 
{
     $user = $_POST['user'];
     $pass = $_POST['pass'];
     $password_hash=md5($pass);
     $query="select id from user where username='$user' and password='$password_hash'";
     $query_run=mysqli_query($conn,$query);
     $query_num_rows=mysqli_num_rows($query_run);


      if($query_num_rows==1)  
         {                                        


          $_SESSION['use']=$user;


         echo '<script type="text/javascript"> window.open("home.php","_self");</script>';            //  On Successful Login redirects to home.php

        }

        else
        {
            echo "invalid UserName or Password";
        }
}
 ?>
<html>
<head>

<title> Login Page   </title>


</head> 
  <style type="text/css">
  body{
    background:url('tech2.jpg');
    background-repeat: no-repeat;
    background-size: cover;
    background-blend-mode:screen;
    font-family:sans-serif;
    font-size: 70%;
    font-weight: normal;

  }
     #form{
      text-align: center;
    height: 300px;
    background-color: rgba(0,0,0,0.9);
    color: white;
    margin-right: 20%;
    margin-left: 10%;
    margin-top: 5%;
    width: 40%; 
    float: right;
    } 
    
    .text{ 
      background-color: black;
       border-radius: 25px;
    border: 2px solid #0f434e;
      width: 200px;
      padding:3px;
      color: white;
      outline:none;
      transition: 0.25s;
    } 
    .text:focus{
      width:250px;
      border-color:green;
    }
    
    #submitbutton{
      padding:1.5%;
      border-radius: 8px;
      border: 2px solid #1c5c6d;
      background-color: #1c5c6d;}
      #submitbutton:hover{
  background-color: #6ccfd8;
  opacity:0.8;
  
} 

 
    #register{ 

      padding:1.5%;
      border-radius: 8px;
      border: 2px solid #1c5c6d;
      background-color: #1c5c6d;
      margin-right: 0%;
      margin-left: 50%;
       }

      #register:hover{
  background-color: #6ccfd8;
  opacity:0.8;
  
} 

    
  </style>
<script type="text/javascript">
  
  function register()
  {
     var myWindow=window.open("register.php");
     
  }
</script>

<body> 
  <div id="form">

<form action="" method="post">
  <h1>Username:</h1>
   <input type="text" name="user" class="text" > 
 
  <h1>Password:</h1>
   <input type="password" name="pass" class="text"><br><br>
 <input type="submit" name="login" value="LOGIN" id="submitbutton">
  
   <button onclick="window.open('register.php')" id="register">REGISTER</button>
  
</div>
</form>


</body>
</html>