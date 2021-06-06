<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['ability_id'])){
    $ability_id = $_GET['ability_id'];
    $sql = "SELECT * FROM ability WHERE ability_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ability_id]);
    $ability = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['ability-update'])){
    $id = $_POST['ability-short-title'];
    $order = $_POST['ability-order'];
    $title = $_POST['ability-title'];
    $title_en = $_POST['ability-title-en'];

    $sql = 'UPDATE ability SET ability_title = ?, ability_title_eng = ?, ability_order = ? WHERE ability_short_title = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $title_en, $order, $id]);
    header("Location: admin_course_abilities.php");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
				Κωδικός Ικανότητας [<?php echo $ability['ability_short_title']; ?>]
			</h1>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="update-ability-form">
          <div class="form-row error-message error-update-ability">
						<div class="alert alert-danger" role="alert">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2 required">
							<label for="ability-order" class="col-form-label font-weight-bold text-gray-800">A/A:</label>
							<input type="text" name="ability-order" id="ability-order" class="font-weight-normal form-control" value="<?php echo $ability['ability_order']; ?>" readonly>
						</div>
            <div class="form-group col-md-2 required">
							<label for="ability-short-title" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
							<input type="text" name="ability-short-title" id="ability-short-title" class="font-weight-normal form-control" value="<?php echo $ability['ability_short_title']; ?>" readonly>
						</div>
          </div>
						<div class="form-group required">
							<label for="ability-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
							<input type="text" name="ability-title" id="ability-title" class="font-weight-normal form-control" value="<?php echo $ability['ability_title']; ?>">
						</div>
            <div class="form-group">
							<label for="ability-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος (EN):</label>
							<input type="text" name="ability-title-en" class="font-weight-normal form-control" value="<?php echo $ability['ability_title_eng']; ?>">
						</div>
					<button type="submit" name="ability-update" class="btn btn-primary float-right">Ενημέρωση</button>
          <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

