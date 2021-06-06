<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['category_id'])){
    $category_id = $_GET['category_id'];
    $sql = "SELECT * FROM lesson_cat WHERE cat_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);
    $cat = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['cat-update'])){
    $order = $_POST['cat-order'];
    $id = $_POST['cat-short-title'];
    $id_en = $_POST['cat-id-en'];
    $title = $_POST['cat-title'];
    $title_en = $_POST['cat-title-en'];

    $sql = 'UPDATE lesson_cat SET cat_title = ?, cat_order = ?, cat_title_eng = ?, cat_short_title_eng = ? WHERE cat_short_title = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $order, $title_en, $id_en, $id]);
    header("Location: admin_course_categories.php");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
				<?php echo $cat['cat_title'];?> [<?php echo $cat['cat_short_title']; ?>]
			</h1>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="edit-categories-form">
          <div class="form-row error-message error-edit-categories">
						<div class="alert alert-danger" role="alert">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-2 required">
							<label for="cat-order" class="col-form-label font-weight-bold text-gray-800">A/A:</label>
							<input type="text" name="cat-order" class="font-weight-normal form-control" value="<?php echo $cat['cat_order']; ?>" readonly>
						</div>
						<div class="form-group col-md-5 required">
							<label for="" class="col-form-label font-weight-bold text-gray-800">Κωδικός Κατηγορίας:</label>
							<input type="text" name="cat-short-title" class="font-weight-normal form-control" value="<?php echo $cat['cat_short_title']; ?>" readonly>
						</div>
            <div class="form-group col-md-5 required">
							<label for="cat-id-en" class="col-form-label font-weight-bold text-gray-800">Κωδικός Κατηγορίας(EN):</label>
							<input type="text" name="cat-id-en" class="font-weight-normal form-control" value="<?php echo $cat['cat_short_title_eng']; ?>">
						</div>
						
			    </div>
					<div class="form-row">
						<div class="form-group col-md-6 required">
							<label for="cat-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος Κατηγορίας:</label>
							<input type="text" name="cat-title" id="cat-title" class="font-weight-normal form-control" value="<?php echo $cat['cat_title']; ?>">
						</div>
            <div class="form-group col-md-6">
							<label for="cat-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος Κατηγορίας(EN):</label>
							<input type="text" name="cat-title-en" class="font-weight-normal form-control" value="<?php echo $cat['cat_title_eng']; ?>">
						</div>
			    </div>
          
					<button type="submit" name="cat-update" class="btn btn-primary float-right">Ενημέρωση</button>
          <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

