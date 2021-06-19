<?php
include 'includes/dbcon.php';
?>

<?php
// Πλήθος Μαθηματων
$sql = "SELECT * FROM teacher";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_teachers = $stmt->rowCount();
$teachers = $stmt->fetchAll();
?>

<?php
if (isset($_GET['teacher_id'])) {
  $teacher_id = $_GET['teacher_id'];
  $sql = "DELETE FROM teacher WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$teacher_id]);
  header('Location: ' . $_SERVER['PHP_SELF']);
}
?>

<?php
if (isset($_POST['submit'])) {
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

  $sql = 'INSERT INTO teacher (id, name, surname, lvl, email, phone, notes, name_eng,       surname_eng, lvl_eng, role) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$id, $name, $surname, $lvl, $email, $phone, $notes, $name_eng, $surname_eng, $lvl_eng, $teacher_role]);
  header("Location: " . $_SERVER['PHP_SELF']);
}
?>

<?php include "includes/header.php"; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="mb-3">
    <h1 class="h3 mb-0 text-gray-800">Σύνοψη</h1>
  </div>
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <a role="button" href="#" class="btn-outline-light card border-left-primary shadow py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Καθηγητές</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_teachers; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-bookmark fa-3x text-gray-300"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="my-3">
    <h1 class="h3 mb-0 text-gray-800">Καθηγητές</h1>
  </div>
  <div class="shadow">
    <div class="card-header py-3">
      <p>
        <a class="btn btn-primary" data-toggle="collapse" href="#newTeacher" role="button" aria-expanded="false" aria-controls="newTeacher">
          Εισαγωγή Καθηγητή
        </a>
      </p>
      <div class="collapse" id="newTeacher">
        <div class="card card-body">
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-teacher-form">
            <div class="form-row error-message error-new-teacher">
              <div class="alert alert-danger" role="alert">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-3 required">
                <label for="teacher-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                <input type="text" class="form-control" name="teacher-id" id="teacher-id">
              </div>
              <div class="form-group col-md-3 required">
                <label for="teacher-surname" class="font-weight-bold text-gray-800 col-form-label">Έπώνυμο:</label>
                <input type="text" class="form-control" name="teacher-surname" id="teacher-surname">
              </div>
              <div class="form-group col-md-3 required">
                <label for="teacher-name" class="font-weight-bold text-gray-800 col-form-label">Όνομα:</label>
                <input type="text" class="form-control" name="teacher-name" id="teacher-name">
              </div>
              <div class="form-group col-md-3 required">
                <label for="teacher-role" class="font-weight-bold text-gray-800 col-form-label">Ρόλος:</label>
                <select name="teacher-role" id="teacher-role" class="form-control">
                  <option value="user">Χρήστης</option>
                  <option value="admin">Admin</option>
                </select>
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 required">
                <label for="teacher-position" class="font-weight-bold text-gray-800 col-form-label">Θέση:</label>
                <input type="text" class="form-control" name="teacher-position" id="teacher-position">
              </div>
              <div class="form-group col-md-4 required">
                <label for="teacher-email" class="font-weight-bold text-gray-800 col-form-label">Email:</label>
                <input type="text" class="form-control" name="teacher-email" id="teacher-email">
              </div>
              <div class="form-group col-md-4 required">
                <label for="teacher-phone" class="font-weight-bold text-gray-800 col-form-label">Τηλέφωνο:</label>
                <input type="text" class="form-control" name="teacher-phone" id="teacher-phone">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 required">
                <label for="teacher-surname-eng" class="font-weight-bold text-gray-800 col-form-label">Επώνυμο (ΕΝ):</label>
                <input type="text" class="form-control" name="teacher-surname-eng" id="teacher-surname-eng">
              </div>
              <div class="form-group col-md-4 required">
                <label for="teacher-name-eng" class="font-weight-bold text-gray-800 col-form-label">Όνομα (ΕΝ):</label>
                <input type="text" class="form-control" name="teacher-name-eng" id="teacher-name-eng">
              </div>
              <div class="form-group col-md-4 required">
                <label for="teacher-positition-eng" class="font-weight-bold text-gray-800 col-form-label">Θέση (ΕΝ):</label>
                <input type="text" class="form-control" name="teacher-position-eng" id="teacher-position-eng">
              </div>
            </div>
            <div class="form-row">
              <label for="teacher-notes" class="font-weight-bold text-gray-800 col-form-label">Παρατηρήσεις:</label>
              <textarea class="form-control" name="teacher-notes" id="teacher-notes" cols="20" rows="3"></textarea>
            </div>
            <div class="form-group mt-3">
              <input type="submit" class="btn btn-success float-right" name="submit">
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="adminCourseTable" class="table table-bordered table-hover editTable" style="width:100%">
          <thead>
            <tr>
              <th>Επώνυμο</th>
              <th>Όνομα</th>
              <th>Θέση</th>
              <th>Email</th>
              <th>Ρόλος</th>
              <th>Τροποποίση</th>
              <th>Διαγραφή</th>
            </tr>
          </thead>
          <tbody>
            <!-- Εμφάνιση Λίστας  -->
            <?php
            foreach ($teachers as $teacher) :
            ?>
              <tr>
                <td><a href="teacher.php?teacher_id=<?php echo $teacher['id']; ?>" class="text-gray-600"><?php echo $teacher['surname']; ?></a></td>
                <td><?php echo $teacher['name']; ?></td>
                <td><?php echo $teacher['lvl']; ?></td>
                <td><?php echo $teacher['email']; ?></td>
                <td><?php echo $teacher['role'] === "user" ? "Χρήστης" : "Admin"; ?></td>
                <td class='editField'><a href="edit_teacher.php?teacher_id=<?php echo $teacher['id']; ?>"><i class="far fa-edit text-warning"></i></a></td>
                <td class='editField'><a href="admin_teachers.php?teacher_id=<?php echo $teacher['id']; ?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τον συγκεκριμένο καθηγητή;');"><i class='fas fa-trash-alt delete-item'></i></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>
<script>
  $(document).ready(function() {
    $('#adminCourseTable').DataTable();
  });

  $('tbody tr td:not(:last-child, :nth-child(6))').click(function() {
    var tr = $(this).closest('tr');
    window.location = tr.find('a').attr('href');
  });
  $('tbody tr td:not(:last-child, :nth-child(6))').hover(function() {
    var tr = $(this).closest('tr');
    tr.toggleClass('hover');
    console.log($(this));
  });
</script>