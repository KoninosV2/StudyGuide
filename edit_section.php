<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['delete'])){
    $lesson_id = $_GET['delete'];
    $week = $_GET['week'];

    $section = "Εβδομαδιαίο Πρόγραμμα";
		$fld = "Διαγράφηκε μία εβδομάδα";
		$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
						VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $pdo->prepare($sql);
		$stmt->execute([$_SESSION['user_id'], $lesson_id, $section, $fld, $week, ""]);
    
    $sql = "DELETE FROM section2lesson WHERE lesson_code = ? AND section = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lesson_id, $week]);
    header("Location: edit_lesson.php?lesson_id=" . $lesson_id ."#section-three");
  }
?>

<?php
  if(isset($_GET['lesson_id'])){
    $lesson_code = $_GET['lesson_id'];
    $week = $_GET['week'];
    $sql = "SELECT * FROM section2lesson WHERE lesson_code = ? AND section = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$lesson_code, $week]);
    $details = $stmt->fetch();
  }
  
?>


<?php
  if(isset($_POST['section-update'])){
    $id = $_POST['section-lesson-id'];
    $week = $_POST['section-week'];
    $title = $_POST['section-title'];
    $reference = $_POST['section-reference'];
    $url = $_POST['section-url'];

    // Άντληση Δεδομένων από τη Βάση
    $sql = "SELECT * FROM section2lesson WHERE lesson_code = ? AND section = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id, $week]);
    $old_values = $stmt->fetch();

    $new_values["lesson_code"] = $id;
		$new_values["section"] = $week;
		$new_values["descr"] = $title;
		$new_values["reference"] = $reference;
		$new_values["url"] = $url;

		$diff=array_diff($new_values, $old_values);
		$section = "Εβδομαδιαίο Πρόγραμμα";
		foreach($diff as $field => $new_value) {
			$sql = "INSERT INTO log (teacher_id, lesson_id, section, field, previous_value, new_value) 
							VALUES (?, ?, ?, ?, ?, ?)";
			$stmt = $pdo->prepare($sql);
			$stmt->execute([$_SESSION['user_id'], $id, $section, $field, $old_values[$field], $new_value]);
		}


    $sql = 'UPDATE section2lesson SET descr = ?, reference = ?, url =? WHERE lesson_code = ? AND section = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $reference, $url, $id, $week]);
    header("Location: edit_lesson.php?lesson_id=" . $id ."#section-three");
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
				Τροποποίηση Εβδομαδιαίου Προγράμματος
			</h1>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="update-weekly-schedule">
          <div class="form-row error-message error-update-schedule">
						<div class="alert alert-danger" role="alert">
						</div>
					</div>
					<div class="form-row">
						<div class="form-group col-md-3 required">
							<label for="section-lesson-id" class="col-form-label font-weight-bold text-gray-800">Κωδικός Μαθήματος:</label>
							<input type="text" name="section-lesson-id" class="font-weight-normal form-control" value="<?php echo $details['lesson_code']; ?>" readonly>
						</div>
						<div class="form-group col-md-2 required">
							<label for="section-week" class="col-form-label font-weight-bold text-gray-800">Εβδομάδα:</label>
							<input type="text" name="section-week" class="font-weight-normal form-control" value="<?php echo $details['section']; ?>" readonly>
						</div>
          </div>
          <div class="form-group required">
						<label for="section-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος Ενότητας:</label>
						<input type="text" name="section-title" class="font-weight-normal form-control" value="<?php echo $details['descr']; ?>">
					</div>
          <div class="form-group">
						<label for="section-reference" class="col-form-label font-weight-bold text-gray-800">Βιβλιογραφία:</label>
						<input type="text" name="section-reference" class="font-weight-normal form-control" value="<?php echo $details['reference']; ?>">
					</div>
          <div class="form-group">
						<label for="section-url" class="col-form-label font-weight-bold text-gray-800">Σύνδεσμος Παρουσίασης:</label>
						<input type="text" name="section-url" class="font-weight-normal form-control" value="<?php echo $details['url']; ?>">
					</div>
					<button type="submit" name="section-update" class="btn btn-primary float-right">Ενημέρωση</button>
          <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

