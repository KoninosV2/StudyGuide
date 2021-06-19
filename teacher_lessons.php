<?php
include 'includes/dbcon.php';
?>

<?php
$sql = "SELECT lesson.lesson_code, title, teacher2lesson.hours_teaching, teacher2lesson.hours_lab  
  FROM lesson, teacher2lesson 
  WHERE lesson.lesson_code = teacher2lesson.lesson_code AND teacher_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['user_id']]);
$lessons = $stmt->fetchAll();
$number_of_lessons = $stmt->rowCount();
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
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Διδασκόμενα Μαθήματα</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_lessons ?></div>
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
    <h1 class="h3 mb-0 text-gray-800">Λίστα Μαθημάτων</h1>
  </div>
  <!-- Πίνακας Μαθημάτων -->
  <div class="shadow">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Μαθήματα</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover editTable" style="width:100%">
          <thead>
            <tr>
              <th>Κωδικός</th>
              <th>Τίτλος</th>
              <th>Θεωρία</th>
              <th>Εργαστήριο</th>
              <th>Συνολικές Ώρες Διδασκαλίας</th>
              <th>Τροποποίηση</th>
            </tr>
          </thead>
          <tbody>
            <!-- Εμφάνιση Λίστας Μαθημάτων -->
            <?php

            foreach ($lessons as $lesson) :
            ?>
              <tr>
                <td><a href="lesson.php?lesson_id=<?php echo $lesson['lesson_code']; ?>" class="text-gray-600"><?php echo $lesson['lesson_code']; ?></a></td>
                <td><?php echo $lesson['title']; ?></td>
                <td><?php echo ($lesson['hours_teaching'] == 0) ? "-" : $lesson['hours_teaching']; ?></td>
                <td><?php echo ($lesson['hours_lab'] == 0) ? "-" : $lesson['hours_lab']; ?></td>
                <td><?php echo intval($lesson['hours_teaching']) + intval($lesson['hours_lab']); ?></td>
                <td class="editField"><a href="edit_lesson.php?lesson_id=<?php echo $lesson['lesson_code']; ?>"><i class="fas fa-edit text-warning"></i></a></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
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
    $('#dataTable').DataTable();
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