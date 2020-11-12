<?php
	include 'includes/dbcon.php';
?>

<?php
  if(isset($_GET['type'])){
    echo $type = $_GET['type'];
    echo $code = $_GET['lesson_id'];


    if($type == 'lesson'){
      echo 'delete-lesson';
    }
  }
?>

<?php
  if(isset($_POST['email'])){
    echo $name = strip_tags($_POST['name']);
	  echo $email = strip_tags($_POST['email']);
    echo $message = strip_tags($_POST['message']);
    
    // header('Location: admin_course_categories.php');
  }
?>
