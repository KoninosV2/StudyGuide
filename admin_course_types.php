<?php
include 'includes/dbcon.php';
?>

<?php
// Πλήθος Μαθηματων
$sql = "SELECT * FROM type";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_course_types = $stmt->rowCount();
$types = $stmt->fetchAll();
?>

<?php
// Διαγραφή Τύπου
if (isset($_GET['type_id'])) {
  $type_id = $_GET['type_id'];

  $null = "ty-null";
  $sql = "UPDATE type2lesson set type_id = ? WHERE type_id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$null, $type_id]);

  $sql = "DELETE FROM type WHERE type_short_title = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$type_id]);
  header("Location: " . $_SERVER["PHP_SELF"]);
}
?>


<?php
// Εισαγωγή νέου τύπου
if (isset($_POST['submit'])) {
  $id = $_POST['type-id'];
  $title = $_POST['type-title'];
  $title_en = $_POST['type-title-en'];

  $sql = "INSERT INTO type (type_title, type_short_title, type_title_eng) VALUES (?, ?, ?)";
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
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Τυποι Μαθηματων</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_course_types; ?></div>
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
    <h1 class="h3 mb-0 text-gray-800">Τύποι Μαθημάτων</h1>
  </div>
  <div class="shadow">
    <div class="card-header py-3">
      <p>
        <a class="btn btn-primary" data-toggle="collapse" href="#newCourseType" role="button" aria-expanded="false" aria-controls="newCourseType">
          Νέος Τύπος Μαθήματος
        </a>
      </p>
      <div class="collapse" id="newCourseType">
        <div class="card card-body">
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-type-form">
            <div class="form-row error-message error-lesson-type">
              <div class="alert alert-danger" role="alert">
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-2 required">
                <label for="type-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                <input type="text" class="form-control" name="type-id" id="type-id">
              </div>
              <div class="form-group col-md-5 required">
                <label for="type-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος:</label>
                <input type="text" class="form-control" name="type-title" id="type-title">
              </div>
              <div class="form-group col-md-5">
                <label for="type-title-en" class="font-weight-bold text-gray-800 col-form-label">Τίτλος (ΕΝ):</label>
                <input type="text" class="form-control" name="type-title-en" id="type-title-en">
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
            <!-- Εμφάνιση Λίστας Μαθημάτων -->
            <?php
            foreach ($types as $type) :
            ?>
              <tr>
                <td><?php echo $type['type_short_title']; ?></td>
                <td><?php echo $type['type_title']; ?></td>
                <td><?php echo $type['type_title_eng']; ?></td>
                <td class='editField'><a href="edit_course_types.php?type_id=<?php echo $type['type_short_title']; ?>"><i class="far fa-edit  text-warning"></i></a></td>
                <td class='editField'><a href="admin_course_types.php?type_id=<?php echo $type['type_short_title']; ?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τον συγκεκριμένο τύπο μαθήματος;');"><i class='fas fa-trash-alt delete-item'></i></td>
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

</script>