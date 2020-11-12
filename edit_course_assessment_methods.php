<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['assessment_id'])){
    $assessment_id = $_GET['assessment_id'];
    $sql = "SELECT * FROM assessment WHERE assessment_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$assessment_id]);
    $assessment = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['assessment-update'])){
    $id = $_POST['assessment-short-title'];
    $order = $_POST['assessment-order'];
    $title = $_POST['assessment-title'];
    $title_en = $_POST['assessment-title-en'];

    $sql = 'UPDATE assessment SET assessment_title = ?, assessment_title_eng = ?, assessment_order = ? WHERE assessment_short_title = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $title_en, $order, $id]);
    header("Location: admin_course_assessment_methods.php");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      <?php echo $assessment['assessment_title']; ?> [<?php echo $assessment['assessment_short_title']; ?>]
			</h1>
    </div>
    <div class="card shadow border-warning mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<div class="form-row">
						<div class="form-group col-md-2">
							<label for="assessment-order" class="col-form-label font-weight-bold text-gray-800">A/A:</label>
							<input type="text" name="assessment-order" class="font-weight-normal form-control" value="<?php echo $assessment['assessment_order']; ?>">
						</div>
            <div class="form-group col-md-2">
							<label for="assessment-short-title" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
							<input type="text" name="assessment-short-title" class="font-weight-normal form-control" value="<?php echo $assessment['assessment_short_title']; ?>" readonly>
						</div>
          </div>
						<div class="form-group">
							<label for="assessment-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
							<input type="text" name="assessment-title" class="font-weight-normal form-control" value="<?php echo $assessment['assessment_title']; ?>">
						</div>
            <div class="form-group">
							<label for="assessment-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος (EN):</label>
							<input type="text" name="assessment-title-en" class="font-weight-normal form-control" value="<?php echo $assessment['assessment_title_eng']; ?>">
						</div>
					<button type="submit" name="assessment-update" class="btn btn-primary float-right">Ενημέρωση</button>
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

