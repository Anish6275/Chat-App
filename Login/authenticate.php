<?php  
session_start();
if(isset($_SESSION["admin_name"]))
{
 header("location:https://baatcheet.cf/index.php");
}
//$connect = mysqli_connect("localhost", "root", "", "testing");  
include 'db_connect.php';
// if(isset($_POST["login"]))   
// {  
 if(!empty($_POST["member_name"]) && !empty($_POST["member_password"]))
 {

  $name = $_POST["member_name"];//mysqli_real_escape_string($connect, $_POST["member_name"]);
  $password = $_POST["member_password"];//md5(mysqli_real_escape_string($connect, $_POST["member_password"]));
  $sql = "SELECT * FROM `user_data` WHERE `uid` LIKE '" . $name . "' AND `password` LIKE '" . $password . "'";  
  $result = mysqli_query($conn,$sql);  
  $user = mysqli_fetch_array($result);  
  if($user)   
  {  
   if(!empty($_POST["remember"]))   
   {  
    setcookie ("member_login",$name,time()+ (10 * 365 * 24 * 60 * 60));  
    setcookie ("member_password",$password,time()+ (10 * 365 * 24 * 60 * 60));
    $_SESSION["user"] = $name;
   }  
   else  
   {  
    $_SESSION["user"] = $name;
    if(isset($_COOKIE["member_login"]))   
    {  
     setcookie ("member_login","");  
    }  
    if(isset($_COOKIE["member_password"]))   
    {  
     setcookie ("member_password","");  
    }  
   }  
   header("location:https://baatcheet.cf/index.php"); 
  }  
  else  
  {  
    $message = "Invalid Login";
	echo '<script language="javascript">';
	echo 'alert("'.$message.'");';
	echo 'window.location="https://baatcheet.cf/Login/";';
    echo '</script>';  
  } 
 }
 else
 {
  	$message = "Both are Required Fields";
  	echo '<script language="javascript">';
	echo 'alert("'.$message.'");';
	echo 'window.location="https://baatcheet.cf/Login/";';
    echo '</script>';
 }

 /*LOGOUT
 <?php
 session_start();
 unset($_SESSION["user"]);
 header("location:index.php");
 ?>*/
 ?>


