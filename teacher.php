<?php
include 'includes/dbcon.php';
?>

<?php
if (isset($_GET['teacher_id'])) {
	$teacher_id = $_GET['teacher_id'];
	$sql = "SELECT * FROM teacher WHERE id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$teacher_id]);
	$teacher = $stmt->fetch();

	$sql = "SELECT lesson.lesson_code, title, semester, teacher2lesson.hours_teaching, teacher2lesson.multiplicity_teaching,
									teacher2lesson.hours_lab, teacher2lesson.multiplicity_lab, teacher2lesson.hours_exer, teacher2lesson.multiplicity_exer 
									FROM lesson, teacher2lesson 
						WHERE teacher2lesson.lesson_code = lesson.lesson_code 
						AND teacher_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$teacher_id]);
	$lessons = $stmt->fetchAll();
	$number_of_lessons = $stmt->rowCount();
}
?>


<?php
if (isset($_GET['delete_id'])) {
	echo $lesson_id = $_GET['delete_id'];
	echo $teacher_id = $_GET['teacher_id'];

	$sql = "DELETE FROM teacher2lesson WHERE lesson_code = ? AND teacher_id = ?";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$lesson_id, $teacher_id]);
	header("Location: teacher.php?teacher_id=" . $teacher_id . "#section-two");
}
?>


<?php
if (isset($_POST['submit'])) {
	$lesson_id = $_POST['lesson-id'];
	$teacher_id = $_POST['teacher-id'];
	$order = $_POST['teach-order'];
	$teaching_theory = $_POST['teaching-theory'];
	$theory_classes = $_POST['theory-classes'];
	$teaching_lab = $_POST['teaching-lab'];
	$lab_classes = $_POST['lab-classes'];
	$teaching_exer = $_POST['teaching-exer'];
	$exer_classes = $_POST['exer-classes'];

	$sql = "INSERT INTO teacher2lesson (lesson_code, teacher_id, teacher_order, hours_teaching, multiplicity_teaching,
		hours_lab, multiplicity_lab, hours_exer, multiplicity_exer) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $pdo->prepare($sql);
	$stmt->execute([$lesson_id, $teacher_id, $order, $teaching_theory, $theory_classes, $teaching_lab, $lab_classes, $teaching_exer, $exer_classes]);
	header("Location: teacher.php?teacher_id=" . $teacher_id . "#section-two");
}
?>


<?php include "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
	<div class="mb-3">
		<h1 class="h3 mb-0 text-gray-800 font-weight-bold">
			<?php echo $teacher['surname'] . ' ' . $teacher['name']; ?>
		</h1>
	</div>

	<div class="card shadow mb-3" id="section-one">
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
				<div class="lesson-category font-weight-bold text-gray-800">Ρόλος:
					<span class="font-weight-normal"><?php echo $teacher['role'] === "user" ? "Χρήστης" : "Admin"; ?></span>
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

	<div class="card shadow mb-3" id="section-two">
		<div class="card-header">
			<h4 class="font-weight-bold text-primary">Διδασκόμενα Μαθήματα</h4>
		</div>
		<div class="card-header py-3">
			<p>
				<a class="btn btn-primary" data-toggle="collapse" href="#newCourseType" role="button" aria-expanded="false" aria-controls="newCourseType">
					Νέα Διδασκαλία
				</a>
			</p>
			<div class="collapse" id="newCourseType">
				<div class="card card-body">
					<form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="teaching-form">
						<div class="form-row error-message error-teaching">
							<div class="alert alert-danger" role="alert">
							</div>
						</div>
						<input type="text" name="teacher-id" id="teacher-id" value="<?php echo $teacher['id']; ?>" hidden>
						<div class="form-row">
							<div class="form-group col-md-10 required">
								<label for="type-id" class="font-weight-bold text-gray-800 col-form-label">Μάθημα:</label>
								<select class="form-control" name="lesson-id" id="lesson-id">
									<?php
									$sql = "SELECT lesson_code, title FROM lesson";
									$stmt = $pdo->prepare($sql);
									$stmt->execute();
									$all_lessons = $stmt->fetchAll();
									foreach ($all_lessons as $lesson) {
										echo "<option value={$lesson['lesson_code']}>{$lesson['title']}</option>";
									}
									?>
								</select>
							</div>
							<div class="form-group col-sm-2 required">
								<label for="teacher-order" class="font-weight-bold text-gray-800 col-form-label">Σειρά:</label>
								<input type="text" class="form-control" name="teach-order" id="teach-order">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="teaching-theory" class="font-weight-bold text-gray-800 col-form-label">Διδασκαλία Θεωρίας:</label>
								<input type="text" class="form-control teaching-hours" name="teaching-theory" id="teaching-theory">
							</div>
							<div class="form-group col-md-6">
								<label for="theory-classes" class="font-weight-bold text-gray-800 col-form-label">Αριθμός Τάξεων:</label>
								<input type="text" class="form-control teaching-hours" name="theory-classes" id="theory-classes">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="teaching-lab" class="font-weight-bold text-gray-800 col-form-label">Διδασκαλία σε Εργαστήριο:</label>
								<input type="text" class="form-control teaching-hours" name="teaching-lab" id="teaching-lab">
							</div>
							<div class="form-group col-md-6">
								<label for="lab-classes" class="font-weight-bold text-gray-800 col-form-label">Αριθμός Τάξεων:</label>
								<input type="text" class="form-control teaching-hours" name="lab-classes" id="lab-classes">
							</div>
						</div>
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="teaching-exer" class="font-weight-bold text-gray-800 col-form-label">Διδασκαλία σε Φροντιστήριο:</label>
								<input type="text" class="form-control teaching-hours" name="teaching-exer" id="teaching-exer">
							</div>
							<div class="form-group col-md-6">
								<label for="exer-classes" class="font-weight-bold text-gray-800 col-form-label">Αριθμός Τάξεων:</label>
								<input type="text" class="form-control teaching-hours" name="exer-classes" id="exer-classes">
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
			<?php if ($number_of_lessons > 0) :
				$winter_hours = 0;
				$summer_hours = 0;
				$week_hours = 0;
			?>
				<?php foreach ($lessons as $lesson) :
					$total_hours = (int) $lesson['hours_teaching'] * (int) $lesson['multiplicity_teaching'] +
						(int) $lesson['hours_lab'] * (int) $lesson['multiplicity_lab'] +
						(int) $lesson['hours_exer'] * (int) $lesson['multiplicity_exer'];
				?>
					<div class="row mb-3">
						<div class="col-md-2">
							<div class="lesson-category font-weight-bold text-gray-800">Κωδικός:
								<span class="font-weight-normal teaching-lesson-code"><?php echo $lesson["lesson_code"] ?></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="lesson-category font-weight-bold text-gray-800">Μάθημα:
								<span class="font-weight-normal"><?php echo $lesson['title']; ?></span>
							</div>
						</div>
						<div class="col-md-2">
							<div class="lesson-category font-weight-bold text-gray-800">Εξάμηνο:
								<span class="font-weight-normal"><?php echo $lesson['semester']; ?></span>
							</div>
						</div>
						<div class="col-md-2 ">
							<div class="lesson-category font-weight-bold text-gray-800">Ώρες Διδασκαλίας:
								<span class="font-weight-normal"><?php echo $total_hours; ?></span>
							</div>
						</div>
						<div class="col-md-2">
							<a href="teacher.php?delete_id=<?php echo $lesson['lesson_code']; ?>&teacher_id=<?php echo $teacher['id']; ?>" class="float-right mr-5" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τον συγκεκριμένο καθηγητή;');"><i class='fas fa-trash-alt delete-item'></i></a>
							<a href="edit_teaching.php?teacher_id=<?php echo $teacher['id']; ?>&lesson_id=<?php echo $lesson["lesson_code"]; ?>" class=" float-right mr-2"><i class="far fa-edit"></i></a>
						</div>
					</div>
					<div class="table-responsive">
						<table id="adminCourseTable" class="table table-bordered table-hover editTable" style="width:100%">
							<thead>
								<tr>
									<th>Τύπος Διδασκαλίας</th>
									<th>Ώρες / Εβδομάδα</th>
									<th>Αρ. Τμημάτων</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="editField">Θεωρία</td>
									<td class="editField"><?php echo $lesson['hours_teaching'] !== "" ? $lesson['hours_teaching'] : 0; ?></td>
									<td class="editField"><?php echo $lesson['multiplicity_teaching'] !== "" ? $lesson['multiplicity_teaching'] : 0; ?></td>
								</tr>
								<tr>
									<td class="editField">Εργαστήριο</td>
									<td class="editField"><?php echo $lesson['hours_lab'] !== "" ? $lesson['hours_lab'] : 0; ?></td>
									<td class="editField"><?php echo $lesson['multiplicity_lab'] !== "" ? $lesson['multiplicity_lab'] : 0;; ?></td>
								</tr>
								<tr>
									<td class="editField">Φροντιστήριο</td>
									<td class="editField"><?php echo $lesson['hours_exer'] !== "" ? $lesson['hours_exer'] : 0; ?></td>
									<td class="editField"><?php echo $lesson['multiplicity_exer'] !== "" ? $lesson['multiplicity_exer'] : 0; ?></td>
								</tr>
							</tbody>
						</table>
					</div>
					<hr>
				<?php
					if ($lesson['semester'] == 1 || $lesson['semester'] == 3 || $lesson['semester'] == 5 || $lesson['semester'] == 7)
						$winter_hours += $total_hours;
					else
						$summer_hours += $total_hours;
					$week_hours += $total_hours;
				endforeach;
				?>
				<div class="row mb-3 col-md-12">
					<div>
						<div class="lesson-category font-weight-bold text-gray-800">Εβδομαδιαίο Σύνολο Ωρών:
							<span class="font-weight-normal"><?php echo $week_hours; ?></span>
						</div>
					</div>
				</div>
				<div class="row mb-3 col-md-12">
					<div>
						<div class="lesson-category font-weight-bold text-gray-800">Εβδομαδιαίο Σύνολο Ωρών (Χειμερινό Εξάμηνο):
							<span class="font-weight-normal"><?php echo $winter_hours; ?></span>
						</div>
					</div>
				</div>
				<div class="row mb-3 col-md-12">
					<div>
						<div class="lesson-category font-weight-bold text-gray-800">Εβδομαδιαίο Σύνολο Ωρών (Εαρινό Εξάμηνο):
							<span class="font-weight-normal"><?php echo $summer_hours; ?></span>
						</div>
					</div>
				</div>
			<?php else : ?>
				<p>Ο καθηγητής δεν διδάσκει κάποιο μάθημα</p>
			<?php endif; ?>
		</div>
	</div>
	<!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>

<script>
	$(document).ready(function() {
		$('#dataTable').DataTable();
	});
	$("#ability_button").click(function() {
		$('[id^="customCheck"]').prop('disabled', false);
		this.attr('id', 'ability_button_editing')
		this.toggleClass('bu')
	});
</script>