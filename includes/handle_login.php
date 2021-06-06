<?php 
  include "dbcon.php";
  
  // Παίρνουμε το email και το password που έδωσε ο χρήστης
  $user_email = $_POST['email'];
  $user_password = $_POST['password'];

  $sql = "SELECT * FROM teacher WHERE email = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$user_email]);
  $teacher = $stmt->fetch();

  $db_email = $teacher['email'];
  $db_password = '123456';

  if($user_email === $db_email && $user_password == $db_password){
    $_SESSION['user_id'] = $teacher['id'];
    $_SESSION['name'] = $teacher['name'];
    $_SESSION['surname'] = $teacher['surname'];
    $_SESSION['email'] = $teacher['email'];

    if($teacher['role'] == 'admin'){
      $_SESSION['role'] = 'admin';
    }  
    else{
      $_SESSION['role'] = 'user';
    }
    header("Location: ../teacher_lessons.php");
    
  }else{
    header("Location: ../login.php");
  }
