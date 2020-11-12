<?php
  include 'includes/dbcon.php';
?>

<?php
  // Πλήθος Μαθηματων
  $sql = "SELECT * FROM lesson";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_lessons = $stmt->rowCount();

  // Πλήθος Συγγραμμάτων
  $sql = "SELECT * FROM book";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_books = $stmt->rowCount();

  // Πλήθος Καθηγητών
  $sql = "SELECT * FROM teacher";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_teachers = $stmt->rowCount();
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

            <div class="col-xl-3 col-md-6 mb-4">
              <a role="button" href="#" class="btn-outline-light card border-left-success shadow py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Συγγράμματα</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $number_of_books; ?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-book fa-3x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
              <a role="button" href="#" class="btn-outline-light card border-left-warning shadow py-2">
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
        <h1 class="h3 mb-0 text-gray-800">Λίστα Μαθημάτων</h1>
      </div>
      <!-- Πίνακας Μαθημάτων -->
      <div class="shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Μαθήματα</h6>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="dataTable" class="table table-bordered table-hover" style="width:100%">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Κατηγορία</th>
                    <th>Εξάμηνο</th>
                    <th>Μονάδες ECTS</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση Λίστας Μαθημάτων -->
                  <?php
                    $sql = "SELECT lesson_code, title, semester, ects, cat_title  
                            FROM lesson, lesson_cat 
                            WHERE lesson.cat_id = lesson_cat.cat_short_title";
						        $stmt = $pdo->prepare($sql);
                    $stmt->execute();
                    $lessons = $stmt->fetchAll();
                    foreach($lessons as $lesson): 
                  ?>  
                      <tr>
                        <td><a href="lesson.php?lesson_id=<?php echo $lesson['lesson_code']; ?>" class="text-gray-600"><?php echo $lesson['lesson_code']; ?></a></td>
                        <td><?php echo $lesson['title']; ?></td>
                        <td><?php echo $lesson['cat_title']; ?></td>
                        <td><?php echo $lesson['semester']; ?></td>
                        <td><?php echo $lesson['ects']; ?></td>
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
    $('#dataTable').DataTable();
	});

  $('tbody>tr').click( function() {
    window.location = $(this).find('a').attr('href');
    }).hover( function() {
    $(this).toggleClass('hover');
  });
</script>