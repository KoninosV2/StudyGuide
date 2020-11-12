<?php
	include 'includes/dbcon.php';
?>

<?php
	if(isset($_GET['teacher_id'])){
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM teacher WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_id]);
    $teacher = $stmt->fetch();
	}
?>


<?php include "includes/header.php";?>

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
							<?php echo $teacher['surname'] . ' ' . $teacher['name'];?>
						</h1>
          </div>
          <div class="card shadow border-warning mb-3">
          	<div class="card-header">
          		<h4 class="font-weight-bold text-primary">Βασικές Πληροφορίες</h4>
          	</div>
          	<div class="card-body">
          		<div class="row mb-3">
				        <div class="lesson-category font-weight-bold text-gray-800">Κωδικός: 
									<span class="font-weight-normal"><?php echo $teacher['id']; ?></span>
								</div>
							</div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Επώνυμο: 
									<span class="font-weight-normal"><?php echo $teacher['surname']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Όνομα: 
                  <span class="font-weight-normal"><?php echo $teacher['name']; ?></span>
								</div>
			        </div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Θέση: 
									<span class="font-weight-normal"><?php echo $teacher['lvl']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Email: 
									<span class="font-weight-normal"><?php echo $teacher['email']; ?></span>
								</div>
			        </div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Τηλέφωνο: 
                  <span class="font-weight-normal"><?php echo $teacher['phone']; ?></span>
								</div>
			        </div>
							<div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Παρατηρήσεις: 
									<span class="font-weight-normal"><?php echo $teacher['notes']; ?></span>
								</div>
			        </div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Επώνυμο (ΕΝ): 
									<span class="font-weight-normal"><?php echo $teacher['surname_eng']; ?></span>
								</div>
							</div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Όνομα (ΕΝ): 
									<span class="font-weight-normal"><?php echo $teacher['name_eng']; ?></span>
								</div>
							</div>
              <div class="row mb-3">
								<div class="lesson-category font-weight-bold text-gray-800">Θέση (ΕΝ): 
									<span class="font-weight-normal"><?php echo $teacher['lvl_eng']; ?></span>
								</div>
							</div>
              <a href="admin_teachers.php?teacher_id=<?php echo $teacher['id']; ?> " class="btn btn-danger float-right" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τον συγκεκριμένο καθηγητή;');">Διαγραφή</a>
              <a href="edit_teacher.php?teacher_id=<?php echo $teacher['id']; ?> " class="btn btn-primary float-right mr-3">Ενημέρωση</a>
			      </div>
          </div>          	
					<!-- /.container-fluid -->
				</div>										
    	</div>
    <!-- End of Main Content -->
<?php include "includes/footer.php"; ?>    

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
