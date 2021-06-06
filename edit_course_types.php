<?php include 'includes/dbcon.php'; ?>

<?php
if (isset($_GET['type_id'])) {
  $type_id = $_GET['type_id'];
  $sql = "SELECT * FROM type WHERE type_short_title = ?";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$type_id]);
  $type = $stmt->fetch();
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

<?php include "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="mb-3">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      <?php echo $type['type_title']; ?> [<?php echo $type['type_short_title']; ?>]
    </h1>
  </div>
  <div class="card shadow mb-3">
    <div class="card-body edit-lesson">
      <form action="<?php $_SERVER['PHP_SELF']; ?>" method="POST" id="update-lesson-type">
        <!-- <div class="form-row"> -->
        <div class="form-row error-message error-lesson-type-update">
          <div class="alert alert-danger" role="alert">
          </div>
        </div>
        <div class="form-group required">
          <label for="type-order" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
          <input type="text" name="type-short-title" class="font-weight-normal form-control" value="<?php echo $type['type_short_title']; ?>" readonly>
        </div>
        <div class="form-group required">
          <label for="type-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος:</label>
          <input type="text" name="type-title" id="type-title" class="font-weight-normal form-control" value="<?php echo $type['type_title']; ?>">
        </div>
        <div class="form-group">
          <label for="type-title-en" class="col-form-label font-weight-bold text-gray-800">Τίτλος (EN):</label>
          <input type="text" name="type-title-en" id="type-title-en" class="font-weight-normal form-control" value="<?php echo $type['type_title_eng']; ?>">
        </div>
        <!-- </div> -->
        <button type="submit" name="type-update" class="btn btn-primary float-right">Ενημέρωση</button>
        <input type="reset" class="btn btn-warning float-right mr-3" value="Επαναφορά">
      </form>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>