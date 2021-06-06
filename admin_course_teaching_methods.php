<?php
include 'includes/dbcon.php';
?>

<?php
// Πλήθος Μαθηματων
$sql = "SELECT * FROM teaching";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_teaching_methods = $stmt->rowCount();
$methods = $stmt->fetchAll();
?>


<?php
if (isset($_GET['teaching_id'])) {
  $teaching_short_title = $_GET['teaching_id'];
  $sql = "DELETE FROM teaching WHERE teaching_short_title = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$teaching_short_title]);
  header('Location: ' . $_SERVER['PHP_SELF']);
}
?>

<?php
if (isset($_POST['submit'])) {
  $teaching_short_title = $_POST['teaching-short-title'];
  $teaching_order = $_POST['teaching-order'];
  $teaching_title = $_POST['teaching-title'];
  $teaching_title_en = $_POST['teaching-title-en'];

  $sql = "INSERT INTO teaching (teaching_title, teaching_short_title, teaching_title_eng, teaching_order) VALUES (?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$teaching_title, $teaching_short_title, $teaching_title_en, $teaching_order]);
  header('Location: ' . $_SERVER['PHP_SELF']);
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
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Μέθοδοι Διδασκαλίας</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_teaching_methods; ?></div>
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
    <h1 class="h3 mb-0 text-gray-800">Μέθοδοι Διδασκαλίας</h1>
  </div>
  <!-- Πίνακας με τους τρόπους παράδοσης -->
  <div class="shadow">
    <div class="card-header py-3">
      <p>
        <a class="btn btn-primary" data-toggle="collapse" href="#newTeachingMethod" role="button" aria-expanded="false" aria-controls="newTeachingMethod">
          Νέα Μέθοδος Διδασκαλίας
        </a>
      </p>
      <div class="collapse" id="newTeachingMethod">
        <div class="card card-body">
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-teaching-method-form">
            <div class="form-row error-message error-new-teaching-methods">
              <div class="alert alert-danger" role="alert">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-4 required">
                <label for="teaching-order" class="font-weight-bold text-gray-800 col-form-label">A/A:</label>
                <input type="text" class="form-control" name="teaching-order" id="teaching-order">
              </div>
              <div class="form-group col-md-4 required">
                <label for="teaching-short-title" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                <input type="text" class="form-control" id="teaching-short-title" name="teaching-short-title">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6 required">
                <label for="teaching-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος:</label>
                <input type="text" class="form-control" id="teaching-title" name="teaching-title">
              </div>
              <div class="form-group col-md-6">
                <label for="teaching-title-en" class="font-weight-bold text-gray-800 col-form-label">Τίτλος (ΕΝ):</label>
                <input type="text" class="form-control" name="teaching-title-en">
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
      <div class="table-responsive">
        <table id="adminCategoriesTable" class="table table-bordered table-hover editTable" style="width:100%">
          <thead>
            <tr>
              <th>A/A</th>
              <th>Κωδικός</th>
              <th>Τίτλος</th>
              <th>Τίτλος(En)</th>
              <th>Τροποποίση</th>
              <th>Διαγραφή</th>
            </tr>
          </thead>
          <tbody>
            <!-- Εμφάνιση δεδομένω από ΒΔ-->
            <?php
            foreach ($methods as $method) :
            ?>
              <tr>
                <td><?php echo $method['teaching_order']; ?></td>
                <td><?php echo $method['teaching_short_title']; ?></td>
                <td><?php echo $method['teaching_title']; ?></td>
                <td><?php echo $method['teaching_title_eng']; ?></td>
                <td class='editField'><a href="edit_course_teaching_methods.php?teaching_id=<?php echo $method['teaching_short_title']; ?>"><i class="far fa-edit text-warning"></i></a></td>
                <td class='editField'><a href="admin_course_teaching_methods.php?teaching_id=<?php echo $method['teaching_short_title']; ?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τη συγκεκριμένη μέθοδο διδασκαλίας;');"><i class='fas fa-trash-alt delete-item'></i></td>
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
    $('#adminCategoriesTable').DataTable();
  });
</script>