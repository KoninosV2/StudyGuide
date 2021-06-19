<?php
include 'includes/dbcon.php';
?>

<?php
if (isset($_POST['create-lesson'])) {
  $lesson_code = $_POST['lesson-code'];
  $lesson_title = $_POST['lesson-title'];
  $lesson_category_id = $_POST['lesson-category'];
  $lesson_semester = $_POST['lesson-semester'];
  $lesson_ects = $_POST['lesson-ects'];
  $lesson_level = $_POST['lesson-level'];
  $lesson_type_id = $_POST['lesson-type'];
  $lesson_language = $_POST['lesson-language'];
  $lesson_erasmus = $_POST['lesson-erasmus'];
  $lesson_url = $_POST['lesson-url'];
  $lesson_teaching_methods = $_POST['lesson-teaching-methods'];
  $lesson_curriculum = $_POST['lesson-curriculum'];
  $lesson_where_teaching_id = $_POST['lesson-where-teaching'];
  $lesson_grade_method = $_POST['lesson-grade-method'];

  if ($lesson_level == "under") {
    $level = "Προπτυχιακό";
  } else {
    $level = "Μεταπτυχιακό";
  }

  $sql = "INSERT INTO lesson (lesson_code, title, cat_id, semester, semester_current, ects, level, lang, curriculum, teaching_method, grade_method, url, where_id, erasmus) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$lesson_code, $lesson_title, $lesson_category_id, $lesson_semester, $lesson_semester, $lesson_ects, $level, $lesson_language, $lesson_curriculum, $lesson_teaching_methods, $lesson_grade_method, $lesson_url, $lesson_where_teaching_id, $lesson_erasmus]);

  $lesson_order = 1;
  $sql = "INSERT INTO type2lesson(lesson_code, type_id, type_order) VALUES(?, ?, ?)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([$lesson_code, $lesson_type_id, $lesson_order]);

  header("Location: edit_lesson.php?lesson_id=" . $lesson_code);
}

?>
<?php include "includes/header.php"; ?>

<!-- Begin Page Content -->
<div class="container-fluid">
  <div class="mb-3">
    <h1 class="h3 mb-0 text-gray-800 font-weight-bold">
      Εισαγωγή νέου Μαθήματος
    </h1>
  </div>
  <div class="card shadow mb-3">
    <div class="card-header">
      <h4 class="font-weight-bold text-primary">Βασικές Πληροφορίες Μαθήματος</h4>
    </div>
    <div class="card-body edit-lesson" id="section-one">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" id="new-lesson-form">
        <div class="form-row error-message error-new-lesson">
          <div class="alert alert-danger" role="alert">
          </div>
        </div>
        <div class="tab">
          <div class="form-row">
            <div class="form-group col-md-3 required">
              <label for="lesson-code" class="col-form-label font-weight-bold text-gray-800">Κωδικός:</label>
              <input type="text" class="form-control" name="lesson-code" id="lesson-code">
            </div>
            <div class="form-group col-md-9 required">
              <label for="lesson-title" class="col-form-label font-weight-bold text-gray-800">Τίτλος Μαθήματος:</label>
              <input type="text" name="lesson-title" id="lesson-title" class="font-weight-normal form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 required">
              <label for="lesson-category" class="col-form-label font-weight-bold text-gray-800">Κατηγορία:</label>
              <select class="form-control" name="lesson-category" id="lesson-category">
                <?php
                // Κατηγορία μαθήματος
                $sql = "SELECT * FROM lesson_cat";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $categories = $stmt->fetchAll();
                foreach ($categories as $cat) {
                  echo "<option value={$cat['cat_short_title']}>{$cat['cat_title']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group col-md-3 required">
              <label for="lesson-semester" class="col-form-label font-weight-bold text-gray-800">Εξάμηνο:</label>
              <input type="text" name="lesson-semester" id="lesson-semester" class="font-weight-normal form-control">
            </div>
            <div class="form-group col-md-3 required">
              <label for="lesson-ects" class="col-form-label font-weight-bold text-gray-800">Μονάδες ECTS:</label>
              <input type="text" name="lesson-ects" id="lesson-ects" class="font-weight-normal form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-4 required">
              <label for="lesson-level" class="col-form-label font-weight-bold text-gray-800">Επίπεδο:</label>
              <select name="lesson-level" id="lesson-level" class="font-weight-normal form-control">
                <option value="under">Προπτυχιακό</option>
                <option value="post">Μεταπτυχιακό</option>
              </select>
            </div>
            <div class="form-group col-md-4 required">
              <label for="lesson-type" class="col-form-label font-weight-bold text-gray-800">Τύπος Μαθήματος:</label>
              <select class="form-control" id="lesson-type" name="lesson-type">
                <?php
                $sql = "SELECT * FROM type";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $types = $stmt->fetchAll();
                foreach ($types as $type) {
                  echo "<option value={$type['type_short_title']}>{$type['type_title']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group col-md-4 required">
              <label for="lesson-language" class="col-form-label font-weight-bold text-gray-800">Γλώσσα Διδασκαλίας:</label>
              <input type="text" name="lesson-language" id="lesson-language" class="font-weight-normal form-control">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6 required">
              <label for="lesson-where-teaching" class="col-form-label font-weight-bold text-gray-800">Τρόπος Παράδοσης:</label>
              <select class="form-control" name="lesson-where-teaching" id="lesson-where-teaching">
                <?php
                // Όλα τα μέρη διδιασκαλίας
                $sql = "SELECT where_title, where_short_title FROM whereteaching";
                $stmt = $pdo->prepare($sql);
                $stmt->execute();
                $where_teaching = $stmt->fetchAll();
                foreach ($where_teaching as $wt) {
                  echo "<option value={$wt['where_short_title']}>{$wt['where_title']}</option>";
                }
                ?>
              </select>
            </div>
            <div class="form-group col-md-6 required">
              <label for="grade-method" class="font-weight-bold text-gray-800 col-form-label">Αξιολόγηση:</label>
              <input type="text" class="form-control" name="lesson-grade-method" id="lesson-grade-method">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="lesson-erasmus" class="col-form-label font-weight-bold text-gray-800">Προσφέρεται σε φοιτητές Erasmus:</label>
              <input type="text" name="lesson-erasmus" id="lesson-erasmus" class="font-weight-normal form-control">
            </div>
            <div class="form-group col-md-6">
              <label for="lesson-url" class="col-form-label font-weight-bold text-gray-800">URL:</label>
              <input type="text" name="lesson-url" id="lesson-url" class="font-weight-normal form-control">
            </div>
          </div>

          <div class="form-group">
            <label for="lesson-teaching-methods" class="col-form-label font-weight-bold text-gray-800">Διδακτικές Δραστηριότητες:</label>
            <textarea class="form-control" name="lesson-teaching-methods" id="lesson-teaching-methods" cols="80" rows="5"></textarea>
          </div>

          <div class="form-group">
            <label for="lesson-curriculum" class="col-form-label font-weight-bold text-gray-800">Περιεχόμενα:</label>
            <textarea class="form-control" name="lesson-curriculum" id="lesson-curriculum" cols="80" rows="5"></textarea>
          </div>
          <button type="submit" name="create-lesson" class="btn btn-primary float-right">Δημιουργία</button>
      </form>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
</div>
<!-- End of Main Content -->
<?php include "includes/footer.php"; ?>