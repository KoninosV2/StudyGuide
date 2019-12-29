<?php
//error_reporting(0);
if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['login']))
{
  /*
  include("sqlconnect.php");
  $username = mysqli_real_escape_string($db,$_POST['username']);
  $password = mysqli_real_escape_string($db,$_POST['password']);
  $sql = "SELECT * FROM users WHERE username = '$username' and password = '$password'";
  $result = mysqli_query($db,$sql);
  $count = mysqli_num_rows($result);
  if($count == 1){
	  $_SESSION['username'] = $username;
	  unset($_SESSION["illegalMove"]);
	  header("location: PhotoShot.php");
  } else if ($count == 0){
	  $_SESSION["error"] = "Invalid username or password";
	  header("location: Login.php");
  }
  mysqli_close($db);
} else {
	$_SESSION["error"] = "Login server error. Pleare try again";
	header("location: Login.php");
	*/
	session_start();
	$_SESSION['username'] = "KONINOS";
	header("location: index.php");
	die();
}
?>