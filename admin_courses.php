<?php
  include 'includes/dbcon.php';
?>

<?php
  // Πλήθος Μαθηματων
  $sql = "SELECT lesson_code, title, semester, ects, cat_title  
  FROM lesson, lesson_cat 
  WHERE lesson.cat_id = lesson_cat.cat_short_title";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_lessons = $stmt->rowCount();
  $lessons = $stmt->fetchAll();
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
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Μαθήματα</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $number_of_lessons; ?></div>
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
        <h1 class="h3 mb-0 text-gray-800">Λίστα Μαθημάτων</h1>
      </div>
      <div class="shadow">
        
        <div class="card-header py-3">
          <p>
            <a class="btn btn-primary" href="add_new_lesson.php" role="button">
              Εισαγωγή Μαθήματος
            </a>
          </p>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="adminCourseTable" class="table table-bordered table-hover editTable" style="width:100%">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Κατηγορία</th>
                    <th>Τροποποίση</th>
                    <th>Διαγραφή</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση Λίστας Μαθημάτων -->
                  <?php
                    foreach($lessons as $lesson): 
                  ?>  
                      <tr>
                        <td><a href="lesson.php?lesson_id=<?php echo $lesson['lesson_code']; ?>" class="text-gray-600"><?php echo $lesson['lesson_code']; ?></a></td>
                        <td><?php echo $lesson['title']; ?></td>
                        <td><?php echo $lesson['cat_title']; ?></td>
                        <td class='editField'><a href="edit_lesson.php?lesson_id=<?php echo $lesson['lesson_code'];?>"><i class="far fa-edit text-warning"></i></a></td>
                        <td class='editField'><a href="edit_lesson.php?delete_id=<?php echo $lesson['lesson_code'];?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις το συγκεκριμένο μαθήμα;');"><i class='fas fa-trash-alt delete-item'></i></td>
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
  $(document).ready( function () {
    $('#adminCourseTable').DataTable();
	});

  $('tbody tr td:not(:last-child, :nth-child(4))').click( function() {
    var tr = $(this).closest('tr');
    window.location = tr.find('a').attr('href');
  });
  $('tbody tr td:not(:last-child, :nth-child(4))').hover(function() {
    var tr = $(this).closest('tr');
   tr.toggleClass('hover');
    console.log($(this));
  });
</script>