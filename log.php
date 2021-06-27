<?php
include 'includes/dbcon.php';
?>

<?php
// Πλήθος Μαθηματων
$sql = "SELECT * FROM log ORDER BY time_of_update DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$number_of_changes = $stmt->rowCount();
$changes = $stmt->fetchAll();
?>

<?php
// Διαγραφή 
if (isset($_GET['delete_id'])) {
  $log_id = $_GET['delete_id'];

  $sql = "DELETE FROM log WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$log_id]);
  header("Location: " . $_SERVER["PHP_SELF"]);
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
      <a role="button" href="<?php $_SERVER['PHP_SELF']; ?>" class="btn-outline-light card border-left-danger shadow py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Ενημερωσεις</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_changes; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-wrench fa-3x text-gray-300"></i>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
  <div class="my-3">
    <h1 class="h3 mb-0 text-gray-800">Ενημερώσεις</h1>
  </div>
  <div class="shadow">
    <div class="card-body">
      <div class="table-responsive">
        <table id="adminChangesTable" class="table table-bordered table-hover editTable" style="width:100%">
          <thead>
            <tr>
              <th>Καθηγητής</th>
              <th>Μάθημα</th>
              <th>Τμήμα</th>
              <th>Πεδίο</th>
              <th>Παλιά τιμή</th>
              <th>Νέα τιμή</th>
              <th>Ημερομηνία / Ώρα</th>
              <th>Διαγραφή</th>
            </tr>
          </thead>
          <tbody>
            <!-- Εμφάνιση Λίστας  -->
            <?php
            foreach ($changes as $change) :
            ?>
              <tr>
                <td><a href="edit_lesson.php?lesson_id=<?php echo $change['lesson_id'] ?>" class="text-gray-600"><?php echo $change['teacher_id']; ?></a></td>
                <td><?php echo $change['lesson_id']; ?></td>
                <td><?php echo $change['section']; ?></td>
                <td><?php echo $change['field']; ?></td>
                <td><?php echo $change['previous_value']; ?></td>
                <td><?php echo $change['new_value']; ?></td>
                <td><?php echo $change['time_of_update']; ?></td>
                <td class='editField'><a href="log.php?delete_id=<?php echo $change['id']; ?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις τη συγκεκριμένη ενημέρωση;');"><i class='fas fa-trash-alt delete-item'></i></td>
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
    $('#adminChangesTable').DataTable();
  });

  $('tbody tr td:not(:last-child)').click(function() {
    var tr = $(this).closest('tr');
    window.location = tr.find('a').attr('href');
  });
  $('tbody tr td:not(:last-child)').hover(function() {
    var tr = $(this).closest('tr');
    tr.toggleClass('hover');
    console.log($(this));
  });
</script>