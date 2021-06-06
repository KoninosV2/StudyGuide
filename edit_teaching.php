<?php include 'includes/dbcon.php'; ?>
<?php
  if(isset($_GET['teacher_id'])){
    $teacher_id = $_GET['teacher_id'];
    $lesson_id = $_GET['lesson_id'];

    $sql = "SELECT * FROM teacher WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_id]);
    $teacher = $stmt->fetch();

    $sql = "SELECT lesson.lesson_code, title, semester, teacher2lesson.teacher_order, teacher2lesson.hours_teaching, teacher2lesson.multiplicity_teaching,
    teacher2lesson.hours_lab, teacher2lesson.multiplicity_lab, teacher2lesson.hours_exer, teacher2lesson.multiplicity_exer 
    FROM lesson, teacher2lesson 
    WHERE teacher2lesson.lesson_code = lesson.lesson_code 
    AND teacher2lesson.teacher_id = ? AND teacher2lesson.lesson_code = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_id, $lesson_id]);
    $lesson = $stmt->fetch();
  }
?>


<?php
  if(isset($_POST['teacher-update'])){
    $teacher_id = $_POST['teacher-id'];
    $lesson_id = $_POST['lesson-id'];
    $teacher_order = $_POST['teach-order'];
    $teach_theory = $_POST['teaching-theory'];
    $theory_classes = $_POST['theory-classes'];
    $teach_lab = $_POST['teaching-lab'];
    $lab_classes = $_POST['lab-classes'];
    $teach_exer = $_POST['teaching-exer'];
    $exer_classes = $_POST['exer-classes'];

    $sql = 'UPDATE teacher2lesson SET teacher_order = ?, hours_teaching = ?,             multiplicity_teaching= ?, hours_lab = ?, multiplicity_lab = ?, hours_exer = ?, multiplicity_exer = ? 
            WHERE teacher_id = ? AND lesson_code = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_order, $teach_theory, $theory_classes, $teach_lab, $lab_classes, $teach_exer, $exer_classes, $teacher_id, $lesson_id]);
    header("Location: teacher.php?teacher_id=" . $teacher_id . "#section-two");
  }
?>



<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
				<?php echo $teacher['surname'] . ' ' . $teacher['name'];?> [<?php echo $teacher['id']; ?>] <?php echo $teacher['lvl']; ?>
			</h1>
    </div>
    <div class="card shadow mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="teaching-form">
          <div class="form-row error-message error-teaching">
						<div class="alert alert-danger" role="alert">
						</div>
					</div>
          <input type="text" name="teacher-id" id="teacher-id" value="<?php echo $teacher['id'];?>" hidden>
          <div class="form-row">
            <div class="form-group col-md-2 required">
              <label for="lesson-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
              <input type="text" class="form-control" name="lesson-id" id="lesson-id" value="<?php echo $lesson["lesson_code"]; ?>" readonly>
            </div>
            <div class="form-group col-md-6 required">
              <label for="lesson-title" class="font-weight-bold text-gray-800 col-form-label">Μάθημα:</label>
              <input type="text" name="lesson-title" name="lessont-title" class="font-weight-normal form-control" value="<?php echo $lesson['lesson_code']; ?>" readonly>
            </div>
            <div class="form-group col-md-2 required">
              <label for="lesson-semester" class="font-weight-bold text-gray-800 col-form-label">Εξάμηνο:</label>
              <input type="text" class="form-control" name="lesson-semester" id="lesson-semester" value="<?php echo $lesson["semester"]; ?>" readonly>
						</div>
						<div class="form-group col-sm-2 required">
							<label for="teacher-order" class="font-weight-bold text-gray-800 col-form-label">Σειρά:</label>
							<input type="text" class="form-control" name="teach-order" id="teach-order" value="<?php echo $lesson["teacher_order"]; ?>">
						</div>
					</div>
					<div class="form-row">
            <div class="form-group col-md-6">
              <label for="teaching-theory" class="font-weight-bold text-gray-800 col-form-label">Διδασκαλία Θεωρίας:</label>
              <input type="text" class="form-control" name="teaching-theory" id="teaching-theory" value="<?php echo $lesson['hours_teaching'] !==""?$lesson['hours_teaching'] : 0; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="theory-classes" class="font-weight-bold text-gray-800 col-form-label">Αριθμός Τάξεων:</label>
              <input type="text" class="form-control" name="theory-classes" id="theory-classes" value="<?php echo $lesson['multiplicity_teaching'] !== ""?$lesson['multiplicity_teaching']:0; ?>">
            </div>
					</div>
					<div class="form-row">
            <div class="form-group col-md-6">
              <label for="teaching-lab" class="font-weight-bold text-gray-800 col-form-label">Διδασκαλία σε Εργαστήριο:</label>
              <input type="text" class="form-control" name="teaching-lab" id="teaching-lab" value="<?php echo $lesson['hours_lab']!==""?$lesson['hours_lab']:0; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="lab-classes" class="font-weight-bold text-gray-800 col-form-label">Αριθμός Τάξεων:</label>
              <input type="text" class="form-control" name="lab-classes" id="lab-classes" value="<?php echo $lesson['multiplicity_lab']!==""?$lesson['multiplicity_lab']:0; ?>">
            </div>
					</div>
					<div class="form-row">
            <div class="form-group col-md-6">
              <label for="teaching-exer" class="font-weight-bold text-gray-800 col-form-label">Διδασκαλία σε Φροντιστήριο:</label>
              <input type="text" class="form-control" name="teaching-exer" id="teaching-exer" value="<?php echo $lesson['hours_exer']!==""?$lesson['hours_exer']:0; ?>">
            </div>
            <div class="form-group col-md-6">
              <label for="exer-classes" class="font-weight-bold text-gray-800 col-form-label">Αριθμός Τάξεων:</label>
              <input type="text" class="form-control" name="exer-classes" id="exer-classes" value="<?php echo $lesson['multiplicity_exer']!==""?$lesson['multiplicity_exer']:0; ?>">
            </div>
          </div>
          <div class="form-row">
            <?php
              $total_hours = (int) $lesson['hours_teaching'] * (int) $lesson['multiplicity_teaching'] + 
              (int) $lesson['hours_lab'] * (int) $lesson['multiplicity_lab'] + 
              (int) $lesson['hours_exer'] * (int) $lesson['multiplicity_exer'];
            ?>
            <div class="lesson-category font-weight-bold text-gray-800">Ώρες Διδασκαλίας: 
							<span class="font-weight-normal" id="total-hours"><?php echo $total_hours; ?></span>
						</div>
          </div>
					<button type="submit" name="teacher-update" class="btn btn-primary float-right">Ενημέρωση</button>
        </form>
			</div>
    </div>                 
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  
