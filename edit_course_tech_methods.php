<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['tech_id'])){
    $tech_id = $_GET['tech_id'];
    $sql = "SELECT * FROM tech WHERE tech_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tech_id]);
    $tech = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['tech-update'])){
    $tech_short_title = $_POST['tech-short-title'];
    $tech_order = $_POST['tech-order'];
    $tech_title = $_POST['tech-title'];
    $tech_title_en = $_POST['tech-title-en'];

    $sql = 'UPDATE tech SET tech_title = ?, tech_title_eng = ?, tech_order = ? WHERE tech_short_title = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$tech_title, $tech_title_en, $tech_order, $tech_short_title]);
    header("Location: admin_course_tech_methods.php");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      <?php echo $tech['tech_title']; ?> [<?php echo $tech['tech_short_title']; ?>]
			</h1>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="update-tech-methods-form">
          <div class="form-row error-message error-update-tech-methods">
						<div class="alert alert-danger" role="alert">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2 required">
							<label for="tech-order" class="col-form-label font-weight-bold text-gray-800">A/A:</label>
							<input type="text" name="tech-order" id="tech-order" class="font-weight-normal form-control" value="<?php echo $tech['tech_order']; ?>" readonly>
						</div>
            <div class="form-group col-md-2 required">
							<label for="tech-short-title" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
							<input type="text" name="tech-short-title" id="tech-short-title" class="font-weight-normal form-control" value="<?php echo $tech['tech_short_title']; ?>" readonly>
						</div>
          </div>
						<div class="form-group required">
							<label for="tech-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
							<input type="text" name="tech-title" id="tech-title" class="font-weight-normal form-control" value="<?php echo $tech['tech_title']; ?>">
						</div>
            <div class="form-group">
							<label for="tech-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος (EN):</label>
							<input type="text" name="tech-title-en" class="font-weight-normal form-control" value="<?php echo $tech['tech_title_eng']; ?>">
						</div>
					<button type="submit" name="tech-update" class="btn btn-primary float-right">Ενημέρωση</button>
          <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

