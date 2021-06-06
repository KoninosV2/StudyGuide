<?php
  include 'includes/dbcon.php';
?>

<?php
  // Πλήθος Μαθηματων
  $sql = "SELECT * FROM ability";
  $stmt = $pdo->prepare($sql);
  $stmt->execute();
  $number_of_abilities = $stmt->rowCount();
  $abilities = $stmt->fetchAll();
?>

<?php
  if(isset($_GET['ability_id'])){
    $ability_id = $_GET['ability_id'];
    $sql = "DELETE FROM ability WHERE ability_short_title = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$ability_id]);
    header('Location: ' . $_SERVER['PHP_SELF']);
  }
  
?>

<?php
  // Εισαγωγή νέου 
  if(isset($_POST['submit'])){
    $id = $_POST['ability-short-title'];
    $order = $_POST['ability-order'];
    $title = $_POST['ability-title'];
    $title_en = $_POST['ability-title-en'];

    $sql = "INSERT INTO ability (ability_title, ability_short_title, ability_title_eng, ability_order) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$title, $id, $title_en, $order]);
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
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Αποκτώμενες Ικανότητες</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php  echo $number_of_abilities; ?></div>
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
        <h1 class="h3 mb-0 text-gray-800">Αποκτώμενες Ικανότητες</h1>
      </div>
      <!-- Πίνακας με τους τρόπους παράδοσης -->
      <div class="shadow">
        <div class="card-header py-3">
          <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#newAbility" role="button" aria-expanded="false" aria-controls="newAbility">
              Νέα Ικανότητα
            </a>
          </p>
          <div class="collapse" id="newAbility">
            <div class="card card-body">
              <form action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" id="new-ability-form">
                <div class="form-row error-message error-new-ability">
									<div class="alert alert-danger" role="alert">
									</div>
							  </div>
                <div class="form-row">
                  <div class="form-group col-md-4 required">
                    <label for="ability-order" class="font-weight-bold text-gray-800 col-form-label">A/A:</label>
                    <input type="text" class="form-control" name="ability-order" id="ability-order">
                  </div>
                  <div class="form-group col-md-4 required">
                    <label for="ability-short-title" class="font-weight-bold text-gray-800 col-form-label">Κωδικός:</label>
                    <input type="text" class="form-control" name="ability-short-title" id="ability-short-title">
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6 required">
                    <label for="ability-title" class="font-weight-bold text-gray-800 col-form-label">Τίτλος:</label>
                    <input type="text" class="form-control" name="ability-title" id="ability-title">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="ability-title-en" class="font-weight-bold text-gray-800 col-form-label">Τίτλος (ΕΝ):</label>
                    <input type="text" class="form-control" name="ability-title-en" id="ability-title-eng">
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
              <table id="adminAbilitiesTable" class="table table-bordered table-hover editTable" style="width:100%">
                <thead>
                  <tr>
                    <th>A/A</th>
                    <th>Κωδικός</th>
                    <th>Τίτλος</th>
                    <th>Τίτλος(En)</th>
                    <th>Τροποποίση</th>
                    <th>Διαγραφή</th>
                  </tr>
                </thead>
                <tbody>
                  <!-- Εμφάνιση δεδομένω από ΒΔ-->
                  <?php
                    foreach($abilities as $ability): 
                  ?>  
                      <tr>
                        <td><?php echo $ability['ability_order']; ?></td>
                        <td><?php echo $ability['ability_short_title']; ?></td>
                        <td><?php echo $ability['ability_title']; ?></td>
                        <td><?php echo $ability['ability_title_eng']; ?></td>
                        <td class='editField'><a href="edit_course_abilities.php?ability_id=<?php echo $ability['ability_short_title'];?>"><i class="far fa-edit text-warning"></i></a></td>
                        <td class='editField'><a href="admin_course_abilities.php?ability_id=<?php echo $ability['ability_short_title'];?>" onclick="return confirm('Είσαι σίγουρος ότι θέλεις να διαγράψεις το αντικείμενο;');"><i class='fas fa-trash-alt delete-item'></i></td>
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
    $('#adminAbilitiesTable').DataTable();
	});
</script>