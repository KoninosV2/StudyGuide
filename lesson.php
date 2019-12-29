<?php
	include 'dbcon.php';
?>
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

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon">
          <img src="img/new-logo.png" height="50" width="50" class="fas">
        </div>
        <div class="sidebar-brand-text mx-3">Οδηγος σπουδων</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item">
        <a class="nav-link" href="dashboard.html">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Πίνακας Ελέγχου</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Μαθηματα
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link" href="list.php">
          <i class="fas fa-fw fa-book"></i>
          <span>Λίστα</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Components:</h6>
            <a class="collapse-item" href="buttons.html">Buttons</a>
            <a class="collapse-item" href="cards.html">Cards</a>
            <a class="collapse-item" href="buttons.html">Buttons</a>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Ρυθμίσεις</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
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

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <!-- Counter - Alerts -->
                <span class="badge badge-danger badge-counter">3+</span>
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                  Alerts Center
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary">
                      <i class="fas fa-file-alt text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 12, 2019</div>
                    <span class="font-weight-bold">A new lesson has been added!</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning">
                      <i class="fas fa-exclamation-triangle text-white"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500">December 2, 2019</div>
                    Your edit suggestion has been rejected by the administrator.
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
              </div>
            </li>


            <div class="topbar-divider d-none d-sm-block"></div>
		
            <!-- Nav Item - User Information -->
           	<?php if(isset($_SESSION['username'])): ?>
            <li class="nav-item dropdown no-arrow"><a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <em class="fas fa-user-graduate d-lg-inline text-gray-600 mx"></em> <span class="mx-2 d-none d-lg-inline text-gray-600">
             <?= $_SESSION['username'] ?></span> </a><!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-left shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="userlogout.php" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
            <?php else: ?>
            	<a class="my-auto btn-lg" href="login.php" role="button"><em class="fas fa-user d-lg-inline text-gray-600"></em> <span class="mx-2 d-none d-lg-inline text-gray-600">Login</span></a>
			<?php endif	?>
          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <div class="mb-3">
            <h1 class="h3 mb-0 text-gray-800">Lesson Details</h1>
          </div>
          <div class="shadow mb-3">
          	<div class="card-header">
          		<h6 class="font-weight-bold text-primary">Basic info</h6>
          	</div>
          	<div class="card-body">
          		<div class="row mb-3">
				<div class="col-md-5 input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Κατηγορία</span>
					</div>
					  <select class="custom-select" id="catSelect">
						<?php
							$stmtcat = $db->prepare("SELECT cat_id FROM lesson WHERE lesson_code = 'ψηφ-επι'");
							$stmtcat->execute();
			  				$lessoncat = $stmtcat->fetch();
			  				echo $lessoncat[0];
							$stmt = $db->prepare("SELECT cat_title, cat_short_title FROM lesson_cat ORDER BY place ASC");
							$stmt->execute();
							while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
								<option <?php (($lessoncat[0] == $row['cat_short_title'])?'selected':'') ?> value="<?= $row['cat_short_title']; ?>"><?= $row['cat_title']." - ".$row['cat_short_title']; ?></option>
						  <?php endwhile; ?>
					  </select>
					</div>
			</div>
			
			 <div class="row mb-3">
					<div class="col-sm-2 input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">ECTS</span>
						</div>
						  <select class="custom-select" id="catSelect">
							<option value="1">One</option>
							<option selected value="2">Two</option>
							<option value="3">Three</option>
						  </select>
						  <div class="invalid-feedback">Example invalid custom select feedback</div>
					</div>
					<div class="col-sm-2 input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupSelect0a1">Εξάμηνο</span>
						</div>
						  <select class="custom-select" id="catSelect">
							<option value="1">One</option>
							<option selected value="2">Two</option>
							<option value="3">Three</option>
						  </select>
					</div>
			</div>
          	</div>          	
          </div>
          
          <div class="card shadow mb-3">
			  <div class="card-header">
				<ul class="nav nav-tabs card-header-tabs">
				  <li class="nav-item">
					<a class="nav-link active" href="#">Active</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" href="#">Link</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
				  </li>
				</ul>
			  </div>
			  <div class="card-body">
				<h5 class="card-title">Special title treatment</h5>
				<p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
				<a href="#" class="btn btn-primary">Go somewhere</a>
			  </div>
			</div>
          
          <div class="card shadow mb-3 border-warning">
			<div class="card-header">
			   <ul class="nav nav-pills card-header-pills" id="pills-tab" role="tablist">
				  <li class="nav-item">
					<a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Γενικές ικανότητες που καλλιεργεί το μάθημα</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Χρήση τεχνολογιών πληροφορίας και επικοινωνιών</a>
				  </li>
				  <li class="nav-item">
					<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Μέθοδοι αξιολόγησης</a>
				  </li>
				</ul>
			</div>
			<div class="card-body">
			<div class="tab-content" id="pills-tabContent">
			  <div class="tab-pane fade show active" id="pills-home" role="tabpanel">
			  <form>
			  <div class="form-group">
				<?php
					$stmt = $db->prepare("SELECT ability.ability_title, ability.ability_order, ability2lesson.lesson_code FROM ability LEFT JOIN ability2lesson ON ability.ability_short_title = ability2lesson.ability_id and ability2lesson.lesson_code = 'αλγ-πολ'");
					$stmt->execute();
			  		$row_count = 0;
					while($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
					<div class="custom-control custom-checkbox">
					  <input type="checkbox" class="custom-control-input" id="customCheck<?= $row_count; ?>"<?php echo is_null($row['lesson_code'])?:'checked' ?> disabled></input>
					  <label class="custom-control-label" for="customCheck<?= $row_count; ?>">
						<?= $row['ability_title']; ?>
					</div>
				  <?php $row_count++; endwhile; ?>

				<a class="btn btn-warning float-right text-white px-xl-5" id="ability_button">Edit</a>
			  </div>
			  </form>
			  </div>
			  <div class="tab-pane fade" id="pills-profile" role="tabpanel">
          		<div class="row mb-3">
				<div class="col-md-5 input-group">
					<div class="input-group-prepend">
						<span class="input-group-text">Κατηγορία</span>
					</div>
					  <select class="custom-select" id="catSelect">
						<option value="1">One</option>
						<option selected value="2">Two</option>
						<option value="3">Three</option>
					  </select>
					</div>
			</div>
			
			 <div class="row mb-3">
					<div class="col-sm-2 input-group">
						<div class="input-group-prepend">
							<span class="input-group-text">ECTS</span>
						</div>
						  <select class="custom-select" id="catSelect">
							<option value="1">One</option>
							<option selected value="2">Two</option>
							<option value="3">Three</option>
						  </select>
						  <div class="invalid-feedback">Example invalid custom select feedback</div>
					</div>
					<div class="col-sm-2 input-group">
						<div class="input-group-prepend">
							<span class="input-group-text" id="inputGroupSelect0a1">Εξάμηνο</span>
						</div>
						  <select class="custom-select" id="catSelect">
							<option value="1">One</option>
							<option selected value="2">Two</option>
							<option value="3">Three</option>
						  </select>
					</div>
			</div>
			  </div>
			  <div class="tab-pane fade" id="pills-contact" role="tabpanel">
			  	
			  </div>
			</div>	
			</div>
			
           </div>

           
      
      
      
      
       <div class="my-3">
            <h1 class="h3 mb-0 text-gray-800">Lesson list</h1>
       </div>
                 <!-- DataTales Example -->
          <div class="shadow">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">My Lessons</h6>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>Code</th>
                      <th>Title</th>
                      <th>Category</th>
                      <th>Semester</th>
                      <th>Level</th>
                    </tr>
                  </thead>
                  <tbody>
                   <?php
						$que = $db->prepare("SELECT lesson.lesson_code,title,cat_id,semester,level FROM lesson, teacher2lesson WHERE teacher2lesson.teacher_id = 'Μαλαμάτος' AND teacher2lesson.lesson_code = lesson.lesson_code");
			  			$que->execute();
						while($row = $que->fetch(PDO::FETCH_ASSOC)): ?>
   						<tr>
						  <td><?= $row['lesson_code']; ?></td>
						  <td><?= $row['title']; ?></td>
						  <td><?= $row['cat_id']; ?></td>
						  <td><?= $row['semester']; ?></td>
						  <td><?= $row['level']; ?></td>
						</tr>
					  <?php endwhile; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          
       
       <div class="my-3">
            <h1 class="h3 mb-0 text-gray-800">Recent requests</h1>
       </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; UoP 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="userlogout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>
  
  <!-- Datatables Plugin -->
  <script src="js/jquery.dataTables.min.js"></script>
  <script src="js/dataTables.bootstrap4.min.js"></script>

  <script>
	  $(document).ready( function () {
    	$('#dataTable').DataTable();
	  } );
	  $( "#ability_button" ).click(function() {
		  $('[id^="customCheck"]').prop('disabled', false);
		  this.attr('id','ability_button_editing')
		  this.toggleClass('bu')
	  });
  </script>

</body>

</html>
