<?php include 'includes/dbcon.php'; ?>

<?php
  if(isset($_GET['teacher_id'])){
    $teacher_id = $_GET['teacher_id'];
    $sql = "SELECT * FROM teacher WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$teacher_id]);
    $teacher = $stmt->fetch();
    }
?>

<?php
  if(isset($_POST['teacher-update'])){
    $id = $_POST['teacher-id'];
    $surname = $_POST['teacher-surname'];
    $name = $_POST['teacher-name'];
    $lvl = $_POST['teacher-position'];
    $email = $_POST['teacher-email'];
    $phone = $_POST['teacher-phone'];
    $notes = $_POST['teacher-notes'];
    $surname_eng = $_POST['teacher-surname-eng'];
    $name_eng = $_POST['teacher-name-eng'];
    $lvl_eng = $_POST['teacher-position-eng'];

    $sql = 'UPDATE teacher SET name = ?, surname = ?, lvl = ?, email = ?,
            phone = ?, notes = ?, name_eng = ?, surname_eng = ?, lvl_eng = ? 
            WHERE id = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $surname, $lvl, $email, $phone, $notes, $name_eng, $surname_eng, $lvl_eng, $id]);
    header("Location: admin_teachers.php");
  }
?>

<?php
  if(isset($_POST['book-update'])){
    $book_id = $_POST['book-id'];
    $book_edition = $_POST['book-edition'];
    $book_year = $_POST['book-year'];
    $book_title = $_POST['book-title'];
    $book_authors = $_POST['book-authors'];
    $book_publisher = $_POST['book-editor'];
    $book_eudoxus_id = $_POST['book-eudoxus-id'];
    $book_isbn = $_POST['book-isbn'];

    $sql = "UPDATE book set title = ?, authors = ?, publisher = ?, edition = ?, year = ?, eudoxus_id = ?, isbn = ? WHERE id = ? ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$book_title, $book_authors, $book_publisher, $book_edition, $book_year, $book_eudoxus_id, $book_isbn, $book_id]);
    header('Location: book.php?book_id='.$book_id);
  }
?>

<?php include "includes/header.php";?>

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="mb-3">
      <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
				<?php echo $teacher['surname'] . ' ' . $teacher['name'];?> [<?php echo $teacher['id']; ?>]
			</h1>
    </div>
    <div class="card shadow border-warning mb-3">
      <div class="card-body edit-lesson">
        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST">
          <div class="form-row">
            <div class="form-group col-md-4">
              <label for="teacher-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
              <input type="text" class="form-control" name="teacher-id" value="<?php echo $teacher['id']; ?>" readonly>
            </div>
            <div class="form-group col-md-4">
              <label for="teacher-surname" class="font-weight-bold text-gray-800 col-form-label">Έπώνυμο:</label>
              <input type="text" class="form-control" name="teacher-surname" value='<?php echo $teacher['surname']; ?>'>
            </div>
            <div class="form-group col-md-4">
              <label for="teacher-name" class="font-weight-bold text-gray-800 col-form-label">Όνομα:</label>
              <input type="text" class="form-control" name="teacher-name" value='<?php echo $teacher['name']; ?>'>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4">
            <label for="teacher-position" class="font-weight-bold text-gray-800 col-form-label">Θέση:</label>
              <input type="text" class="form-control" name="teacher-position" value='<?php echo $teacher['lvl']; ?>'>
            </div>
            <div class="form-group col-md-4">
              <label for="teacher-email" class="font-weight-bold text-gray-800 col-form-label">Email:</label>
              <input type="text" class="form-control" name="teacher-email" value='<?php echo $teacher['email']; ?>'>
            </div>
            <div class="form-group col-md-4">
              <label for="teacher-phone" class="font-weight-bold text-gray-800 col-form-label">Τηλέφωνο:</label>
              <input type="text" class="form-control" name="teacher-phone" value='<?php echo $teacher['phone']; ?>'>
            </div>
          </div>
          <div class="form-row">
            <label for="teacher-notes" class="font-weight-bold text-gray-800 col-form-label">Παρατηρήσεις:</label>
            <textarea class="form-control" name="teacher-notes" cols="20" rows="3"><?php echo $teacher['notes'];?></textarea>
          </div>
          <div class="form-row mt-3">
            <div class="form-group col-md-4">
              <label for="teacher-surname-eng" class="font-weight-bold text-gray-800 col-form-label">Επώνυμο (ΕΝ):</label>
              <input type="text" class="form-control" name="teacher-surname-eng" value='<?php echo $teacher['surname_eng']; ?>'>
            </div>
            <div class="form-group col-md-4">
              <label for="teacher-name-eng" class="font-weight-bold text-gray-800 col-form-label">Όνομα (ΕΝ):</label>
              <input type="text" class="form-control" name="teacher-name-eng" value='<?php echo $teacher['name_eng']; ?>'>
            </div>
            <div class="form-group col-md-4">
              <label for="teacher-positition-eng" class="font-weight-bold text-gray-800 col-form-label">Θέση (ΕΝ):</label>
              <input type="text" class="form-control" name="teacher-position-eng" value='<?php echo $teacher['lvl_eng']; ?>'>
            </div>
          </div>     
					<button type="submit" name="teacher-update" class="btn btn-primary float-right">Ενημέρωση</button>
        </form>
			</div>
    </div>          	
	<!-- /.container-fluid -->
  </div>										
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>  

