<?php
  include 'includes/dbcon.php';
?>

<?php
  if(isset($_POST['submit'])){
    $book_id = $_POST['book-id'];
    $book_edition = $_POST['book-edition'];
    $book_year = $_POST['book-year'];
    $book_title = $_POST['book-title'];
    $book_authors = $_POST['book-authors'];
    $book_publisher = $_POST['book-editor'];
    $book_eudoxus_id = $_POST['book-eudoxus-id'];
    $book_isbn = $_POST['book-isbn'];

    $sql = "INSERT INTO book (id, title, authors, publisher, edition, year, eudoxus_id, isbn) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$book_id, $book_title, $book_authors, $book_publisher, $book_edition, $book_year, $book_eudoxus_id, $book_isbn]);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
?>

<?php
  if(isset($_GET['book_id'])){
    $book_id = $_GET['book_id'];
    $sql = "DELETE FROM book WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$book_id]);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
?>

<?php
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
              <a role="button" href="#" class="btn-outline-light card border-left-primary shadow py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Βιβλιογραφία</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $number_of_books; ?></div>
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
        <h1 class="h3 mb-0 text-gray-800">Βιβλιογραφία</h1>
      </div>
      <div class="shadow">
        <div class="card-header py-3">
          <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#newBook" role="button" aria-expanded="false" aria-controls="newBook">
              Εισαγωγή Συγγράμματος
            </a>
          </p>
          <div class="collapse" id="newBook">
            <div class="card card-body">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-book-form"> 
                <div class="form-row error-message error-new-book">
									<div class="alert alert-danger" role="alert">
									</div>
							  </div>
                <div class="form-row">
                  <div class="form-group col-md-4 required">
                    <label for="book-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                    <input type="text" class="form-control" name="book-id" id="book-id">
                  </div>
                  <div class="form-group col-md-8 required">
                    <label for="book-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Συγγράμματος</label>
                    <input type="text" class="form-control" name="book-title" id="book-title">
                  </div>
                </div>

                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="book-edition" class="font-weight-bold text-gray-800 col-form-label">Έκδοση:</label>
                    <input type="text" class="form-control" name="book-edition" id="book-edition">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="book-year" class="font-weight-bold text-gray-800 col-form-label">Έτος Έκδοσης:</label>
                    <input type="text" class="form-control" name="book-year" id="book-year">
                  </div>
                </div>
                
                <div class="form-group">
                  <label for="book-authors" class="font-weight-bold text-gray-800 col-form-label">Συγγραφείς:</label>
                  <input type="text" class="form-control" name="book-authors" id="book-authors">
                </div>
                <div class="form-row">
                  <div class="form-group col-md-4">
                    <label for="book-editor" class="font-weight-bold text-gray-800 col-form-label">Εκδότης:</label>
                    <input type="text" class="form-control" name="book-editor" id="book-editor">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="book-eudoxus-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός στον Εύδοξο:</label>
                    <input type="text" class="form-control" name="book-eudoxus-id" id="book-eudoxus-id">
                  </div>
                  <div class="form-group col-md-4">
                    <label for="book-isbn" class="font-weight-bold text-gray-800 col-form-label">ISBN:</label>
                    <input type="text" class="form-control" name="book-isbn" id="book-isbn">
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
              <table id="adminCourseTable" class="table table-bordered table-hover editTable" style="width:100%">
                <thead>
                  <tr>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Συγγραφείς</th>
                    <th>Τροποποίση</th>
                    <th>Διαγραφή</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση Λίστας  -->
                  <?php
                    foreach($books as $book): 
                  ?>  
                      <tr>
                        <td><a href=book.php?book_id=<?php echo $book['id']; ?> class="text-gray-600"><?php echo $book['id']; ?></a></td>
                        <td><?php echo $book['title']; ?></td>
                        <td><?php echo $book['authors']; ?></td>
                        <td class='editField'><a href="edit_book.php?book_id=<?php echo $book['id'];?>"><i class="far fa-edit text-warning"></i></a></td>
                        <td class='editField'><a href="admin_books.php?book_id=<?php echo $book['id'];?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις το συγκεκριμένο βιβλίο;');"><i class='fas fa-trash-alt delete-item'></i></td>
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