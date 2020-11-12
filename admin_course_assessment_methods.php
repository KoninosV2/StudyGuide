<?php
  include 'includes/dbcon.php';
?>

<?php
  // Πλήθος Μαθηματων
  $sql = "SELECT * FROM assessment";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_assessment_methods = $stmt->rowCount();
  $methods = $stmt->fetchAll();
?>

<?php 
  if(isset($_GET['assessment_id'])){
    $assessment_id = $_GET['assessment_id'];
    $sql = "DELETE FROM assessment WHERE assessment_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$assessment_id]);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
?>

<?php
  if(isset($_POST['submit'])){
    $assessment_id = $_POST['assessment-short-title'];
    $assessment_order = $_POST['assessment-order'];
    $assessment_title = $_POST['assessment-title'];
    $assessment_title_eng = $_POST['assessment-title-en'];
    
    $sql = "INSERT INTO assessment (assessment_title, assessment_short_title, assessment_title_eng, assessment_order) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$assessment_title, $assessment_id, $assessment_title_eng, $assessment_order]);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
?>
<?php include "includes/header.php"; ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="h3 mb-0 text-gray-800">Σύνοψη</h1>
          </div>
           <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <a role="button" href="#" class="btn-outline-light card border-left-primary shadow py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Μέθοδοι Αξιολόγησης</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $number_of_assessment_methods; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-bookmark fa-3x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>
			</div>
      <div class="my-3">
        <h1 class="h3 mb-0 text-gray-800">Μέθοδοι Αξιολόγησης</h1>
      </div>
      <div class="shadow">
        <div class="card-header py-3">
          <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#newAssessment" role="button" aria-expanded="false" aria-controls="newAssessment">
              Νέα Μέθοδος Αξιολόγησης
            </a>
          </p>
          <div class="collapse" id="newAssessment">
            <div class="card card-body">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="assessment-order" class="font-weight-bold text-gray-800 col-form-label">A/A:</label>
                    <input type="text" class="form-control" name="assessment-order">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="assessment-short-title" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                    <input type="text" class="form-control" name="assessment-short-title">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="assessment-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος:</label>
                    <input type="text" class="form-control" name="assessment-title">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="assessment-title-en" class="font-weight-bold text-gray-800 col-form-label">Τίτλος (ΕΝ):</label>
                    <input type="text" class="form-control" name="assessment-title-en">
                  </div>
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-success float-right" name="submit">
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="adminCategoriesTable" class="table table-bordered table-hover editTable" style="width:100%">
                <thead>
                  <tr>
                    <th>A/A</th>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Τίτλος(En)</th>
                    <th>Τροποποίση</th>
                    <th>Διαγραφή</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση δεδομένω από ΒΔ-->
                  <?php
                    foreach($methods as $method): 
                  ?>  
                      <tr>
                        <td><?php echo $method['assessment_order']; ?></td>
                        <td><?php echo $method['assessment_short_title']; ?></td>
                        <td><?php echo $method['assessment_title']; ?></td>
                        <td><?php echo $method['assessment_title_eng']; ?></td>
                        <td class='editField'><a href="edit_course_assessment_methods.php?assessment_id=<?php echo $method['assessment_short_title'];?>"><i class="far fa-edit"></i></a></td>
                        <td class='editField'><a href="admin_course_assessment_methods.php?assessment_id=<?php echo $method['assessment_short_title'];?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τη συγκεκριμένη μέθοδο αξιολόγησης;');"><i class='fas fa-trash-alt delete-item'></i></td>
                      </tr>
					          <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->
<?php include "includes/footer.php"; ?>
<script>
  $(document).ready( function () {
    $('#adminCategoriesTable').DataTable();
	});
</script>