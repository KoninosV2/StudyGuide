<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['teaching_id'])){
    $teaching_id = $_GET['teaching_id'];
    $sql = "SELECT * FROM teaching WHERE teaching_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teaching_id]);
    $teaching = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['teaching-update'])){
    $teaching_short_title = $_POST['teaching-short-title'];
    $teaching_order = $_POST['teaching-order'];
    $teaching_title = $_POST['teaching-title'];
    $teaching_title_en = $_POST['teaching-title-en'];

    $sql = 'UPDATE teaching SET teaching_title = ?, teaching_title_eng = ?, teaching_order = ? WHERE teaching_short_title = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teaching_title, $teaching_title_en, $teaching_order, $teaching_short_title]);
    header("Location: admin_course_teaching_methods.php");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      <?php echo $teaching['teaching_title']; ?> [<?php echo $teaching['teaching_short_title']; ?>]
			</h1>
    </div>
    <div class="card shadow border-warning mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<div class="form-row">
						<div class="form-group col-md-2">
							<label for="teaching-order" class="col-form-label font-weight-bold text-gray-800">A/A:</label>
							<input type="text" name="teaching-order" class="font-weight-normal form-control" value="<?php echo $teaching['teaching_order']; ?>">
						</div>
            <div class="form-group col-md-2">
							<label for="teaching-short-title" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
							<input type="text" name="teaching-short-title" class="font-weight-normal form-control" value="<?php echo $teaching['teaching_short_title']; ?>" readonly>
						</div>
          </div>
						<div class="form-group">
							<label for="teaching-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
							<input type="text" name="teaching-title" class="font-weight-normal form-control" value="<?php echo $teaching['teaching_title']; ?>">
						</div>
            <div class="form-group">
							<label for="teaching-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος (EN):</label>
							<input type="text" name="teaching-title-en" class="font-weight-normal form-control" value="<?php echo $teaching['teaching_title_eng']; ?>">
						</div>
					<button type="submit" name="teaching-update" class="btn btn-primary float-right">Ενημέρωση</button>
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

