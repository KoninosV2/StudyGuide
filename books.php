<?php
  include 'includes/dbcon.php';
?>


<?php
  // Πλήθος Μαθηματων
  $sql = "SELECT * FROM book";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_books = $stmt->rowCount();
  $books = $stmt->fetchAll();
?>
<?php include "includes/header.php"; ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <div class="mb-3">
            <h1 class="h3 mb-0 text-gray-800">Σύνοψη</h1>
          </div>
           <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
              <a role="button" href="books.php" class="btn-outline-light card border-left-success shadow py-2">
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
			    </div>
      <div class="my-3">
        <h1 class="h3 mb-0 text-gray-800">Συγγράμματα</h1>
      </div>
      <div class="shadow">
        <div class="card-body">
          <div class="table-responsive">
              <table id="adminCourseTable" class="table table-bordered table-hover" style="width:100%">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Συγγραφείς</th>
                    <th>Εκδότης</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση Λίστας  -->
                  <?php
                    foreach($books as $book): 
                      if($book['id'] !== "notes" && $book['id'] !== "articles"):
                  ?>  
                        <tr>
                          <td><?php echo $book['id']; ?></a></td>
                          <td><?php echo $book['title']; ?></td>
                          <td><?php echo $book['authors']; ?></td>
                          <td><?php echo $book['publisher']; ?></td>
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
  $(document).ready( function () {
    $('#adminCourseTable').DataTable();
	});
</script>