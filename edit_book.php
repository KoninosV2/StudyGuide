<?php include 'includes/dbcon.php'; ?>

<?php
if (isset($_GET['book_id'])) {
  $book_id = $_GET['book_id'];
  $sql = "SELECT * FROM book WHERE id = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$book_id]);
  $book = $stmt->fetch();
}
?>

<?php
if (isset($_POST['type-update'])) {
  $id = $_POST['type-short-title'];
  $title = $_POST['type-title'];
  $title_en = $_POST['type-title-en'];

  $sql = 'UPDATE type SET type_title = ?, type_title_eng = ? WHERE type_short_title = ?';
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$title, $title_en, $id]);
  header("Location: admin_course_types.php");
}
?>

<?php
if (isset($_POST['book-update'])) {
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
  header('Location: book.php?book_id=' . $book_id);
}
?>

<?php include "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="mb-3">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      <?php echo $book['title']; ?> [<?php echo $book['id']; ?>]
    </h1>
  </div>
  <div class="card shadow mb-3">
    <div class="card-body edit-lesson">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="update-book-form">
        <div class="form-row error-message error-update-book">
          <div class="alert alert-danger" role="alert">
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4 required">
            <label for="book-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
            <input type="text" class="form-control" name="book-id" id="book-id" value="<?php echo $book['id']; ?>" readonly>
          </div>
          <div class="form-group col-md-8  required">
            <label for="book-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Συγγράμματος</label>
            <input type="text" class="form-control" name="book-title" id="book-title" value='<?php echo $book['title']; ?>'>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="book-edition" class="font-weight-bold text-gray-800 col-form-label">Έκδοση:</label>
            <input type="text" class="form-control" name="book-edition" id="book-edition" value='<?php echo $book['edition']; ?>'>
          </div>
          <div class="form-group col-md-6">
            <label for="book-year" class="font-weight-bold text-gray-800 col-form-label">Έτος Έκδοσης:</label>
            <input type="text" class="form-control" name="book-year" id="book-year" value='<?php echo $book['year']; ?>'>
          </div>
        </div>

        <div class="form-group">
          <label for="book-authors" class="font-weight-bold text-gray-800 col-form-label">Συγγραφείς:</label>
          <input type="text" class="form-control" name="book-authors" value='<?php echo $book['authors']; ?>'>
        </div>
        <div class="form-row">
          <div class="form-group col-md-4">
            <label for="book-editor" class="font-weight-bold text-gray-800 col-form-label">Εκδότης:</label>
            <input type="text" class="form-control" name="book-editor" value='<?php echo $book['publisher']; ?>'>
          </div>
          <div class="form-group col-md-4">
            <label for="book-eudoxus-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός στον Εύδοξο:</label>
            <input type="text" class="form-control" name="book-eudoxus-id" id="book-eudoxus-id" value='<?php echo $book['eudoxus_id']; ?>'>
          </div>
          <div class="form-group col-md-4">
            <label for="book-isbn" class="font-weight-bold text-gray-800 col-form-label">ISBN:</label>
            <input type="text" class="form-control" name="book-isbn" value='<?php echo $book['isbn']; ?>'>
          </div>
        </div>
        <button type="submit" name="book-update" class="btn btn-primary float-right">Ενημέρωση</button>
        <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
      </form>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>