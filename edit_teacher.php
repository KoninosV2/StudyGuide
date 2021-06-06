<?php include 'includes/dbcon.php'; ?>

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
if (isset($_POST['teacher-update'])) {
  $id = $_POST['teacher-id'];
  $surname = $_POST['teacher-surname'];
  $name = $_POST['teacher-name'];
  $lvl = $_POST['teacher-position'];
  $email = $_POST['teacher-email'];
  $phone = $_POST['teacher-phone'];
  $notes = $_POST['teacher-notes'];
  $surname_eng = $_POST['teacher-surname-eng'];
  $name_eng = $_POST['teacher-name-eng'];
  $lvl_eng = $_POST['teacher-position-eng'];
  $teacher_role = $_POST['teacher-role'];

  $sql = 'UPDATE teacher SET name = ?, surname = ?, lvl = ?, email = ?,
            phone = ?, notes = ?, name_eng = ?, surname_eng = ?, lvl_eng = ?, role = ? 
            WHERE id = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$name, $surname, $lvl, $email, $phone, $notes, $name_eng, $surname_eng, $lvl_eng, $teacher_role, $id]);
  header("Location: teacher.php?teacher_id=" . $id . "#section-one");
}
?>



<?php include "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="mb-3">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      <?php echo $teacher['surname'] . ' ' . $teacher['name']; ?> [<?php echo $teacher['id']; ?>]
    </h1>
  </div>
  <div class="card shadow mb-3">
    <div class="card-body edit-lesson">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="edit-teacher-form">
        <div class="form-row error-message error-edit-teacher">
          <div class="alert alert-danger" role="alert">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-3 required">
            <label for="teacher-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
            <input type="text" class="form-control" name="teacher-id" id="teacher-id" value="<?php echo $teacher['id']; ?>" readonly>
          </div>
          <div class="form-group col-md-3 required">
            <label for="teacher-surname" class="font-weight-bold text-gray-800 col-form-label">Έπώνυμο:</label>
            <input type="text" class="form-control" id="teacher-surname" name="teacher-surname" value='<?php echo $teacher['surname']; ?>'>
          </div>
          <div class="form-group col-md-3 required">
            <label for="teacher-name" class="font-weight-bold text-gray-800 col-form-label">Όνομα:</label>
            <input type="text" class="form-control" id="teacher-name" name="teacher-name" value='<?php echo $teacher['name']; ?>'>
          </div>
          <div class="form-group col-md-3 required">
            <label for="teacher-role" class="font-weight-bold text-gray-800 col-form-label">Ρόλος:</label>
            <select class="form-control" name="teacher-role" id="teacher-role">
              <?php if ($teacher['role'] === "user") : ?>
                <option value="user" selected>Χρήστης</option>
                <option value="admin">Admin</option>
              <?php else : ?>
                <option value="user">Χρήστης</option>
                <option value="admin" selected>Admin</option>
              <?php endif; ?>
            </select>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4 required">
            <label for="teacher-position" class="font-weight-bold text-gray-800 col-form-label">Θέση:</label>
            <input type="text" class="form-control" id="teacher-position" name="teacher-position" value='<?php echo $teacher['lvl']; ?>'>
          </div>
          <div class="form-group col-md-4 required">
            <label for="teacher-email" class="font-weight-bold text-gray-800 col-form-label">Email:</label>
            <input type="text" class="form-control" id="teacher-email" name="teacher-email" value='<?php echo $teacher['email']; ?>'>
          </div>
          <div class="form-group col-md-4 required">
            <label for="teacher-phone" class="font-weight-bold text-gray-800 col-form-label">Τηλέφωνο:</label>
            <input type="text" class="form-control" id="teacher-phone" name="teacher-phone" value='<?php echo $teacher['phone']; ?>'>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4 required">
            <label for="teacher-surname-eng" class="font-weight-bold text-gray-800 col-form-label">Επώνυμο (ΕΝ):</label>
            <input type="text" class="form-control" id="teacher-surname-eng" name="teacher-surname-eng" value='<?php echo $teacher['surname_eng']; ?>'>
          </div>
          <div class="form-group col-md-4 required">
            <label for="teacher-name-eng" class="font-weight-bold text-gray-800 col-form-label">Όνομα (ΕΝ):</label>
            <input type="text" class="form-control" id="teacher-name-eng" name="teacher-name-eng" value='<?php echo $teacher['name_eng']; ?>'>
          </div>
          <div class="form-group col-md-4 required">
            <label for="teacher-positition-eng" class="font-weight-bold text-gray-800 col-form-label">Θέση (ΕΝ):</label>
            <input type="text" class="form-control" id="teacher-position-eng" name="teacher-position-eng" value='<?php echo $teacher['lvl_eng']; ?>'>
          </div>
        </div>
        <div class="form-row mb-3">
          <label for="teacher-notes" class="font-weight-bold text-gray-800 col-form-label">Παρατηρήσεις:</label>
          <textarea class="form-control" name="teacher-notes" id="teacher-notes" cols="20" rows="3"><?php echo $teacher['notes']; ?></textarea>
        </div>
        <button type="submit" name="teacher-update" class="btn btn-primary float-right">Ενημέρωση</button>
        <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
      </form>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>