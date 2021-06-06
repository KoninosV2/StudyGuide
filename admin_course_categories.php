<?php
  include 'includes/dbcon.php';
?>

<?php
  // Πλήθος Μαθηματων
  $sql = "SELECT * FROM lesson_cat";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_categories = $stmt->rowCount();
  $categories = $stmt->fetchAll();
?>

<?php
  if(isset($_GET['category_id'])){
    $category_id = $_GET['category_id'];
    $null = "Null";
    $sql = "UPDATE lesson set cat_id = ? WHERE cat_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$null,$category_id]);

    $sql = "DELETE FROM lesson_cat WHERE cat_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$category_id]);
    header("Location: admin_course_categories.php");
  }
   
?>

<?php
  if(isset($_POST['submit'])){
    $id = $_POST['category-id'];
    $id_en = $_POST['category-id-en'];
    $order = $_POST['category-order'];
    $title = $_POST['category-title'];
    $title_en = $_POST['category-title-en'];

    $sql = "INSERT INTO lesson_cat (cat_title, cat_order, cat_short_title, cat_title_eng, cat_short_title_eng) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $order, $id, $id_en, $title_en]);
    header('Location: ' .$_SERVER["PHP_SELF"]);
  }
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
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Κατηγορίες</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $number_of_categories; ?></div>
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
        <h1 class="h3 mb-0 text-gray-800">Κατηγορίες Μαθημάτων</h1>
      </div>
      <!-- Πίνακας Κατηγοριών -->
      <div class="shadow">
        <div class="card-header py-3">
          <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#newCategory" role="button" aria-expanded="false" aria-controls="newCategory">
              Νέα Κατηγορία
            </a>
          </p>
          <div class="collapse" id="newCategory">
            <div class="card card-body">
              <form action="<?php $_SERVER["PHP_SELF"]; ?>" method="POST" id="new-category-form">
                <div class="form-row error-message error-lesson-category">
									<div class="alert alert-danger" role="alert">
									</div>
							  </div>
                <div class="form-row">
                  <div class="form-group col-md-4 required">
                    <label for="category-id" class="font-weight-bold text-gray-800 col-form-label">A/A:</label>
                    <input type="text" class="form-control" name="category-order" id="category-order">
                  </div>
                  <div class="form-group col-md-4 required">
                    <label for="category-id" class="font-weight-bold text-gray-800 col-form-label">Κωδικός Κατηγορίας:</label>
                    <input type="text" class="form-control" name="category-id" id="category-id">
                  </div>
                  <div class="form-group col-md-4 required">
                    <label for="category-id-en" class="font-weight-bold text-gray-800 col-form-label">Κωδικός Κατηγορίας(En):</label>
                    <input type="text" class="form-control" name="category-id-en" id="category-id-eng">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 required">
                    <label for="category-id" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Κατηγορίας:</label>
                    <input type="text" class="form-control" name="category-title" id="category-title">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="category-id-en" class="font-weight-bold text-gray-800 col-form-label">Τίτλος Κατηγορίας(En):</label>
                    <input type="text" class="form-control" name="category-title-en" id="category-title-eng">
                  </div>
                </div>
                <!-- <div class="form-row"> -->
                  <div class="form-group">
                    <input type="submit" class="btn btn-success float-right" name="submit" id="add-new-category">
                  </div>
                <!-- </div> -->
                
              </form>
            </div>
          </div>
        </div>
        <div class="card-body">
          <div class="table-responsive">
              <table id="adminCategoriesTable" class="table table-bordered table-hover editTable" style="width:100%">
                <thead>
                  <tr>
                    <th>A/A</th>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Τροποποίση</th>
                    <th>Διαγραφή</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση Λίστας Μαθημάτων -->
                  <?php
                    foreach($categories as $category): 
                  ?>  
                      <tr>
                        <td><?php echo $category['cat_order']; ?></td>
                        <td><?php echo $category['cat_short_title']; ?></td>
                        <td><?php echo $category['cat_title']; ?></td>
                        <td class='editField'><a href="edit_course_categories.php?category_id=<?php echo $category['cat_short_title'];?>"><i class="far fa-edit  text-warning"></i></a></td>
                        <td class='editField'><a href="admin_course_categories.php?category_id=<?php echo $category['cat_short_title'];?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις την κατηγορία;');"><i class='fas fa-trash-alt delete-item'></i></td>
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


