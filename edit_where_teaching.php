<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['where_id'])){
    $where_id = $_GET['where_id'];
    $sql = "SELECT * FROM whereteaching WHERE where_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$where_id]);
    $where = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['where-update'])){
    $id = $_POST['where-short-title'];
    $title = $_POST['where-title'];
    $title_en = $_POST['where-title-en'];

    $sql = 'UPDATE whereteaching SET where_title = ?, where_title_eng = ? WHERE where_short_title = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $title_en, $id]);
    header("Location: admin_course_where_teaching.php");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
				<?php echo $where['where_title'];?> [<?php echo $where['where_short_title']; ?>]
			</h1>
    </div>
    <div class="card shadow border-warning mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
					<!-- <div class="form-row"> -->
						<div class="form-group">
							<label for="where-order" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
							<input type="text" name="where-short-title" class="font-weight-normal form-control" value="<?php echo $where['where_short_title']; ?>" readonly>
						</div>
						<div class="form-group">
							<label for="where-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
							<input type="text" name="where-title" class="font-weight-normal form-control" value="<?php echo $where['where_title']; ?>">
						</div>
            <div class="form-group">
							<label for="where-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος (EN):</label>
							<input type="text" name="where-title-en" class="font-weight-normal form-control" value="<?php echo $where['where_title_eng']; ?>">
						</div>
			    <!-- </div> -->
					<button type="submit" name="where-update" class="btn btn-primary float-right">Ενημέρωση</button>
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

