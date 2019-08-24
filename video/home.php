<?php   require 'connect.inc.php';
session_start();  ?>

<html>
  <head>
       <title> Home </title>
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
    padding:2%;
    } 
    
    
    
    button{
      padding:1.5%;
      border-radius: 8px;
      border: 2px solid #1c5c6d;
      background-color: #1c5c6d;}
      button:hover{
  background-color: #6ccfd8;
  opacity:0.8;
  
} 

  </style>

  </head>
  <body>
<?php
      if(!isset($_SESSION['use'])) // If session is not set then redirect to Login Page
       {
           header("Location:index.php");  
       }
      ?> 
      <div id="form">
      <button onclick="window.open('final.php','_self')">Single Video Cutting</button><br><br>
      <button onclick="window.open('multi2.php','_self')">Multiple Video Cutting</button><br><br>
      <button onclick="window.open('logout.php','_self')">Logout</button>
      </div>
      
</body>
</html>