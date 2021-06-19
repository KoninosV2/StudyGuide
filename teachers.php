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


<?php include "includes/header.php"; ?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="mb-3">
    <h1 class="h3 mb-0 text-gray-800">Σύνοψη</h1>
  </div>
  <div class="row">
    <div class="col-xl-3 col-md-6 mb-4">
      <a role="button" href="teachers.php" class="btn-outline-light card border-left-warning shadow py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Καθηγητές</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_teachers; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-chalkboard-teacher fa-3x text-gray-300"></i>
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
    <div class="card-body">
      <div class="table-responsive">
        <table id="adminCourseTable" class="table table-bordered table-hover" style="width:100%">
          <thead>
            <tr>
              <th>Επώνυμο</th>
              <th>Όνομα</th>
              <th>Θέση</th>
              <th>Email</th>
            </tr>
          </thead>
          <tbody>
            <!-- Εμφάνιση Λίστας  -->
            <?php
            foreach ($teachers as $teacher) :
              if ($teacher['name'] !== "" && $teacher['id'] !== "[Οικονομικό]" && $teacher['id'] !== "[Συμβασιούχος]") :
            ?>
                <tr>
                  <td><?php echo $teacher['surname']; ?></td>
                  <td><?php echo $teacher['name']; ?></td>
                  <td><?php echo $teacher['lvl']; ?></td>
                  <td><?php echo $teacher['email']; ?></td>
                </tr>
              <?php endif; ?>
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
</script>