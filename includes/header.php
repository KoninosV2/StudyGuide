<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Course Guide</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">
  <link href="css/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="css/style.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav  bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <div class="sticky-top">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand  d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="img/new-logo.png" height="50" width="50" class="fas">
        </div>
        <div class="sidebar-brand-text mx-3">Οδηγος σπουδων</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">


      <!-- Divider -->
      <hr class="sidebar-divider">
      
      <!-- Heading -->
      <div class="sidebar-heading">ΠΡΟΒΟΛΗ</div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="lessons.php">
          <i class="fas fa-fw fa-bookmark"></i>
          <span>Λίστα Μαθημάτων</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="books.php">
          <i class="fas fa-fw fa-book"></i>
          <span>Λίστα Συγγραμμάτων</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="teachers.php">
        <i class="fas fa-fw fa-chalkboard-teacher"></i>
          <span>Λίστα Καθηγητών</span>
        </a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Κατηγορίες Μαθημάτων</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <?php 
              // Παίρνουμε όλες τις κατηγορίες μαθημάτων
              $sql = "SELECT * FROM lesson_cat ORDER BY cat_order";
              $stmt = $pdo->prepare($sql);
              $stmt->execute();
              $categories = $stmt->fetchAll();

              foreach($categories as $category){
                if($category['cat_short_title'] !== "Null"){
                  if($category['cat_short_title'] == "Κ")
                    $text = "Kορμού";
                  elseif($category['cat_short_title'] == 'ΕΕ')
                    $text = "Ελεύθερης Επιλογής";
                  else  
                    $text = $category['cat_short_title'];
                  echo "<a class='collapse-item' href='list_courses.php?category_id={$category['cat_short_title']}'>{$text}</a>";
                }
                
              }
            ?>
          </div>
        </div>
      </li>


      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Εμφανίζεται όταν έχει συνδεθεί κάποιος καθηγητής -->
      <?php if(isset($_SESSION['role'])): ?>
        <!-- Heading -->
        <div class="sidebar-heading">Διδασκόμενα Μαθηματα</div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
          <a class="nav-link" href="teacher_lessons.php">
            <i class="fas fa-fw fa-bookmark"></i>
            <span>Μαθημάτα</span>
          </a>
        </li>
      <?php endif; ?>

      <!-- Εμφανίζεται όταν έχει συνδεθεί κάποιος καθηγητής -->
      <?php if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
        <!-- Divider -->
        <hr class="sidebar-divider d-none d-md-block">
        <!-- Heading -->
        <div class="sidebar-heading">Διαχείριση</div>
        <!-- Διαχείριση Μαθημάτων -->
        <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#manageCourse" aria-expanded="true" aria-controls="collapsePages">
        <i class="fas fa-fw fa-bookmark"></i>
          <span>Μαθημάτων</span>
        </a>
        <div id="manageCourse" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class='collapse-item' href='admin_courses.php'>Μαθήματα</a>
            <a class='collapse-item' href='admin_course_categories.php'>Κατηγορίες Μαθημάτων</a>
            <a class='collapse-item' href='admin_course_types.php'>Τύποι Μαθημάτων</a>
            <a class='collapse-item' href='admin_course_where_teaching.php'>Τρόποι Παράδοσης</a>
            <a class='collapse-item' href='admin_course_abilities.php'>Αποκτώμενες Ικανότητες</a>
            <a class='collapse-item' href='admin_course_assessment_methods.php'>Μέθοδοι Αξιολόγησης</a>
            <a class='collapse-item' href='admin_course_teaching_methods.php'>Μέθοδοι Διδασκαλίας</a>
            <a class='collapse-item' href='admin_course_tech_methods.php'>Τεχνολογίες Διδασκαλίας</a>
          </div>
        </div>
      </li>
      <!-- Διαχείριση Συγγραμμάτων -->
      <li class="nav-item">
        <a class="nav-link" href="admin_books.php">
          <i class="fas fa-fw fa-book"></i>
          <span>Συγγραμμάτων</span>
        </a>
      </li>
    
      <!-- Διαχείριση Καθηγητών -->
      <li class="nav-item">
        <a class="nav-link" href="admin_teachers.php">
        <i class="fas fa-fw fa-chalkboard-teacher"></i>
          <span>Λίστα Καθηγητών</span>
        </a>
      </li>

      <!-- Log -->
      <li class="nav-item">
        <a class="nav-link" href="log.php">
        <i class="fas fa-fw fa-wrench"></i>
          <span>Ενημερώσεις</span>
        </a>
      </li>
      <?php endif; ?>
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline test">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>
    </div>
    </ul>
    <!-- End of Sidebar -->
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

         

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">
            <div class="topbar-divider d-none d-sm-block"></div>
		
            <!-- Nav Item - User Information -->
           	<?php if(isset($_SESSION['role'])): ?>
              <li class="nav-item dropdown no-arrow"><a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <em class="fas fa-user-graduate d-lg-inline text-gray-600 mx"></em> <span class="mx-2 d-none d-lg-inline text-gray-600">
                <?php echo $_SESSION['surname'] . ' ' . $_SESSION['name'] ?></span> </a><!-- Dropdown - User Information -->
                <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="userDropdown">
                  <a class="dropdown-item" href="includes/handle_logout.php">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Αποσύνδεση
                  </a>
                </div>
              </li>
            <?php else: ?>
            	<a class="my-auto btn-lg" href="login.php" role="button"><em class="fas fa-user d-lg-inline text-gray-600"></em> <span class="mx-2 d-none d-lg-inline text-gray-600">Σύνδεση</span></a>
			      <?php endif	?>
          </ul>
        </nav>
        <!-- End of Topbar -->