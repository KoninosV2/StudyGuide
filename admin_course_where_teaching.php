<?php
include 'includes/dbcon.php';
?>

<?php
// Πλήθος Μαθηματων
$sql = "SELECT * FROM whereteaching";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_places = $stmt->rowCount();
$places = $stmt->fetchAll();
?>

<?php
// Διαγραφή 
if (isset($_GET['where_id'])) {
  $where_id = $_GET['where_id'];

  $null = "wh-null";
  $sql = "UPDATE lesson set where_id = ? WHERE where_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$null, $where_id]);

  $sql = "DELETE FROM whereteaching WHERE where_short_title = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$where_id]);
  header("Location: " . $_SERVER["PHP_SELF"]);
}
?>

<?php
// Εισαγωγή νέου τύπου
if (isset($_POST['submit'])) {
  $id = $_POST['where-short-title'];
  $title = $_POST['where-title'];
  $title_en = $_POST['where-title-en'];

  $sql = "INSERT INTO whereteaching (where_title, where_short_title, where_title_eng) VALUES (?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$title, $id, $title_en]);
  header('Location: ' . $_SERVER["PHP_SELF"]);
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
      <a role="button" href="<?php $_SERVER['PHP_SELF']; ?>" class="btn-outline-light card border-left-primary shadow py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Τροποι Παραδοσης</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_places; ?></div>
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
    <h1 class="h3 mb-0 text-gray-800">Τρόποι Παράδοσης</h1>
  </div>
  <!-- Πίνακας με τους τρόπους παράδοσης -->
  <div class="shadow">
    <div class="card-header py-3">
      <p>
        <a class="btn btn-primary" data-toggle="collapse" href="#newWhereTeaching" role="button" aria-expanded="false" aria-controls="newWhereTeaching">
          Νέος Τρόπος Παράδοσης
        </a>
      </p>
      <div class="collapse" id="newWhereTeaching">
        <div class="card card-body">
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-where-teaching-form">
            <div class="form-row error-message error-lesson-where-teaching">
              <div class="alert alert-danger" role="alert">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2 required">
                <label for="where-short-title" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                <input type="text" class="form-control" name="where-short-title" id="where-short-title">
              </div>
              <div class="form-group col-md-5 required">
                <label for="where-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος:</label>
                <input type="text" class="form-control" name="where-title" id="where-title">
              </div>
              <div class="form-group col-md-5">
                <label for="where-title-en" class="font-weight-bold text-gray-800 col-form-label">Τίτλος (ΕΝ):</label>
                <input type="text" class="form-control" name="where-title-en" id="where-title-eng">
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
            foreach ($places as $place) :
            ?>
              <tr>
                <td><?php echo $place['where_short_title']; ?></td>
                <td><?php echo $place['where_title']; ?></td>
                <td><?php echo $place['where_title_eng']; ?></td>
                <td class='editField'><a href="edit_where_teaching.php?where_id=<?php echo $place['where_short_title']; ?>"><i class="far fa-edit text-warning"></i></a></td>
                <td class='editField'><a href="admin_course_where_teaching.php?where_id=<?php echo $place['where_short_title']; ?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τον συγκεκριμένο αντικείμενο;');"><i class='fas fa-trash-alt delete-item'></i></td>
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